'use strict';

var app = angular.module('aiselApp', [
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'ngRoute',
    'ui.bootstrap',
    'ui.utils',
    'ui.validate',
    'ui.gravatar',
    'cgNotify'
    ])

    .constant('API_URL','/api')

    .run(['$http', '$rootScope','rootService', function($http, $rootScope, rootService) {
        rootService.init();
    }])

    .config(function ($provide, $routeProvider, $locationProvider, $httpProvider ) {

        $routeProvider
            // Homepage
            .when('/', {
                templateUrl: 'views/homepage.html',
                controller: 'MainCtrl'
            })

            // Contact
            .when('/contact/', {
                templateUrl: 'views/contact.html',
                controller: 'ContactCtrl'
            })

            // Search
            .when('/search/:query', {
                templateUrl: 'views/search.html',
                controller: 'SearchCtrl'
            })

            // Pages
            .when('/pages/', {
                templateUrl: 'views/page.html',
                controller: 'PageCtrl'
            })
            .when('/page/:pageId/', {
                templateUrl: 'views/page-detail.html',
                controller: 'PageDetailCtrl'
            })

            // Categories
            .when('/categories/', {
                templateUrl: 'views/category.html',
                controller: 'CategoryCtrl'
            })
            .when('/category/:categoryId/', {
                templateUrl: 'views/category-detail.html',
                controller: 'CategoryDetailCtrl'
            })

            // User operations
            .when('/user/register/', {
                templateUrl: 'views/user/register.html',
                controller: 'UserCtrl'
            })
            .when('/user/password/forgot/', {
                templateUrl: 'views/user/password-forgot.html',
                controller: 'UserCtrl'
            })
            .when('/user/information/', {
                templateUrl: 'views/user/information/dashboard.html',
                controller: 'UserCtrl'
            })
            .when('/user/information/edit/', {
                templateUrl: 'views/user/information/edit.html',
                controller: 'UserCtrl'
            })
            .when('/user/page/list/', {
                templateUrl: 'views/user/page/list.html',
                controller: 'UserPageListCtrl'
            })
            .when('/user/page/add/', {
                templateUrl: 'views/user/page/add.html',
                controller: 'UserPageAddCtrl'
            })
            .when('/user/page/edit/:pageId/', {
                templateUrl: 'views/user/page/edit.html',
                controller: 'UserPageEditCtrl'
            })

            // Default action
            .otherwise({
                redirectTo: '/'
            });

        $locationProvider
//            .html5Mode(true)
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
