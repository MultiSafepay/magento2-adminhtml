# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Added sensitive and environment types to configuration fields

## [1.2.0] - 2020-12-10
### Added
- Added configuration for in3 payment method
- Add configuration option for choosing default preselected payment method in the checkout

## [1.1.1] - 2020-11-27
### Fixed
- Fixed instantiation error of fileDriver interface in backend and after placing a transaction

## [1.1.0] - 2020-11-11
### Added
- Added Good4Fun gift card to the gift cards configuration
- Added custom description configuration fields
- Added a section in the 'General Information' tab where all the MultiSafepay module versions can be found
- Added a configuration option for using either the base currency or order currency

### Fixed
- Added dependencies in module.xml and composer.json
- Removed setup_version from module
- Enabled all configuration fields to be configured for seperate store views
- Fixed the link to the Github CHANGELOG.md in the 'General Information' tab

### Changed
- Changed the config settings to 'Stores > Settings > Configuration > MultiSafepay' due to exceptionally large POST data 
on the 'Payment Methods' page
- Rebrand Direct Bank Transfer to Request To Pay
- Rebrand Klarna to the latest standards

## [1.0.0] - 2020-09-02
### Added
- First public release
