<?php namespace Siteshop\Dpd;

use GuzzleHttp\Client;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;

// Validation autoloading
AnnotationRegistry::registerLoader(function ($name) {
	return class_exists($name);
});

class Dpd {

	protected $api_url;

	protected $user;

	protected $pass;

	protected $secret;

	protected $language;

	public function __construct($config)
	{
		$this->api_url = $config['api_url'];
		$this->user = $config['user'];
		$this->pass = $config['pass'];
		$this->secret = $config['secret'];
		$this->language = $config['language'];
	}

	public function generateParcel(Form\ParcelGeneration $form)
	{
		$this->validateForm($form);

		$url  = $this->api_url . 'parcel_interface/parcel_import.php';
		$json = $this->requestJson($url, $form, 'POST', array('content-type' => 'application/x-www-form-urlencoded'));
		$json = array_merge(array(
			'status'    => 'ok',
			'errlog'    => NULL,
			'pl_number' => array()
		), $json);

		if ('ok' != $json[ 'status' ]) throw new Exception\DpdParcelGenerationException($json[ 'errlog' ], json_encode($json));

		return $json[ 'pl_number' ];
	}

	public function getParcelStatus($parcel_number)
	{
		$form = Form\ParcelStatus::newInstance()
			->setSecret($this->secret)
			->setParcelNumber($parcel_number);

		// $this->validateForm($form);

		$url  = $this->api_url . 'parcel_interface/parcel_status.php';

		$response = $this->requestJson($url, $form);

		return $response->json();
	}

	public function printParcel($parcels)
	{
		$url = $this->api_url . 'parcel_interface/parcel_print.php';

		$data = [
			'username' => $this->user,
			'password' => $this->pass,
			'parcels'  => implode('|', $parcels)
		];

		$response = $this->request($url, $data);

		return $response->getHeader('Content-Type') == 'application/pdf' ? $response->getBody() : $response->json();
	}

	public function sendParcels()
	{
		$url = $this->api_url . 'parcel_interface/parcel_datasend.php';

		$data = [
			'username' => $this->user,
			'password' => $this->pass
		];

		$response = $this->requestJson($url, $data);

		return $response;
	}

	public function getTrackingUrl($parcel_number)
	{
		return "https://tracking.dpd.de/cgi-bin/delistrack?pknr=$parcel_number&lang=" . $this->language; //typ = 10 || 31 => CSV
		// return "https://tracking.dpd.de/cgi-bin/delistrack?typ=10&pknr=$parcel_number&lang=$language";
	}

	protected function validateForm(Form $form)
	{
		$validator  = Validation::createValidatorBuilder()
			->enableAnnotationMapping()
			->getValidator();

		$violations = $validator->validate($form);

		if ($violations->count())
			throw new Exception\DpdValidationException($violations);

		return $form;
	}

	protected function requestJson($url, $data = array(), $method = 'POST', array $headers = array('content-type' => 'application/x-www-form-urlencoded'))
	{
		$content = $this->request($url, $data, $method, $headers);

		$json = $content->json();

		if ( ! $json )
			$json = array('errlog' => $content, 'status' => 'err');

		return $json;
	}

	protected function request($url, $data = array(), $method = 'GET', array $headers = array())
	{
		if ($data instanceof Form)
			$data = $data->toArray();

		$options = [
			'query' => $data,
			'headers' => $headers
		];

		$client = new Client();
		$request  = $client->createRequest($method, $url, $options);
		$response = $client->send($request);

		return $response;
	}
}
