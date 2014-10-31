'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('PageCtrl', ['$location', '$scope', '$routeParams', 'pageService', 'categoryService',
        function ($location, $scope, $routeParams, pageService, categoryService) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            var handleSuccess = function (data, status) {
                $scope.pageList = data;
            };

            // Pages
            pageService.getPages($scope).success(
                function (data, status) {
                    $scope.pageList = data;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                pageService.getPages($scope).success(
                    function (data, status) {
                        $scope.pageList = data;
                    }
                );
            };

        }]);
});