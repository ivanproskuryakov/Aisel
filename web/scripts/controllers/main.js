'use strict';

angular.module('aiselApp')
    .controller('MainCtrl', ['$location','$scope','$routeParams','rootService','appConfig', function ($location, $scope, $routeParams, rootService, appConfig) {

        $scope.content = false;
        $scope.test = 'test';
        appConfig.success(
            function(data, status) {
                $scope.content = JSON.parse(data.config_homepage).content;
            }
        );

}]);