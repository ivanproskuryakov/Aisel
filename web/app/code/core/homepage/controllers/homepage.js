'use strict';

angular.module('aiselApp')
    .controller('HomepageCtrl', ['$location', '$scope', '$routeParams', '$rootScope', 'rootService',
        function ($location, $scope, $routeParams, $rootScope, rootService) {

            console.log($rootScope.locale);
            $scope.content = false;
            rootService.getApplicationConfig().success(
                function (data, status) {
                    $scope.content = JSON.parse(data.config_homepage).content;
                }
            );

        }]);