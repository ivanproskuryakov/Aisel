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
    app.service('pageService', ['$http', 'Aisel',
        function ($http, Aisel) {
            return {
                getPages: function ($scope) {
                    var locale = Aisel.getLocale();
                    var url = Aisel.settings.api + '/' + locale + '/page/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage + '&category=' + $scope.categoryId;
                    console.log(url);
                    return $http.get(url);
                },
                getPageByURL: function ($url) {
                    var locale = Aisel.getLocale();
                    var url = Aisel.settings.api + '/' + locale + '/page/view/url/' + $url + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});