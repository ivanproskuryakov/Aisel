'use strict';

/**
 * @ngdoc overview
 *
 * @name aiselApp
 *
 * @description
 *
 * ...
 */

angular.module('aiselApp')
    .controller('HomepageCtrl', ['$location', '$scope', '$routeParams', '$rootScope', 'rootService',
        function ($location, $scope, $routeParams, $rootScope, rootService) {
            $scope.content = false;
            rootService.getApplicationConfig().success(
                function (data, status) {
                    $scope.content = JSON.parse(data.config_homepage).content;
                }
            );

        }]);