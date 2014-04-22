# Upgrade to 1.1.0

## Deprecated methods.

*It will be removed without replacement in 1.2.0*

Refactored and renamed in namespace SMSApi\Api\Action\Sms

- Get::id() use Get::filterById()
- Get::ids() use Get::filterByIds()
- Delete::id() use Delete::filterById()
- Delete::ids() use Delete::filterByIds()

Refactored and renamed in namespace SMSApi\Api\Action\Mms

- Get::id() use Get::filterById()
- Get::ids() use Get::filterByIds()
- Delete::id() use Delete::filterById()
- Delete::ids() use Delete::filterByIds()

Refactored and renamed in namespace SMSApi\Api\Action\Vms

- Get::id() use Get::filterById()
- Get::ids() use Get::filterByIds()
- Delete::id() use Delete::filterById()
- Delete::ids() use Delete::filterByIds()

Refactored and renamed in namespace SMSApi\Api\Action\Sender

- Delete::setSender() use Delete::filterBySenderName()

Refactored and renamed in namespace SMSApi\Api\Action\Phonebook

- ContactList::setNumber() use ContactList::filterByPhoneNumber()
- ContactList::setGroup() use ContactList::filterByGroup()
- ContactList::setGroups() use ContactList::filterByGroups()
- ContactList::setGender() use ContactList::filterByGender()
- ContactList::setText() use ContactList::search()
- ContactGet::setContact() use ContactGet::filterByPhoneNumber()
- ContactEdit::setContact() use ContactEdit::filterByPhoneNumber()
- GroupDelete::setGroup() use ContactEdit::filterByGroupName()
- GroupGet::setGroup() use GroupGet::filterByGroupName()

Refactored and renamed in namespace SMSApi\Api\Action\User

- Add::setPhonebook() use Add::setFullAccessPhoneBook()
- Add::setSenders() use Add::setFullAccessSenderNames()
- Edit::setUsername() use Edit::filterByUsername()
- Get::setUsername() use Get::filterByUsername()


Refactored and renamed in namespace SMSApi\Api\Response

- UserResponse::getActive() use UserResponse::isActive()
- UserResponse::getPhonebook() use UserResponse::hasFullAccessPhoneBook()
- UserResponse::getSenders() use UserResponse::hasFullAccessSenderNames()
- GroupResponse::getNumbers() use GroupGet::getNumbersCount()