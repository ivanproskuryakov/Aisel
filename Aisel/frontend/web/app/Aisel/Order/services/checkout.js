'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselOrder
 * @description     Checkout service
 */

define(['app'], function(app) {
    app.service('checkoutService', ['$http', 'Env',
        function($http, Env) {
            return {
                init: function() {
                    var locale = Env.currentLocale();
                    var url = Env.api + '/' + locale + '/order/checkout';
                    console.log(url);
                    return $http.get(url);
                },
                orderSubmit: function(form) {
                    var formData = {};
                    formData['billing_country'] = encodeURIComponent(form.billing_country.$modelValue);
                    formData['billing_region'] = encodeURIComponent(form.billing_region.$modelValue);
                    formData['billing_city'] = encodeURIComponent(form.billing_city.$modelValue);
                    formData['billing_phone'] = encodeURIComponent(form.billing_phone.$modelValue);
                    formData['billing_comment'] = encodeURIComponent(form.billing_comment.$modelValue);
                    formData['payment_method'] = encodeURIComponent(form.payment_method.$modelValue);

                    var locale = Env.currentLocale();
                    var url = Env.api + '/' + locale + '/order';
                    console.log(formData);
                    console.log(url);
                    return $http.post(url, formData);
                },
                getCountries: function() {
                    var url = Env.api + '/addressing/country';
                    console.log(url);
                    return $http.get(url);
                },
                getRegions: function() {
                    var url = Env.api + '/addressing/region';
                    console.log(url);
                    return $http.get(url);
                },
                getCities: function() {
                    var url = Env.api + '/addressing/city';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }
    ]);
});
