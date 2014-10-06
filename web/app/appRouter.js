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

aiselApp.config(function ($provide, $routeProvider, LOCALE_FALLBACK) {
    /**
     * Default route. Redirect to homepage if nothing was found
     */
    $routeProvider
        .otherwise({
            redirectTo: '/' + LOCALE_FALLBACK.primary + '/',
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