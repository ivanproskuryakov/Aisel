'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSettings
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("settings", {
                    url: "/:locale/settings/",
                    templateUrl: '/app/Aisel/Settings/views/settings.html',
                    controller: 'SettingsCtrl'
                })
        }])
        .run(['$rootScope', 'Env', function ($rootScope, Env) {
            $rootScope.adminMenu.push({
                "ordering": 900,
                "glyphicon": 'glyphicon-cog',
                "slug": '/settings/',
                "title": 'Settings'
            });
        }]);
});
