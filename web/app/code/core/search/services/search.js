'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

angular.module('aiselApp')
    .service('searchService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getSearchResult: function ($scope) {
                    var url = API_URL + '/search/?query=' + $routeParams.query + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);