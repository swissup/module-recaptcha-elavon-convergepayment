# ReCAPTCHA for Elavon_ConvergePayment

This integration required when customer uses new credit card on checkout with Elavon ConvergePayment. 
It adds server side recaptcha verification and JS mixins for reCapctha.

### Installation

```
cd <magento_root>
composer config repositories.swissup-recaptcha-elavon-convergepayment vcs git@github.com:swissup/module-recaptcha-elavon-convergepayment.git
composer require swissup/module-recaptcha-elavon-convergepayment
bin/magento setup:upgrade
```
