# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.4] - 2018-06-21
### Fixed
- Compiler: Due to template-related issues, we switched translation caching from Compiler generation to Compiler engine (on rendering)

## [0.3.3] - 2018-06-05
### Added
- Route managment for translated urls

## [0.3.2] - 2018-06-04
### Added
- Excluded urls managment

## [0.3.1] - 2018-05-31
### Fixed
- composer illuminate/filesystem dependency downgrade (for more PHP support)

## [0.3.0] - 2018-05-28
### Added
- Package Auto Discovery
- Independant Cache managment (& Facade) with new command to clear it
- Prefix path managment
### Changed
- Updating `composer.json`

## [0.2.1] - 2018-05-16
### Changed
- Composer package name

## [0.2.0] - 2018-05-15
### Added
- Custom user-agent injection
- Method to find & parse `__()` & `trans()` PHP tags
### Changed
- Upgrading library version
- Implementing Util.Url class

## [0.1.2] - 2018-05-07
### Added
- README: Slack tag
### Changed
- PHP library version

## [0.1.1] - 2018-05-04
### Added
- Compiler: Overwriting @lang behavior

## [0.1] - 2018-05-02
### Added
- Managing Laravel Cache service as PSR-6 Adapter
- Rewriting all routes with locale prefixes
- Adding helpers functions to use them in blade templates
