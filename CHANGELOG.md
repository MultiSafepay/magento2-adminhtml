# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.33.0] - 2025-05-20
### Removed
- DAVAMS-901: Removed configurations for the deprecated payment method 'Alipay'

## [1.32.1] - 2025-05-01
### Fixed
- PLGMAG2V2-842: Fix PHP 8.4 deprecations

### Changed
- MAGWIRE-32: Use GenericGatewayUtil instead of GenericGatewayConfigProvider

## [1.32.0] - 2025-04-02
### Added
- PLGMAG2V2-831: Added invoice_url to invoice update request for E-invoicing
- PLGMAG2V2-832: Added setting for adding iDEAL payment page step

### Removed
- PLGMAG2V2-838: Removed .svg as allowed file type for generic gateway image upload

## [1.31.1] - 2025-02-24
### Changed
- PLGMAG2V2-829: Enable Sofort and Dotpay payment methods

## [1.31.0] - 2025-01-09
### Added
- DAVAMS-852: Added the Billink payment method
- DAVAMS-817: Added the Bizum payment method
- PLGMAG2V2-788: Added a setting for adding coupon names to item names
- PLGMAG2V2-814: Added a instructions configuration field to all the payment methods

### Removed
- PLGMAG2V2-810: Removed configurations for the following deprecated methods: Santander, Giropay, Sofort, Request to pay and Dotpay

## [1.30.0] - 2024-08-30
### Added
- PLGMAG2V2-779: Added payment component for BNPL methods

