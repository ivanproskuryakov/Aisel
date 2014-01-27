'use strict';

angular.module('projectxApp')
  .controller('PageCtrl', ['$scope','$routeParams','pageService',function ($scope,$routeParams, pageService) {
//        console.log($scope);

        $scope.limit = 5;
        $scope.currentPage = $routeParams.current;


        $scope.order = 'id'
        if ($routeParams.order) {
            $scope.order = $routeParams.order;
        }
        $scope.orderby = 'ASC';
        if ($routeParams.orderby) {
            $scope.orderby = $routeParams.orderby;
        }
        $scope.search = '';
        if ($routeParams.search) {
            $scope.search = $routeParams.search;
        }

        var handleSuccess = function(data, status) {
            $scope.list = data;
            $scope.pagesTotal = pageService.getTotalPages($scope)

        };
        $scope.doRequest = function() {
            pageService.getPages($scope).success(handleSuccess);
        };
        pageService.getPages($scope).success(handleSuccess);





  }]);
