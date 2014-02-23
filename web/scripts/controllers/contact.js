'use strict';

angular.module('projectxApp')
    .controller('ContactCtrl', ['$location','$scope','$routeParams','contactService','appConfig', 'notify',function ($location, $scope, $routeParams, contactService,appConfig, notify) {

        appConfig.success(
            function(data, status) {
                $scope.config = JSON.parse(data.config_contact);
            }
        );

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

    }]);