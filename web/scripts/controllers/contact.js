'use strict';

angular.module('projectxApp')
    .controller('ContactCtrl', ['$location','$scope','$routeParams','contactService',function ($location, $scope, $routeParams, contactService) {


        // Get Contact Settings
        contactService.getConfig($scope).success(
            function(data, status) {
                $scope.config = JSON.parse(data.value);
//                console.log($scope.config);
            }
        );


    }]);