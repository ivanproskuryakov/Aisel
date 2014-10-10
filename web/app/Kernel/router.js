'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Main router provider in separate file, for better extensibility
 * Each module has its own router file.
 * Define only global routes in this appRouter.js file
 */

define(['app'], function (app) {
    app.config(function ($provide, $routeProvider, PRIMARY_LOCALE) {
        $routeProvider
            .otherwise({
                // Redirect to homepage if nothing was found
                redirectTo: '/' + PRIMARY_LOCALE + '/',
                resolve: {
                    init: function ($rootScope) {
                        console.log('Locale Fallback');
                        return false;
                    }
                }
            });
    });

    /**
     * Simple helper functions for user ACL
     * see more at user/router.js
     */
    var grantAccessAuthenticated = function ($rootScope, $location, notify) {
        if (!$rootScope.isAuthenticated) {
            $location.path("/" + $rootScope.locale + "/");
        }
    };
    var grantAccessGuest = function ($rootScope, $location, notify) {
        if ($rootScope.isAuthenticated) {
            $location.path("/" + $rootScope.locale + "/");
        }
    };
});

