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

		$json = $this->requestJson($url, $form);

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

	public function getParcelLabel($parcels)
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

	public function getParcelManifest($date, $type = 'manifest')
	{
		$url = $this->api_url . 'parcel_interface/parcel_manifest_print.php';

		$data = [
			'username' => $this->user,
			'password' => $this->pass,
			'type'     => $type,
			'date'	   => $date
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

	public function sendCollectRequest($requests)
	{
		$data = [];

		if( ! isset($requests[0]))
		{
			$requests = array($requests);
		}

		foreach($requests as $k => $request)
		{
			$form = new Form\CollectRequest($request);

			//$this->validateForm($form);

			foreach($request as $key => $value)
			{
				$data[$key . '_' . $k] = $value;
			}
		}

		$url  = $this->api_url . 'cr/cr_applet_upload.php';

		$response = $this->requestJson($url, $form, 'POST', array('content-type' => 'application/x-www-form-urlencoded'), array($this->user, $this->pass));

		return $response;
	}

	public function zipCodeFinder($city, $county, $street, $street_no = null)
	{
		$url = $this->api_url . 'parcel_interface/postal_code_info.php';

		$data = [
			'currlang'		=>	$this->language,
			'secret'		=>	$this->secret,
			'city'			=>	$city,
			'county'		=>	$county,
			'street'		=>	$street,
			'street_number'	=>	$street_no
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

	protected function requestJson($url, $data = array(), $method = 'POST', array $headers = array('content-type' => 'application/x-www-form-urlencoded'), $auth = array())
	{
		$content = $this->request($url, $data, $method, $headers, $auth);

		$json = $content->json();

		if ( ! $json )
			$json = array('errlog' => $content, 'status' => 'err');

		return $json;
	}

	protected function request($url, $data = array(), $method = 'POST', array $headers = array(), array $auth = array())
	{
		if ($data instanceof Form)
			$data = $data->toArray();

		$options = [
			'query' => $data,
			'headers' => $headers
		];

		if( ! empty($auth) )
		{
			$options['auth'] = $auth;
		}

		$client = new Client();
		$request  = $client->createRequest($method, $url, $options);
		$response = $client->send($request);

		return $response;
	}
}
