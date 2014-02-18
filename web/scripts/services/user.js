'use strict';

angular.module('projectxApp')
    .service('userService', ['$http', '$routeParams', 'API_URL',function ($http, $routeParams, API_URL) {
        return {

            register: function($scope) {
                var url = API_URL+'/user/register.json?username=aaaa&password=aaa&email=aaa@aaa.com';
                console.log(url);
                return $http.get(url);
            },

            information: function() {
                var url = API_URL+'/user/information.json';
                console.log(url);
                return $http.get(url);
            },

            signout: function() {
                var url = API_URL+'/user/logout.json';
                console.log(url);
                return $http.get(url);
            },

            login: function(username, password) {
                var url = API_URL+'/user/login.json?username=' + username + '&password=' + password;
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
