# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [3.0.6] - 2022-03-28
### Fixed
- HTTP headers parsing, PSR-7 compliant

## [3.0.5] - 2022-03-23
### Fixed
- HTTP headers parsing, `HttpClient` issue

## [3.0.4] - 2022-01-17
### Added
- `psr/log` v2, v3 support

## [3.0.3] - 2021-07-21
### Fixed
- Guzzle PSR7 incompatible URI paths, `The path of a URI with an authority must start with a slash "/" or be empty`

## [3.0.2] - 2021-01-29
### Added
- PHP-8 support

## [3.0.1] - 2020-12-08
### Changed
- Guzzle HTTP helpers marked as optional dependency

## [3.0.0] - 2020-11-19
### Added
- PSR-18 support
- PSR-17 support

### Changed
- utf-8 as default encoding
- `CreateContactBag::withPhone` marked as deprecated
- `PingFeature::ping` returns authorization and service availability status

### Removed
- built-in proxy support - use own implementation
- concrete HTTP client dependency (Guzzle 6)
- `PushFeature`
- `SendSmsBag::setIdx`
- `DeleteSmsBag`
- `FindSendernamesBag`

## [2.6.1] - 2020-05-14
### Fixed
- undelivered messages contact field support

## [2.6.0] - 2020-01-31
### Added
- generation and verification of MFA codes implement
- `MfaFeature` uses mfa endpoint

## [2.5.0] - 2020-01-14
### Added
- custom contact fields support
### Changed
- `PingFeature` uses ping endpoint

## [2.4.0] - 2019-12-30
### Added
- `BlacklistFeature`

## [2.3.4] - 2019-10-16
### Fixed
- `ApiErrorException` when error undefined

## [2.3.3] - 2019-06-18
### Added
- `DeleteScheduledSmssBag` that replaces deprecated `DeleteSmsBag`

### Changed
- `DeleteSmsBag` marked as deprecated

## [2.3.2] - 2019-06-17
### Fixed
- `SmsFeature::deleteScheduledSms`

## [2.3.1] - 2019-05-07
### Changed
- `PushFeature` marked as deprecated

## [2.3.0] - 2019-04-16
### Added
- `ContactsFeature::deleteContacts`

## [2.2.0] - 2019-04-12
### Changed
- `ContactsFeature::findContacts` parameter bag made optional

## [2.1.3] - 2019-04-11
### Fixed
- `CreateContactBag::withPhone`

## [2.1.2] - 2019-03-25
### Added
- api error exception error
### Changed
- api error exception messages
### Fixed
- `CreateContactBag::withPhoneNumber` method is deprecated, use `CreateContactBag::withPhone` instead

## [2.1.1] - 2019-02-19
### Fixed
- sms content parts

## [2.1.0] - 2019-02-07
### Added
- sending sms to many recipients at once
- sms details
- update subuser feature
- find contact groups feature
### Fixed
- sms params
- sending sms with external id (idx)
- decimal subuser points
- marks `FindSendernamesBag` as deprecated

## [2.0.0] - 2018-10-30
### Added
- support for `Ping`
- basic support for `Push`
- basic support for `Short Url`
- new `Contacts` resources
- `psr/log` support
- support for `proxy servers`
- support for `PHP v7`
### Changed
- library is rewritten from-scratch
- `user.do` is superseded by `profile` and `subusers`
- `sender.do` is superseded by `sms/sendernames`
- `curl` and `native` HTTP transport is superseded by `guzzlehttp/guzzle`
### Removed
- `Basic` authorization
- support for `PHP v5`
