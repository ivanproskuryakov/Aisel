'use strict';

angular.module('projectxApp')
    .service('navigationService', ['$http','$routeParams','API_URL',function ($http, $routeParams, API_URL) {
        return {

            getMenu: function() {
                var url = API_URL+'/navigation/menu.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
