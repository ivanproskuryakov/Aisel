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

define(['app'], function (app) {
    app.controller('HomepageCtrl', ['$location', '$scope', '$routeParams', '$rootScope', 'rootService',
        function ($location, $scope, $routeParams, $rootScope, rootService) {
            $scope.content = false;
            rootService.getApplicationConfig().success(
                function (data, status) {
                    $scope.content = JSON.parse(data.config_homepage).content;
                }
            );
        }]);
});