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
  .config(function ($routeProvider, $locationProvider) {
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
  });