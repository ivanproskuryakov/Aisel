'use strict';

angular.module('aiselApp')
    .controller('UserPageListCtrl', ['$location', '$log', '$modal', '$scope', '$routeParams', 'userService' , 'userPageService' , 'notify' ,
        function ($location, $log, $modal, $scope, $routeParams, userService, userPageService, notify) {

        $scope.loggedIn = false;


        $scope.pageLimit = 5;
        $scope.paginationPage = 1;
        $scope.categoryId = 0;
        $scope.userId = 31;
        var handleSuccess = function (data, status) {
            $scope.pageList = data;
        };

        // Pages
        userPageService.getPages($scope).success(
            function (data, status) {
                $scope.pageList = data;
            }
        );

        $scope.pageChanged = function (page) {
            $scope.paginationPage = page;
            userPageService.getPages($scope).success(
                function (data, status) {
                    $scope.pageList = data;
                }
            );
        };



    }]);
