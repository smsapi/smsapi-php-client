<?php

namespace SMSApi\Api\Response;

class ContactResponse extends AbstractResponse {

	const GENDER_FEMALE = "female";
	const GENDER_MALE = "male";

	private $number;
	private $firstName;
	private $lastName;
	private $info;
	private $email;
	private $birthday;
	private $city;
	private $gender;
	private $dateAdd;
	private $dateMod;

	function __construct( $data ) {

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
	}

	public function getNumber() {
		return $this->number;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function getInfo() {
		return $this->info;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getBirthday() {
		return $this->birthday;
	}

	public function getCity() {
		return $this->city;
	}

	public function getGender() {
		return $this->gender;
	}

	public function getDateAdd() {
		return $this->dateAdd;
	}

	public function getDateMod() {
		return $this->dateMod;
	}

}
