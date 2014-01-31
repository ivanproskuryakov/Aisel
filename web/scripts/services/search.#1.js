'use strict';

angular.module('projectxApp')
    .service('searchService', ['$http','$routeParams','API_URL',function ($http,$routeParams,API_URL) {
        return {
            getSearchResult: function($scope) {

                var paginationPage = $routeParams.page;
                if (!paginationPage) paginationPage =1;

                var url = API_URL+'/search/?query='+$routeParams.query+'&current='+paginationPage;
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
