# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
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
