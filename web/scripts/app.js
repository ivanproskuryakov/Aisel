'use strict';

angular.module('projectxApp', [
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'ngRoute',
    'ngAnimate',
    'ui.bootstrap',
    'ui.utils',
    'ui.validate',
    'cgNotify'
])
  .constant('API_URL','/api')
  .config(function ($provide, $routeProvider, $locationProvider, $httpProvider ) {
    $routeProvider
        .when('/', {
            templateUrl: 'views/main.html',
            controller: 'MainCtrl'
        })
        .when('/pages/', {
            templateUrl: 'views/page.html',
            controller: 'PageCtrl'
        })
        .when('/page/:pageId', {
            templateUrl: 'views/page-detail.html',
            controller: 'PageDetailCtrl'
        })

        .when('/categories/', {
            templateUrl: 'views/category.html',
            controller: 'CategoryCtrl'
        })
        .when('/category/:categoryId', {
            templateUrl: 'views/category-detail.html',
            controller: 'CategoryDetailCtrl'
        })

        .when('/about/', {
            templateUrl: 'views/about.html',
            controller: 'AboutCtrl'
        })
        .when('/contact/', {
            templateUrl: 'views/contact.html',
            controller: 'ContactCtrl'
        })
        .when('/search/:query', {
            templateUrl: 'views/search.html',
            controller: 'SearchCtrl'
        })

        .when('/user/register/', {
            templateUrl: 'views/user/register.html',
            controller: 'UserCtrl'
        })
        .when('/user/information/', {
            templateUrl: 'views/user/information.html',
            controller: 'UserCtrl'
        })

        .otherwise({
        redirectTo: '/'
        });

    $locationProvider
        .html5Mode(false)
        .hashPrefix('!');

    // Intercept http calls.
    $provide.factory('LoggingHttpInterceptor', function ($q) {
        return {
            // On request success
            request: function (config) {
                $('.loading-interceptor').show();
//                console.log(config); // Contains the data about the request before it is sent.

                // Return the config or wrap it in a promise if blank.
                return config || $q.when(config);
            },

            // On request failure
            requestError: function (rejection) {
                $('.loading-interceptor').hide();
                // console.log(rejection); // Contains the data about the error on the request.

                // Return the promise rejection.
                return $q.reject(rejection);
            },

            // On response success
            response: function (response) {
                $('.loading-interceptor').hide();
//                console.log(response); // Contains the data from the response.

                // Return the response or promise.
                return response || $q.when(response);
            },

            // On response failture
            responseError: function (rejection) {
                $('.loading-interceptor').hide();
                // console.log(rejection); // Contains the data about the error.

                // Return the promise rejection.
                return $q.reject(rejection);
            }
        };
    });

    // Add the interceptor to the $httpProvider.
    $httpProvider.interceptors.push('LoggingHttpInterceptor');




  });