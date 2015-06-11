<?php

namespace SMSApi\Api;

/**
 * Class PhonebookFactory
 * @package SMSApi\Api
 * @deprecated use ContactsFactory
 */
class PhonebookFactory extends ActionFactory {

	/**
	 * @return Action\Phonebook\GroupList
	 */
	public function actionGroupList() {
		$action = new \SMSApi\Api\Action\Phonebook\GroupList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	/**
	 * @param null $groupName
	 * @return Action\Phonebook\GroupAdd
	 */
	public function actionGroupAdd( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupAdd();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->setName( $groupName );
		}

		return $action;
	}

	/**
	 * @param null $groupName
	 * @return Action\Phonebook\GroupEdit
	 */
	public function actionGroupEdit( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupEdit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->filterByGroupName( $groupName );
		}

		return $action;
	}

	/**
	 * @param null $groupName
	 * @return Action\Phonebook\GroupGet
	 */
	public function actionGroupGet( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupGet();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->filterByGroupName( $groupName );
		}

		return $action;
	}

	/**
	 * @param null $groupName
	 * @return Action\Phonebook\GroupDelete
	 */
	public function actionGroupDelete( $groupName = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\GroupDelete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $groupName ) ) {
			$action->filterByGroupName( $groupName );
		}

		return $action;
	}

	/**
	 * @return Action\Phonebook\ContactList
	 */
	public function actionContactList() {
		$action = new \SMSApi\Api\Action\Phonebook\ContactList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	/**
	 * @param null $number
	 * @return Action\Phonebook\ContactAdd
	 */
	public function actionContactAdd( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactAdd();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->setNumber( $number );
		}

		return $action;
	}

	/**
	 * @param null $number
	 * @return Action\Phonebook\ContactEdit
	 */
	public function actionContactEdit( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactEdit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->filterByPhoneNumber( $number );
		}

		return $action;
	}

	/**
	 * @param null $number
	 * @return Action\Phonebook\ContactGet
	 */
	public function actionContactGet( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactGet();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->filterByPhoneNumber( $number );
		}

		return $action;
	}

	/**
	 * @param null $number
	 * @return Action\Phonebook\ContactDelete
	 */
	public function actionContactDelete( $number = null ) {
		$action = new \SMSApi\Api\Action\Phonebook\ContactDelete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $number ) ) {
			$action->filterByPhoneNumber( $number );
		}

		return $action;
	}

}
