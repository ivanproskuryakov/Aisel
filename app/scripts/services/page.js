'use strict';

angular.module('projectxApp')
  .service('pageService', ['$http','$routeParams','API_URL',function ($http,$routeParams,API_URL) {
        return {

            getPages: function($scope) {
                var currentPage = null;
                if ($routeParams.current == 'index') {
                    currentPage = 1;
                } else {
                    currentPage = $routeParams.current;
                }


                var url = API_URL+'/page/list/?limit='+$scope.limit+'&current='+currentPage+'&search='+$scope.search+'&order='+$scope.order+'&orderby='+$scope.orderby;
                console.log(url);
                return $http.get(url);
            },
            getPage: function($id) {
                var url = API_URL+'/page/view/'+$id;
                return $http.get(url);
            },
            getTotalPages: function($scope) {
                var pagesTotal = $scope.list.total / $scope.limit;
                if (pagesTotal % 1 !== 0) {
                    pagesTotal++;
                }
                return pagesTotal;
            }
        };

    }]);
