'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('orderService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getOrders: function ($scope) {
                    var url = API_URL + '/orders.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});