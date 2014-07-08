<?php namespace Siteshop\Dpd\Exception;

use Siteshop\Dpd\Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class DpdValidationException extends Exception {

	public function __construct(ConstraintViolationListInterface $violations)
	{
		parent::__construct((string) $violations);
	}

}