/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

var config = {
    map: {
        '*': {
            'Magento_Catalog/js/price-utils':'Crypto_Currency/js/price-utils'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/price-box': {
                'Crypto_Currency/js/custom-price-box': true
            }
        }
    }
};
