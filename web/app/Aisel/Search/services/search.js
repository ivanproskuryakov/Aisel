'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSearch
 * @description     ...
 */

define(['app'], function (app) {
    app.service('searchService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getSearchResult: function ($scope) {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/search/?query=' + $routeParams.query + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});