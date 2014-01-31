'use strict';

angular.module('projectxApp')
  .controller('PageCtrl', ['$location','$scope','$routeParams','pageService',function ($location, $scope, $routeParams, pageService) {

        $scope.limit = 5;
//        $scope.paginationPage = $routeParams.page;
//        if (!$scope.paginationPage)
        $scope.paginationPage = 1;

        var handleSuccess = function(data, status) {
            $scope.list = data;
        };
        pageService.getPages($scope).success(handleSuccess);

        $scope.pageChanged = function(page) {
            $scope.paginationPage = page;
            pageService.getPages($scope).success(handleSuccess);
        };
  }]);

//$scope.order = 'id'
//if ($routeParams.order) {
//    $scope.order = $routeParams.order;
//}
//$scope.orderby = 'ASC';
//if ($routeParams.orderby) {
//    $scope.orderby = $routeParams.orderby;
//}
//$scope.search = '';
//if ($routeParams.search) {
//    $scope.search = $routeParams.search;
//}