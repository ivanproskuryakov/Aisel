'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselDashboard
 * @description     ...
 */

define(['app'], function(app) {
    app.config(['$stateProvider', function($stateProvider) {
        $stateProvider
            .state("home", {
                url: "/:locale/",
                templateUrl: '/app/Aisel/Dashboard/views/dashboard.html',
                controller: 'DashboardCtrl'
            });
    }]);
});
