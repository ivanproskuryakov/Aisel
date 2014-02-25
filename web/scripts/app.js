'use strict';

var app = angular.module('aiselApp', [
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

    .run(['$http', '$rootScope','rootService', function($http, $rootScope, rootService) {
        rootService.init();
    }])

    .config(function ($provide, $routeProvider, $locationProvider, $httpProvider ) {

        $routeProvider
            .when('/', {
                templateUrl: 'views/homepage.html',
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

        $provide.factory('appConfig', function ($q,rootService) {
            return rootService.getApplicationConfig();
        });

        // Intercept http calls.
        $provide.factory('requestInterceptor', function ($q) {
            return {
                request: function (config) {
                    $('.loading-interceptor').show();
                    return config || $q.when(config);
                },
                requestError: function (rejection) {
                    $('.loading-interceptor').hide();
                    return $q.reject(rejection);
                },
                response: function (response) {
                    $('.loading-interceptor').hide();
                    return response || $q.when(response);
                },
                responseError: function (rejection) {
                    $('.loading-interceptor').hide();
                    return $q.reject(rejection);
                }
            };
        });
        $httpProvider.interceptors.push('requestInterceptor')


  });