## [1.29.0] - 2024-07-05
### Added
- PLGMAG2V2-741: Added Manual Capture support for the Card payment, Visa, Mastercard and Maestro gateways. For more information about this feature, please check the [MultiSafepay Manual Capture documentation](https://docs.multisafepay.com/docs/manual-capture).
- PLGMAG2V2-760: Added to the order payment description with which type of card was paid for the Card Payment method

## [1.28.0] - 2024-05-15
### Added
- DAVAMS-764: Add in3 B2B

## [1.27.1] - 2024-05-01
### Changed
- PLGMAG2V2-739: PayPal, AliPay, AliPay Plus, CBC, KBC and Trustly now have the option to redirect to the MultiSafepay payment page when placing the order

## [1.27.0] - 2024-04-02
### Added
- PLGMAG2V2-731: Added VVV Cadeaubon gateway
- DAVAMS-733: Added Pay After Delivery (BNPL_MF) gateway

## [1.26.0] - 2024-02-16
### Added
-DAVAMS-716: Add Multibanco
-DAVAMS-724: Add MB WAY

## [1.25.2] - 2024-01-24
### Changed
- PLGMAG2V2-718: Remove gateway codes from Edenred title

## [1.25.1] - 2023-12-28
### Removed
- DAVAMS-708: Removed Santander Betaal Per Maand

## [1.25.0] - 2023-11-30
### Added
- DAVAMS-531: Added an advanced setting for adding a template ID to be used for payment components
- DAVAMS-596: Added a setting to choose SVG icons instead PNG.

## [1.24.0] - 2023-10-11
### Added
- PLGMAG2V2-700: Added Edenred Consumption Voucher (EDENCONSUM)
- DAVAMS-661: Added the Zinia payment method

## [1.23.3] - 2023-09-04
### Changed
- PLGMAG2V2-680: Replaced var with let in validate API key button function

### Removed
- PLGMAG2V2-676: Removed unused getCheckButtonId() function

## [1.23.2] - 2023-07-17
### Removed
- PLGMAG2V2-674: Removed use of SecureHtmlRenderer to be backwards compatible with version 2.3

## [1.23.1] - 2023-06-13
### Changed
- DAVAMS-607: Changed the 'Credit Card' method default title to 'Card Payment' according to the latest standards

### Removed
- PLGMAG2V2-669: Removed the setup_version from the module.xml

## [1.23.0] - 2023-05-17
### Added
- PLGMAG2V2-657: Give the option for 3 different credit card icons
- PLGMAG2V2-661: Add payment component for Pay After Delivery installments
- PLGMAG2V2-667: Add a setting field to exclude utm_nooverridefrom the redirect_url.

### Changed
- PLGMAG2V2-653: Rebrand Sofort
- PLGMAG2V2-632: Refactor Credit Card Payment Components

## [1.22.1] - 2023-04-03
### Changed
- PLGMAG2V2-656: Bump core module dependency version

## [1.22.0] - 2023-03-07
### Added
- Added configuration for the Pay After Delivery installments payment method

### Fixed
- Fixed missing checkbox in rare cases for placing a transaction with iDEAL and Direct Debit Vault
- Fixed broken docs links for Apple Pay Direct

### Changed
- Removed the PWA mention from the custom url labels, since that functionality is not only available when using a PWA

### Removed
- Copyright mention has been removed from the files and is only mentioned from now on in the disclaimer. Please read it if you haven't already

## [1.21.2] - 2022-12-07
### Fixed
- Made all the config field labels translatable

### Changed
- Rebrand AfterPay to Riverty
- Changed labels of when to send the order confirmation email

## [1.21.1] - 2022-10-24
### Fixed
- Fixed references related to the E-Invoicing configurable 'account_number' field

## [1.21.0] - 2022-10-04
### Added
- Added Amazon Pay.
- Added an option for E-invoicing to assign collecting flow ids to specific customer groups.
- Added an option for E-invoicing to turn on and off certain checkout fields.

## [1.20.0] - 2022-08-23
### Added
- Added the MyBank payment method

### Fixed
- Fixed dead docs links in the configuration and support page

### Removed
- Removed payment method docs links

## [1.19.0] - 2022-07-11
### Added
- Added a configuration option for overriding when to send the order confirmation e-mail for pay later methods

## [1.18.0] - 2022-06-29
### Added
- Added Vault for Maestro
- Added Tokenization (embedded) for the following gateways:
  - American Express
  - Credit Card
  - Maestro
  - Mastercard
  - Visa
- Added the Alipay+ payment method

### Fixed
- Fixed the sorting of the generic gateways to be always at the bottom
- Fixed field dependencies of all the gateways to always depend on the 'active' field

### Changed
- Changed the styles and images according to the new rebranding guidelines

## [1.17.0] - 2022-04-28
### Added
- Added an option to skip the bank details page after placing an order for the Bank Transfer payment method

### Changed
- Removed configuration settings for ING Home'Pay
- Added changes that are required for PHP 8.1:
  - Added null coalescing operator for when haystack parameter for the strpos() function is null

## [1.16.0] - 2022-01-11
### Added
- Added options for selecting separate order status for different MultiSafepay statuses
- Added options for selecting separate behaviours of cancelling MutliSafepay order payment link

### Fixed
- Fixed an issue where validate API key button uses default store view always (Thanks to @thlassche)
- Fixed an issue where encrypted password doesn't get correct

## [1.15.0] - 2021-11-30
### Added
- Added a separate option for when to send the order confirmation email for the Bank Transfer payment method
- Added a button to verify the API Key before saving the config.

### Changed
- Changed the API Key fields to be obscured for added security, they are now also stored with encryption provided by the Encryptor from the Magento Framework

## [1.14.0] - 2021-10-29
### Added 
- Added configuration for Edenred
- Added configuration for iDEAL and Direct Debit Vault

### Fixed
- Fixed an issue with Vault and Manual capture
- Fixed an issue where the transaction type for Direct Debit would not be saved

## [1.13.0] - 2021-10-15
### Added
- Added configuration for Apple Pay Direct
- Added configuration for Google Pay
- Added configuration for WeChat Pay

## [1.12.0] - 2021-08-27
### Changed
- Dropped support for Magento 2.2.x versions.
- Changed event listeners from controller_action_predispatch to backend_auth_user_login_success for checking the new released plugin versions. (Thanks to @Tjitse-E)
- Improved the UX/UI for General Information page

### Fixed
- Fixed PHP Mess detector issues.

## [1.11.0] - 2021-07-30
### Added
- Added setting for possibility to skip automatic invoice creation after MultiSafepay payment.

### Changed
* Improved several UI and UX elements:
  - Added a notice with a link to the MultiSafepay Merchant Control Panel under the API key field
  - Added enabled/disabled indicators next to the gateways and giftcards
  - Added a MultiSafepay mention to the Payment configuration page at *Stores > Configuration > Sales > Payment Methods* with a link to sign up. Clicking on configuration will redirect to the MultiSafepay General Settings page

## [1.10.0] - 2021-06-17
### Added
- Added support MultiSafepay Credit Card component support for credit card payment methods.

### Fixed
- Fixed support page typo's.

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
