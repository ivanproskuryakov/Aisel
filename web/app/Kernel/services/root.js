'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Main service used in app.js
 */
define(['app'], function (app) {
    console.log('Kernel root service loaded ...');
    angular.module('app')
        .service('rootService', ['$http', '$routeParams', '$rootScope', 'API_URL', 'appSettings',
            function ($http, $routeParams, $rootScope, API_URL, appSettings) {
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