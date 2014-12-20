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
 * @description     homepage module configuration
 */

define(['app','./controllers/homepage'], function (app) {
    console.log('Homepage module loaded ...');
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("homepage", {
                url: "/:locale/",
                templateUrl: '/app/Aisel/Homepage/views/homepage.html',
                controller: 'HomepageCtrl'
            });
    }]);
});