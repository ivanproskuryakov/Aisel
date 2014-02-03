'use strict';

angular.module('projectxApp')
  .service('pageService', ['$http','$routeParams','API_URL',function ($http,$routeParams,API_URL) {
        return {

            getPages: function($scope) {
                var url = API_URL+'/page/list/?limit='+$scope.limit+'&current='+$scope.paginationPage;
                console.log(url);
                return $http.get(url);
            },
            getPage: function($id) {
                var url = API_URL+'/page/view/'+$id;
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
