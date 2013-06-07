<?php

namespace SMSApi\Exception;

class SmsapiException extends \Exception {

	public static function isClientError( $code ) {


		switch ( $code ) {
			case 101:
			case 102:
			case 103:
			case 105:
			case 110:
			case 1000:
			case 1001:
				return true;
		}

		return false;
	}

	public static function isHostError( $code ) {

		switch ( $code ) {
			case 8:
			case 201:
			case 666:
			case 999:
				return true;
		}

		return false;
	}

}
