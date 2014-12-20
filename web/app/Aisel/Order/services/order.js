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
    app.service('orderService', ['$http', 'API_URL',
        function ($http, API_URL) {
            return {
                getOrders: function () {
                    var url = API_URL + '/orders.json';
                    console.log(url);
                    return $http.get(url);
                },
                getOrder: function (orderId) {
                    var url = API_URL + '/order/view/' + orderId + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});