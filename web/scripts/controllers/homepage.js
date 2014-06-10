'use strict';

angular.module('aiselApp')
    .controller('MainCtrl', ['$location', '$scope', '$routeParams', 'rootService',
        function ($location, $scope, $routeParams, rootService) {

            $scope.content = false;
            rootService.getApplicationConfig().success(
                function (data, status) {
                    $scope.content = JSON.parse(data.config_homepage).content;
                }
            );

        }]);