'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Core module of the application.
 */

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

    .constant('API_URL', '/api')

    .run(['$http', '$rootScope', 'rootService', function ($http, $rootScope, rootService) {
        rootService.init();
    }])

    .config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

        $routeProvider
            // Homepage
            .when('/', {
                templateUrl: 'app/views/core/homepage/homepage.html',
                controller: 'HomepageCtrl'
            })

            // Contact
            .when('/contact/', {
                templateUrl: 'app/views/core/contact/contact.html',
                controller: 'ContactCtrl'
            })

            // Search
            .when('/search/:query', {
                templateUrl: 'app/views/core/search/search.html',
                controller: 'SearchCtrl'
            })

            // Pages
            .when('/pages/', {
                templateUrl: 'app/views/core/page/page.html',
                controller: 'PageCtrl'
            })
            .when('/page/:pageId/', {
                templateUrl: 'app/views/core/page/page-detail.html',
                controller: 'PageDetailCtrl'
            })

            // Categories
            .when('/categories/', {
                templateUrl: 'app/views/core/category/category.html',
                controller: 'CategoryCtrl'
            })
            .when('/category/:categoryId/', {
                templateUrl: 'app/views/core/category/category-detail.html',
                controller: 'CategoryDetailCtrl'
            })

            // User operations
            .when('/user/register/', {
                templateUrl: 'app/views/core/user/register.html',
                controller: 'UserCtrl'
            })
            .when('/user/password/forgot/', {
                templateUrl: 'app/views/core/user/password-forgot.html',
                controller: 'UserCtrl'
            })
            .when('/user/information/', {
                templateUrl: 'app/views/core/user/information/dashboard.html',
                controller: 'UserCtrl'
            })
            .when('/user/information/edit/', {
                templateUrl: 'app/views/core/user/information/edit.html',
                controller: 'UserCtrl'
            })
            .when('/user/page/list/', {
                templateUrl: 'app/views/core/user/page/list.html',
                controller: 'UserPageListCtrl'
            })
            .when('/user/page/add/', {
                templateUrl: 'app/views/core/user/page/add.html',
                controller: 'UserPageAddCtrl'
            })
            .when('/user/page/edit/:pageId/', {
                templateUrl: 'app/views/core/user/page/edit.html',
                controller: 'UserPageEditCtrl'
            })

            // Default action
            .otherwise({
                redirectTo: '/'
            });

        $locationProvider
//            .html5Mode(true)
            .hashPrefix('!');


        // Intercept http calls
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
        $httpProvider.interceptors.push('requestInterceptor');


    });
