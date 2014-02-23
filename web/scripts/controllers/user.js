'use strict';

angular.module('projectxApp')
    .controller('UserCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService' ,'notify' ,function ($log, $modal, $scope, $routeParams, userService, notify ) {


        $scope.loggedIn = false;

        // User Registration
        $scope.submitRegistration = function(form) {
            if (form.$valid) {
                userService.register(form).success(
                    function(data, status) {
                        notify(data.message);
                        if (data.status) {
                            window.location = "/";
                        }
                    }
                );
            }
        };

        // User Sign Out
        $scope.signOut = function () {
            userService.signout($scope).success(
                function(data, status) {
                    notify(data.message);
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

var ModalInstanceCtrl = function ($scope, $modalInstance, userService, notify) {
    $scope.login = function (username, password) {

        userService.login(username, password).success(
            function(data, status) {
                notify(data.message);
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