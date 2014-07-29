<?php namespace Siteshop\Dpd\Form;

use Siteshop\Dpd\Form;
use Symfony\Component\Validator\Constraints as Assert;

class CollectRequest extends Form {

	/**
	 * Recipient name
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 35)
	 */
	protected $cname;

	/**
	 * Recipient name2 (if needed.)
	 * @Assert\Length(max = 35)
	 */
	protected $cname1;

	/**
	 * Recipient name3 (if needed.)
	 * @Assert\Length(max = 35)
	 */
	protected $cname2;

	/**
	 * Recipient name4 (if needed.)
	 * @Assert\Length(max = 35)
	 */
	protected $cname3;

	/**
	 * Recipient street
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 35)
	 */
	protected $cstreet;

	/**
	 * Recipient city
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 35)
	 */
	protected $ccity;

	/**
	 * Country code in iso2 cha
	 * format (Romania is RO)
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 2)
	 */
	protected $ccountry;

	/**
	 * Recipient postal code
	 *
	 * @Assert\NotBlank
	 * @Assert\Length(max = 9)
	 */
	protected $cpostal;

	/**
	 * Recipient email
	 *
	 * @Assert\Length(max = 40)
	 * @Assert\Email
	 */
	protected $cemail;

	/**
	 * Recipient phone
	 *
	 * @Assert\Length(max = 30)
	 */
	protected $cphone;

	/**
	 * Recipient Info 1, client reference
	 *
	 * @Assert\Length(max = 30)
	 */
	protected $info1;

	/**
	 * Recipient Info 2
	 *
	 * @Assert\Length(max = 30)
	 */
	protected $info2;

	/**
	 * Receiver name. If blank system uses default user info
	 *
	 * @Assert\Length(max = 35)
	 */
	protected $rname;

	/**
	 * Receiver postal code
	 *
	 * @Assert\Length(max = 9)
	 */
	protected $rpostal;

	/**
	 * Receiver city
	 *
	 * @Assert\Length(max = 25)
	 */
	protected $rcity;

	/**
	 * Receiver street
	 *
	 * @Assert\Length(max = 35)
	 */
	protected $rstreet;


	public function __construct($items = null)
	{
		if(is_array($items))
		{
			foreach($items as $key => $value)
				$this->$key = $value;
		}
	}

	/**
	 * Set cname
	 *
	 * @param mixed $cname
	 * @return $this
	 */
	public function setCName($cname)
	{
		$this->cname = $cname;

		return $this;
	}

	/**
	 * Set cname1
	 *
	 * @param mixed $cname1
	 * @return $this
	 */
	public function setCName1($cname1)
	{
		$this->cname1 = $cname1;

		return $this;
	}

	/**
	 * Set cname2
	 *
	 * @param mixed $cname2
	 * @return $this
	 */
	public function setCName2($cname2)
	{
		$this->cname2 = $cname2;

		return $this;
	}

	/**
	 * Set cstreet
	 *
	 * @param mixed $cstreet
	 * @return $this
	 */
	public function setCStreet($cstreet)
	{
		$this->cstreet = $cstreet;

		return $this;
	}

	/**
	 * Set ccity
	 *
	 * @param mixed $ccity
	 * @return $this
	 */
	public function setCCity($ccity)
	{
		$this->ccity = $ccity;

		return $this;
	}

	/**
	 * Set ccountry
	 *
	 * @param mixed $ccountry
	 * @return $this
	 */
	public function setCCountry($ccountry)
	{
		$this->ccountry = $ccountry;

		return $this;
	}

	/**
	 * Set cpostal
	 *
	 * @param mixed $cpostal
	 * @return $this
	 */
	public function setCPostal($cpostal)
	{
		$this->cpostal = $cpostal;

		return $this;
	}

	/**
	 * Set cemail
	 *
	 * @param mixed $cemail
	 * @return $this
	 */
	public function setCEmail($cemail)
	{
		$this->cemail = $cemail;

		return $this;
	}

	/**
	 * Set cphone
	 *
	 * @param mixed $cphone
	 * @return $this
	 */
	public function setCPhone($cphone)
	{
		$this->cphone = $cphone;

		return $this;
	}

	/**
	 * Set info1
	 *
	 * @param mixed $info1
	 * @return $this
	 */
	public function setInfo1($info1)
	{
		$this->info1 = $info1;

		return $this;
	}

	/**
	 * Set info2
	 *
	 * @param mixed $info2
	 * @return $this
	 */
	public function setInfo2($info2)
	{
		$this->info2 = $info2;

		return $this;
	}

	/**
	 * Set rname
	 *
	 * @param mixed $rname
	 * @return $this
	 */
	public function setRName($rname)
	{
		$this->rname = $rname;

		return $this;
	}

	/**
	 * Set rpostal
	 *
	 * @param mixed $rpostal
	 * @return $this
	 */
	public function setRPostal($rpostal)
	{
		$this->rpostal = $rpostal;

		return $this;
	}

	/**
	 * Set rcity
	 *
	 * @param mixed $rcity
	 * @return $this
	 */
	public function setRCity($rcity)
	{
		$this->rcity = $rcity;

		return $this;
	}

	/**
	 * Set rstreet
	 *
	 * @param mixed $rstreet
	 * @return $this
	 */
	public function setRStreet($rstreet)
	{
		$this->rstreet = $rstreet;

		return $this;
	}
}
