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
    app.service('orderService', ['$http', 'Env',
        function ($http, Env) {
            return {
                getOrders: function () {
                    var url = Env.api + '/orders/my';
                    return $http.get(url);
                },
                getOrder: function (orderId) {
                    var url = Env.api + '/order/' + orderId;
                    return $http.get(url);
                }
            };
        }
    ]);
});
