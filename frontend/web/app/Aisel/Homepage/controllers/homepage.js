'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselHomepage
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('HomepageCtrl', ['$location', '$scope', '$routeParams', '$rootScope', 'settingsService', 'Environment',
        function($location, $scope, $routeParams, $rootScope, settingsService, Environment) {
            settingsService.getApplicationConfig().success(
                function(data, status) {
                    var locale = Environment.currentLocale();
                    $scope.content = data.settings[locale].content.homepageContent;
                }
            );
        }
    ]);
});
