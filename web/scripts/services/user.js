'use strict';

angular.module('aiselApp')
    .service('userService', ['$http', '$routeParams', 'API_URL',function ($http, $routeParams, API_URL) {
        return {

            register: function(form) {

                var username = form.username.$modelValue;
                var email = form.email.$modelValue;
                var password = form.password.$modelValue;

                var url = API_URL+'/user/register.json?username='+ username +'&password='+ password +'&email='+ email;
                console.log(url);
                return $http.get(url);
            },

            passwordforgot: function(form) {

                var email = form.email.$modelValue;
                var url = API_URL+'/user/passwordforgot.json?email='+ email;
                console.log(url);
                return $http.get(url);
            },

            signout: function() {
                var url = API_URL+'/user/logout.json';
                console.log(url);
                return $http.get(url);
            },

            login: function(username, password) {
                var url = API_URL+'/user/login.json?username=' + username + '&password=' +password;
                console.log(url);
                return $http.get(url);
            }
        };

    }]);
