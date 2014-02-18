'use strict';

angular.module('projectxApp')
    .controller('UserCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService',function ($log, $modal, $scope, $routeParams, userService) {

        $scope.loggedIn = false;

        // User Registration
        $scope.submitRegistration = function(form) {
            if (form.$valid) {
                // register request
                userService.register($scope).success(
                    function(data, status) {
                        $scope.apiResponse = data;
                    }
                );
            }
        };

        // User Information
        userService.information($scope).success(
            function(data, status) {
                if (data.username) {
                    $scope.loggedIn = true;
                    $scope.user = data;
                }
            }
        );

        // User Sign Out
        $scope.signOut = function () {
            alert('signout');
            userService.signout($scope).success(
                function(data, status) {
                    $log.info(data);
                }
            );
            window.location = "/";
        }

        $scope.open = function () {
            var modalInstance = $modal.open({
                templateUrl: 'views/user/login.html',
                controller: ModalInstanceCtrl,
                resolve: {
                }
            });
        };

    }]);

var ModalInstanceCtrl = function ($scope, $modalInstance, userService) {

    $scope.apiResponse = '';
    $scope.login = function (username, password) {
        console.log( username);
        console.log( password);

        userService.login(username, password).success(
            function(data, status) {
                $scope.apiResponse = data;
                if (data.status) {
                    window.location = "/";
                }
            }
        );
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};