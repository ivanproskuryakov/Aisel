'use strict';

angular.module('projectxApp')
    .service('rootService', ['$http','$routeParams','API_URL',function ($http, $routeParams, API_URL) {
        return {

            getApplicationConfig: function() {
                var url = API_URL+'/config/settings.json';
                console.log(url);
                return $http.get(url);
            },

            getCategoryTree: function() {
                var url = API_URL+'/category/tree.json';
                console.log(url);
                return $http.get(url);
            },

            getMenu: function() {
                var url = API_URL+'/navigation/menu.json';
                console.log(url);
                return $http.get(url);
            },

            getUserInformation: function() {
                var url = API_URL+'/user/information.json';
                console.log(url);
                return $http.get(url);
            }

        };

    }]);
