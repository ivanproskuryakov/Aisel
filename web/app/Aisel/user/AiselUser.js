'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * User router
 */

define(['app'], function (app) {
    console.log('User Router Loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider
            // Actions only for guest users
            .when('/:locale/user/register/', {
                templateUrl: 'app/Aisel/User/views/register.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: grantAccessGuest
                }
            })
            .when('/:locale/user/password/forgot/', {
                templateUrl: 'app/Aisel/User/views/password-forgot.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: grantAccessGuest
                }
            })
            // Authenticated users actions
            .when('/:locale/user/information/', {
                templateUrl: 'app/Aisel/User/views/information/dashboard.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: grantAccessAuthenticated
                }
            })
            .when('/:locale/user/information/edit/', {
                templateUrl: 'app/Aisel/User/views/information/edit.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: grantAccessAuthenticated
                }
            })
            .when('/:locale/user/page/list/', {
                templateUrl: 'app/Aisel/User/views/page/list.html',
                controller: 'UserPageListCtrl',
                resolve: {
                    factory: grantAccessAuthenticated
                }
            })
            .when('/:locale/user/page/add/', {
                templateUrl: 'app/Aisel/User/views/page/add.html',
                controller: 'UserPageAddCtrl',
                resolve: {
                    factory: grantAccessAuthenticated
                }
            })
            .when('/:locale/user/page/edit/:pageId/', {
                templateUrl: 'app/Aisel/User/views/page/edit.html',
                controller: 'UserPageEditCtrl',
                resolve: {
                    factory: grantAccessAuthenticated
                }
            })
    });
});