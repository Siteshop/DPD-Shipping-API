<?php namespace Siteshop\Dpd\Form;

use Siteshop\Dpd\Form;
use Symfony\Component\Validator\Constraints as Assert;

class ParcelGeneration extends Form {

	/**
	 * client’s weblabel username
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 20)
	 */
	protected $username;

	/**
	 * client’s weblabel password
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 20)
	 */
	protected $password;

	/**
	 * Recipient name
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 40)
	 */
	protected $name1;

	/**
	 * Recipient name2 (if needed.)
	 * @Assert\Length(max = 40)
	 */
	protected $name2;

	/**
	 * Recipient street
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 40)
	 */
	protected $street;

	/**
	 * Recipient city
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 40)
	 */
	protected $city;

	/**
	 * Country code in iso2 cha
	 * format (Romania is RO)
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 2)
	 */
	protected $country;

	/**
	 * Recipient postal code
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 9)
	 */
	protected $pcode;

	/**
	 * Recipient email
	 * @Assert\Length(max = 100)
	 *
	 * @Assert\Email
	 */
	protected $email;

	/**
	 * Recipient phone
	 * @Assert\Length(max = 50)
	 */
	protected $phone;

	/**
	 * Recipient mobile phone number
	 * (Required if parcel_type = D-PREDICT)
	 *
	 * @Assert\Length(max = 12)
	 */
	protected $idm_sms_number;

	/**
	 * Delivery instructions for courier
	 * @Assert\Length(max = 100)
	 */
	protected $remark;

	/**
	 * parcel’s weight in Kg
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 4)
	 */
	protected $weight;

	/**
	 * number of parcel labels to be
	 * generated
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 2)
	 */
	protected $num_of_parcel;

	/**
	 * number of swap parcel labels to be
	 * generated
	 *
	 * @Assert\Length(max = 2)
	 */
	protected $exch_num_of_parcel;

	/**
	 * customer’s order number
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 20)
	 */
	protected $order_number;

	/**
	 * Parcel type string: DPD Classic: D,
	 * DPD Classic COD: D-COD. Complete
	 * type list in DPD Weblabel manual.
	 *
	 * @Assert\NotBlank
	 * Assert\Length(max = 10)
	 * Assert\Choice(choices = {"D", "D-COD", "D-SWAP", "D-B2C", "D-SWAP-B2C", "D-COD-B2C", "D-COD-SWAP-B2C", "D-PREDICT", "D-COD-PREDICT", "D-RETURN"})
	 */
	protected $parcel_type;

	/**
	 * This field is made for the COD
	 * amount spliting. The following
	 * values are accepted: avg (the
	 * amount of each parcel will be the
	 * average amount of the given
	 * cod_amount), all (all parcel have the
	 * same amount which is in the
	 * cod_amount field), firstonly (only
	 * the first parcel will have the amount
	 * and the other will be simple DPD
	 * Classic parcel with the additional
	 * options given in the parcel_type
	 * field)
	 * @Assert\Length(max = 9)
	 * @Assert\Choice(choices = {"avg", "all", "firstonly"})
	 */
	protected $parcel_cod_type;

	/**
	 * NotBlank for COD, in destination
	 * country currency.
	 * @Assert\Length(max = 10)
	 */
	protected $cod_amount;

	/**
	 * COD Purpose
	 * @Assert\Length(max = 50)
	 */
	protected $cod_purpose;

	/**
	 * Additional insurance amount
	 * @Assert\Length(max = 5)
	 */
	protected $hins_amount;

	/**
	 * Additional insurance currency
	 * @Assert\Length(max = 3)
	 */
	protected $hins_currency;

	/**
	 * Description of items to be insured
	 * @Assert\Length(max = 35)
	 */
	protected $hins_content;


	public function __construct($items = null)
	{
		if(is_array($items))
		{
			foreach($items as $key => $value)
				$this->$key = $value;
		}
	}

	/**
	 * Set username
	 *
	 * @param mixed $username
	 * @return $this
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Set password
	 *
	 * @param mixed $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Set name1
	 *
	 * @param mixed $name1
	 * @return $this
	 */
	public function setName1($name1)
	{
		$this->name1 = $name1;

		return $this;
	}

