'use strict';

angular.module('projectxApp')
    .controller('MainCtrl', ['$location','$scope','$routeParams','navigationService','categoryService',function ($location, $scope, $routeParams, navigationService, categoryService) {

        // Navigation Menu
        navigationService.getMenu().success(
            function(data, status) {
                $scope.navigationMenu = data;
            }
        );

}]);