'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Router update for Homepage Module
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

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
});
