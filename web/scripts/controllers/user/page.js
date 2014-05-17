'use strict';

angular.module('aiselApp')
    .controller('UserPageCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService' , 'notify' , function ($log, $modal, $scope, $routeParams, userService, notify) {

        $scope.loggedIn = false;

        $scope.tabs = [
            { title:'Dynamic Title 1', content:'Dynamic content 1' },
            { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
        ];

        $scope.alertMe = function() {
            setTimeout(function() {
                alert('You\'ve selected the alert tab!');
            });
        };

    }]);

