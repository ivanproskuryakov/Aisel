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

define(['app'], function (app) {
    app.service('checkoutService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                init: function () {
                    var url = Environment.settings.api + '/order/checkout/init.json';
                    console.log(url);
                    return $http.get(url);
                },
                orderSubmit: function () {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/order/submit.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});