'use strict';

/**
 * @ngdoc overview
 * @name Aisel
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
                    getPageCategoryTree: function () {
                        var locale = Aisel.getLocale();
                        var url = API_URL + '/' + locale + '/page/category/tree.json';
                        console.log(url);
                        return $http.get(url);
                    },
                    getProductCategoryTree: function () {
                        var locale = Aisel.getLocale();
                        var url = API_URL + '/' + locale + '/product/category/tree.json';
                        console.log(url);
                        return $http.get(url);
                    },
                    getMenu: function () {
                        var locale = Aisel.getLocale();
                        var url = API_URL + '/' + locale + '/navigation/menu.json';
                        console.log(url);
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