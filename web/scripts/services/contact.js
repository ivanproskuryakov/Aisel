'use strict';

angular.module('projectxApp')
    .service('contactService', ['$http','$routeParams','API_URL',function ($http, $routeParams, API_URL) {
        return {

            getConfig: function() {
                var url = API_URL+'/config/contact.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
