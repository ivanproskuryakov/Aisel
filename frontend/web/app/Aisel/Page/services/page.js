'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     ...
 */

define(['app'], function (app) {
    app.service('pageService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getPages: function ($scope) {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/page/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage + '&category=' + $scope.categoryId;
                    console.log(url);
                    return $http.get(url);
                },
                getPageByURL: function ($url) {
                    var locale = Environment.currentLocale();
                    var url = Environment.settings.api + '/' + locale + '/page/view/url/' + $url + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});