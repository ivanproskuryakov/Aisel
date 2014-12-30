'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     API service
 */

define(['app'], function (app) {
    console.log('Kernel API service loaded ...');
    angular.module('app')
        .service('rootService', ['$http', '$rootScope', 'Environment',
            function ($http, $rootScope, Environment) {
                return {
                    getApplicationConfig: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/config/settings.json';
                        // console.log(url);
                        return $http.get(url);
                    },
                    getPageCategoryTree: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/page/category/tree.json';
                        console.log(url);
                        return $http.get(url);
                    },
                    getProductCategoryTree: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/product/category/tree.json';
                        console.log(url);
                        return $http.get(url);
                    },
                    getMenu: function () {
                        var locale = Environment.currentLocale();
                        var url = Environment.settings.api + '/' + locale + '/navigation/menu.json';
                        //console.log(url);
                        return $http.get(url);
                    }
                };
            }
        ]);
});