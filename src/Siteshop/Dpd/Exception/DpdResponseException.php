<?php namespace Siteshop\Dpd\Exception;

use Siteshop\Dpd\Exception;

abstract class DpdResponseException extends Exception {

	public function __construct($message, $response = NULL)
	{
		$string = $message;

		if ($response)
			$string .= " ($response)";

		parent::__construct($string);
	}
}
