'use strict';

angular.module('aiselApp')
  .service('pageService', ['$http','$routeParams','API_URL',function ($http,$routeParams,API_URL) {
        return {

            getPages: function($scope) {
                var url = API_URL+'/page/list.json?limit='+$scope.pageLimit+'&current='+$scope.paginationPage+'&category='+$scope.categoryId;
                console.log(url);
                return $http.get(url);
            },
            getPageByURL: function($url) {
                var url = API_URL+'/page/view/url/'+$url+'.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
