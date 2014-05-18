'use strict';

angular.module('aiselApp')
    .service('userPageService', ['$http', '$routeParams', 'API_URL',function ($http, $routeParams, API_URL) {
        return {

            getPages: function($scope) {
                var url = API_URL+'/page/list.json?userid='+$scope.userId+'&limit='+$scope.pageLimit+'limit='+$scope.pageLimit+'&current='+$scope.paginationPage+'&category='+$scope.categoryId;
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
