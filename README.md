# Custom Currency Magento 2 Extension

Extension allows to add any custom currency to Magento 2.

## Table of contents

* [Features](#features)
* [Installation](#installation)
* [Add New Currency](#add-new-currency)
* [Author](#author)
* [License](#license)

## Features

- Add as many currencies as you want.
- Customize precision (decimal places), output format, symbol etc.
- Preloaded with some top cryptocurencies like *Ethereum (ETH)*, *Polygon (Matic)*, *USDT*, *USDC*.

## Installation

Install module:

`composer require cryptom2/magento-custom-currency:v1.0.0`

And run

```php
php bin/magento setup:upgrade
```

## Add New Currency

- Go to `Stores->Crypto->Custom Currencies`
- Click `Add New Currency`
- Fill data and save


![Magento 2 Custom Currency](https://raw.githubusercontent.com/torys877/magento-custom-currency/main/docs/add_currency.png)

## Author

### Ihor Oleksiienko

* [Github](https://github.com/torys877)
* [Linkedin](https://www.linkedin.com/in/igor-alekseyenko-77613726/)
* [Facebook](https://www.facebook.com/torysua/)

## License

Extension is licensed under the MIT License - see the LICENSE file for details
