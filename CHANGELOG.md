# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.9.0] - 2021-06-03
### Added
- Added list of all used coupons in payment information block in admin order, if order was paid with giftcards.

## [1.8.0] - 2021-05-12
### Added
- Added notification about new versions of plugin in admin panel.
- Added the possibility to change direct gateway methods to redirect.

## [1.7.0] - 2021-04-09
### Added
- Added option to set no default for default selected payment method.
- Added a download button to download a zip file with the MultiSafepay log files

## [1.6.0] - 2021-03-26
### Added
- Added configuration field for disabling the shopping cart on the MultiSafepay payment page
- Added additional quote masked_id and entity_id parameters to the cancel and success payment urls

## [1.5.0] - 2021-03-11
### Added
- Added configuration for 3 generic gateways and 3 generic giftcards.
- Added setup_version to the module.xml to prevent errors on Magento 2.2.
- Added configuration for a custom pending_payment status.
- Added configuration for custom return and cancel urls for PWA users.

### Changed
- Changed composer dependencies to support Magento 2.2.
- Removed the recurring methods from the default preselected payment method list.

### Fixed
- Fixed a bug where recurring methods that are used for Magento Vault were always active

## [1.4.0] - 2021-02-22
### Added
- Added generic gateway feature for the possibility to add a gateway, which you can customize yourself.
  For more information, please see our [Magento 2 plugin docs](https://docs.multisafepay.com/integrations/plugins/magento2/).
- Added Magento 2 Vault support for credit card payment methods. For more information about the Magento 2 Vault feature, please see [Magento DevDocs](https://devdocs.magento.com/guides/v2.4/payments-integrations/vault/vault-intro.html)
- Added support for Magento 2 Instant Purchases (Works only for Vault supported payment methods). Please see the guide how to use and configure Magento 2 Instant purchase feature in [Magento DevDocs](https://docs.magento.com/user-guide/sales/checkout-instant-purchase.html)
### Changed
- Code refactoring in big parts of the plugin for code improvement, readability and better performance

## [1.3.1] - 2021-02-16
### Fixed
- Alphabetically ordered the payment gateways in the 'Payment Gateways' tab and 'Default selected method' list

## [1.3.0] - 2021-01-26
### Added
- Added sensitive and environment types to configuration fields
- Added configuration field for excluding custom totals

## [1.2.0] - 2020-12-10
### Added
- Added configuration for in3 payment method
- Added configuration option for choosing default preselected payment method in the checkout

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
