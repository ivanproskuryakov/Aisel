'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * API service
 */
define(['app'], function (app) {
    console.log('Kernel API service loaded ...');
    angular.module('app')
        .service('rootService', ['$http', '$routeParams', '$rootScope', 'API_URL',
            function ($http, $routeParams, $rootScope, API_URL) {
                return {
                    getApplicationConfig: function () {
                        var url = API_URL + '/config/settings.json';
                        // console.log(url);
                        return $http.get(url);
                    },
                    getCategoryTree: function () {
                        var url = API_URL + '/page/category/tree.json';
                        // console.log(url);
                        return $http.get(url);
                    },
                    getMenu: function () {
                        var url = API_URL + '/navigation/menu.json';
                        // console.log(url);
                        return $http.get(url);
                    },
                    getUserInformation: function () {
                        var url = API_URL + '/user/information.json';
                        // console.log(url);
                        return $http.get(url);
                    }
                };
            }
        ]);
});