'use strict';

angular.module('projectxApp')
    .controller('ContactCtrl', ['$location','$scope','$routeParams','contactService', 'notify',function ($location, $scope, $routeParams, contactService, notify) {


        // Submit Contact
        $scope.submitContact = function(form) {
            if (form.$valid) {
                contactService.send(form).success(
                    function(data, status) {
                        notify(data.message);
                    }
                );
            }
        };

        // Get Contact Settings
        contactService.getConfig($scope).success(
            function(data, status) {
                $scope.config = JSON.parse(data.value);
//                console.log($scope.config);
            }
        );


    }]);