<?php

namespace SMSApi\Api\Response;

use SMSApi\Exception\InvalidParameterException;

/**
 * Class ContactResponse
 * @package SMSApi\Api\Response
 */
class ContactResponse extends AbstractResponse {

	const GENDER_FEMALE = "female";
	const GENDER_MALE = "male";

	/**
	 * @var int
	 */
	private $number;

	/**
	 * @var string
	 */
	private $firstName;

	/**
	 * @var string
	 */
	private $lastName;

	/**
	 * @var string
	 */
	private $info;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $birthday;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var string
	 */
	private $gender;

	/**
	 * @var int
	 */
	private $dateAdd;

	/**
	 * @var int
	 */
	private $dateMod;

	/**
	 * @var array
	 */
	private $groups = null;

	public function __construct( $data ) {

		if ( is_object( $data ) ) {
			$this->obj = $data;
		} else if ( is_string( $data ) ) {
			parent::__construct( $data );
		}

		if ( isset( $this->obj->number ) ) {
			$this->number = $this->obj->number;
		}

		if ( isset( $this->obj->first_name ) ) {
			$this->firstName = $this->obj->first_name;
		}

		if ( isset( $this->obj->last_name ) ) {
			$this->lastName = $this->obj->last_name;
		}

		if ( isset( $this->obj->info ) ) {
			$this->info = $this->obj->info;
		}

		if ( isset( $this->obj->birthday ) ) {
			$this->birthday = $this->obj->birthday;
		}

		if ( isset( $this->obj->city ) ) {
			$this->city = $this->obj->city;
		}

		if ( isset( $this->obj->gender ) ) {
			$this->gender = $this->obj->gender;
		}

		if ( isset( $this->obj->date_add ) ) {
			$this->dateAdd = $this->obj->date_add;
		}

		if ( isset( $this->obj->date_mod ) ) {
			$this->dateMod = $this->obj->date_mod;
		}

		if (isset($this->obj->groups)) {
			$this->groups = (array)$this->obj->groups;
		}
	}

	/**
	 * Returns phone number
	 *
	 * @return int
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * Returns contact first name
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Returns contact last name
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Returns contact information text
	 *
	 * @return string
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 * Returns contact e-mail address
	 *
	 * @return string Example: example@smsapi.pl
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Returns contact birthday date
	 *
	 * @return string Example: 1974-1-14
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * Returns contact city name
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Returns contact gender
	 *
	 * @see \SMSApi\Api\Response\ContactResponse::GENDER_FEMALE
	 * @see \SMSApi\Api\Response\ContactResponse::GENDER_MALE
	 * @return string Example male or female
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * Returns create date in timestamp
	 *
	 * @return int date in timestamp
	 */
	public function getDateAdd() {
		return $this->dateAdd;
	}

	/**
	 * Returns modification date in timestamp
	 *
	 * @return int date in timestamp
	 */
	public function getDateMod() {
		return $this->dateMod;
	}

	/**
	 * Returns groups
	 *
	 * @throws InvalidParameterException
	 * @return array with group names
	 */
	public function getGroups()
	{

		if ($this->groups === null) {
			throw new InvalidParameterException('Use action \SMSApi\Api\Action\Phonebook\ContactGet::withGroups() method to load resources with groups');
		}

		return $this->groups;
	}



}
