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
 * @description     ...
 */

define(['app'], function (app) {
    app.service('orderService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getOrders: function () {
                    var url = Environment.settings.api + '/orders.json';
                    console.log(url);
                    return $http.get(url);
                },
                getOrder: function (orderId) {
                    var url = Environment.settings.api + '/order/view/' + orderId + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});