'use strict';

angular.module('aiselApp')
  .service('pageService', ['$http','$routeParams','API_URL',function ($http,$routeParams,API_URL) {
        return {

            getPages: function($scope) {
                var url = API_URL+'/page/list.json?limit='+$scope.pageLimit+'&current='+$scope.paginationPage;
                console.log(url);
                return $http.get(url);
            },
            getPage: function($id) {
                var url = API_URL+'/page/view/'+$id+'.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