	/**
	 * Set name2
	 *
	 * @param mixed $name2
	 * @return $this
	 */
	public function setName2($name2)
	{
		$this->name2 = $name2;

		return $this;
	}

	/**
	 * Set street
	 *
	 * @param mixed $street
	 * @return $this
	 */
	public function setStreet($street)
	{
		$this->street = $street;

		return $this;
	}

	/**
	 * Set city
	 *
	 * @param mixed $city
	 * @return $this
	 */
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * Set country
	 *
	 * @param mixed $country
	 * @return $this
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Set pcode
	 *
	 * @param mixed $pcode
	 * @return $this
	 */
	public function setPcode($pcode)
	{
		$this->pcode = $pcode;

		return $this;
	}

	/**
	 * Set email
	 *
	 * @param mixed $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Set phone
	 *
	 * @param mixed $phone
	 * @return $this
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * Set idm_sms_number
	 *
	 * @param mixed $idm_sms_number
	 * @return $this
	 */
	public function setIdmSmsNumber($idm_sms_number)
	{
		$this->idm_sms_number = $idm_sms_number;

		return $this;
	}

	/**
	 * Set remark
	 *
	 * @param mixed $remark
	 * @return $this
	 */
	public function setRemark($remark)
	{
		$this->remark = $remark;

		return $this;
	}

	/**
	 * Set weight
	 *
	 * @param mixed $weight
	 * @return $this
	 */
	public function setWeight($weight)
	{
		$this->weight = $weight;

		return $this;
	}

	/**
	 * Set num_of_parcel
	 *
	 * @param mixed $num_of_parcel
	 * @return $this
	 */
	public function setNumOfParcel($num_of_parcel)
	{
		$this->num_of_parcel = $num_of_parcel;

		return $this;
	}

	/**
	 * Set exch_num_of_parcel
	 *
	 * @param mixed $exch_num_of_parcel
	 * @return $this
	 */
	public function setExchNumOfParcel($exch_num_of_parcel)
	{
		$this->exch_num_of_parcel = $exch_num_of_parcel;

		return $this;
	}

	/**
	 * Set order_number
	 *
	 * @param mixed $order_number
	 * @return $this
	 */
	public function setOrderNumber($order_number)
	{
		$this->order_number = $order_number;

		return $this;
	}

	/**
	 * Set parcel_type
	 *
	 * @param mixed $parcel_type
	 * @return $this
	 */
	public function setParcelType($parcel_type)
	{
		$this->parcel_type = $parcel_type;

		return $this;
	}

	/**
	 * Set parcel_cod_type
	 *
	 * @param mixed $parcel_cod_type
	 * @return $this
	 */
	public function setParcelCodType($parcel_cod_type)
	{
		$this->parcel_cod_type = $parcel_cod_type;

		return $this;
	}

	/**
	 * Set cod_amount
	 *
	 * @param mixed $cod_amount
	 * @return $this
	 */
	public function setCodAmount($cod_amount)
	{
		$this->cod_amount = $cod_amount;

		return $this;
	}

	/**
	 * Set cod_purpose
	 *
	 * @param mixed $cod_purpose
	 * @return $this
	 */
	public function setCodPurpose($cod_purpose)
	{
		$this->cod_purpose = $cod_purpose;

		return $this;
	}

	/**
	 * Set hins_amount
	 *
	 * @param mixed $hins_amount
	 * @return $this
	 */
	public function setHinsAmount($hins_amount)
	{
		$this->hins_amount = $hins_amount;

		return $this;
	}

	/**
	 * Set hins_currency
	 *
	 * @param mixed $hins_currency
	 * @return $this
	 */
	public function setHinsCurrency($hins_currency)
	{
		$this->hins_currency = $hins_currency;

		return $this;
	}

	/**
	 * Set hins_content
	 *
	 * @param mixed $hins_content
	 * @return $this
	 */
	public function setHinsContent($hins_content)
	{
		$this->hins_content = $hins_content;

		return $this;
	}
}
