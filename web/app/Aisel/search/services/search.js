'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
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