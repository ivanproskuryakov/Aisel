'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('cartService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getCartItems: function ($scope) {
                    var url = API_URL + '/cart.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});