# SMSAPI PHP Client

## 1.8.7 - 2018-01-03
* improve POST and PUT requests

## 1.8.6 - 2017-12-11
* add `setNotifyUrl` to `SMSApi\Api\Action\Vms\Send`
* make `ClientTest` executed by default

## 1.8.5 - 2017-06-07
* fix unstable tests

## 1.8.4 - 2017-05-29
* fix fopen problem with connection

## 1.8.3 - 2017-01-09
* fix ContactsException's `getShortMessage()` method to return the `shortMessage` field instead of the `error` field

## 1.8.2 - 2016-11-03
* improve Native proxy implementation

## 1.8.1 - 2016-11-02
* fix fopen problem with Content-Type
* improve HTTP headers

## 1.8.0 - 2016-11-02
* fix Content-Type header usage
* add Client::VERSION
* update User-Agent header
* update README

## 1.7.6 - 2016-10-31
* fix contacts bug

## 1.7.5 - 2016-10-28
* fix package name

## 1.7.4 - 2016-10-11
* improve tests
* improve composer.json

## 1.7.3 - 2016-05-20
* fix ContactResponse
* add x-request-id header

## 1.7.2 - 2016-05-16
* fix Contacts authorization by token

## 1.7.1 - 2016-04-27
* improve Client class

## 1.7.0 - 2016-04-21
* OAuth token support
* fixed tests

## 1.6.3 - 2015-11-23 
* encode sendername

## 1.6.2 - 2015-08-10
* improved README.md
* fixed method names
* removed useless assertions

## 1.6.1 - 2015-08-03
* send DELETE query instead of body

## 1.6.0 - 2015-07-24
* add deleting multiple contacts

## 1.5.1 - 2015-07-23
* cURL fixes

## 1.5.0 - 2015-07-23
* add fetching contacts by ids
* add fetching contacts by group
* add counting contacts

## 1.4.1 - 2015-07-22
* cURL fixes

## 1.4.0 - 2015-07-21
* add contacts support

## 1.3.5 - 2015-07-01
* change default host

## 1.3.4 - 2015-05-13
* restore old autoload

## 1.3.3 - 2015-04-02
* fix details parameter

## 1.3.2 - 2015-04-02
* remove useless method mocks

## 1.3.1 - 2015-04-01
* move ApiGen to Composer and update docs

## 1.3.0 - 2015-03-31
* fix autoload
* cleanup composer
* add support for details parameter
* cleanup CHANGELOG
* update docs
* update phpunit.xml.dist, rename and move to build directory

## 1.2.1 - 2015-03-25

## 1.2.0 - 2014-12-03

## 1.1.0 - 2014-04-23
* add documentation in PHPDoc format.
* refactor and rename some methods [UPGRADE.md](UPGRADE.md)

## 1.0.0 - 2014-03-07
* initialize
