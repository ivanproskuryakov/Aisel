'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @ngdoc           overview
 * @name            Aisel
 * @description     Main router provider in separate file, for better extensibility
 *                  Each module has its own router file.
 *                  Define only global routes in this appRouter.js file
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
});

