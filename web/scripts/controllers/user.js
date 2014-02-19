'use strict';

angular.module('projectxApp')
    .controller('UserCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService', 'flash' ,function ($log, $modal, $scope, $routeParams, userService, flash ) {

//        flash('test message');

        $scope.loggedIn = false;

        // User Registration
        $scope.submitRegistration = function(form) {
            if (form.$valid) {
                userService.register(form).success(
                    function(data, status) {
                        flash(data.message);
                        if (data.status) {
                            window.location = "/";
                        }
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
            userService.signout($scope).success(
                function(data, status) {
                    flash(data.message);
                    window.location = "/";
                }
            );

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

var ModalInstanceCtrl = function ($scope, $modalInstance, userService, flash) {

    $scope.apiResponse = '';
    $scope.login = function (username, password) {
        console.log( username);
        console.log( password);

        userService.login(username, password).success(
            function(data, status) {
                flash(data.message);
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