<?php

namespace SMSApi\Api;

class PhonebookFactory extends ActionFactory {

	public function actionGroupList() {
		$action = new \SMSApi\Api\Action\Phonebook\GroupList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	public function actionGroupAdd( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupAdd();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->setName( $groupName );
		}

		return $action;
	}

	public function actionGroupEdit( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupEdit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->setGroup( $groupName );
		}

		return $action;
	}

	public function actionGroupGet( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupGet();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->setGroup( $groupName );
		}

		return $action;
	}

	public function actionGroupDelete( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupDelete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->setGroup( $groupName );
		}

		return $action;
	}

	public function actionContactList() {
		$action = new \SMSApi\Api\Action\Phonebook\ContactList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	public function actionContactAdd( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactAdd();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->setNumber( $number );
		}

		return $action;
	}

	public function actionContactEdit( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactEdit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->setContact( $number );
		}

		return $action;
	}

	public function actionContactGet( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactGet();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->setContact( $number );
		}

		return $action;
	}

	public function actionContactDelete( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactDelete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->setContact( $number );
		}

		return $action;
	}

}
