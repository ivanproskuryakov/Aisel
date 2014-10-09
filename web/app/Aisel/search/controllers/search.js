'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('SearchCtrl', ['$scope', '$routeParams', 'searchService',
        function ($scope, $routeParams, searchService) {
            $scope.queryText = $routeParams.query;
            $scope.search = $routeParams.query;
            $scope.limit = 5;
            $scope.paginationPage = 1;
            $scope.results = {};
            $scope.results.total = 0;

            var handleSuccess = function (data, status) {
                $scope.results = data;
            };
            searchService.getSearchResult($scope).success(handleSuccess);

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                searchService.getSearchResult($scope).success(handleSuccess);
            };
        }]);
});