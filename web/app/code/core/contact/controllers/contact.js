'use strict';

angular.module('aiselApp')
    .controller('ContactCtrl', ['$location', '$scope', '$routeParams', 'contactService', 'rootService', 'notify',
        function ($location, $scope, $routeParams, contactService, rootService, notify) {

            $scope.config = false;

            rootService.getApplicationConfig().success(
                function (data, status) {
                    $scope.config = JSON.parse(data.config_contact);
                }
            );

            // Submit Contact
            $scope.submitContact = function (form) {
                if (form.$valid) {
                    contactService.send(form).success(
                        function (data, status) {
                            notify(data.message);
                        }
                    );
                }
            };

        }]);