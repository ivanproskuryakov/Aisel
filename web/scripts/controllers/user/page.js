'use strict';

angular.module('aiselApp')
    .controller('UserPageCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService' ,'userPageService' , 'notify' , function ($log, $modal, $scope, $routeParams, userService, userPageService, notify) {

//        $scope.loggedIn = false;
//
//        $scope.tabs = [
//            { title:'Dynamic Title 1', content:'Dynamic content 1' },
//            { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
//        ];
//
//        $scope.alertMe = function() {
//            setTimeout(function() {
//                alert('You\'ve selected the alert tab!');
//            });
//        };

        var pageId = $routeParams.pageId;

        if (pageId) {
            var handleSuccess = function(data, status) {
                $scope.pageDetails = data;
//                console.log(data);
            };
            userPageService.getPageById(pageId).success(handleSuccess);
        } else {
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;
            $scope.userId = 31;
            var handleSuccess = function(data, status) {
                $scope.pageList = data;
            };

            // Pages
            userPageService.getPages($scope).success(
                function(data, status) {
                    $scope.pageList = data;
                }
            );

            $scope.pageChanged = function(page) {
                $scope.paginationPage = page;
                userPageService.getPages($scope).success(
                    function(data, status) {
                        $scope.pageList = data;
                    }
                );
            };

        }

    }]);

