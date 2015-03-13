'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselBackendUser
 * @description     Module configuration
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("backendUsers", {
                url: "/:locale/users/backend/",
                templateUrl: '/app/Kernel/Resource/views/collection.html',
                controller: 'BackendUserCtrl'
            })
            .state("backendUserEdit", {
                url: "/:locale/users/backend/edit/:id/",
                templateUrl: '/app/Aisel/BackendUser/views/edit.html',
                controller: 'BackendUserDetailCtrl'
            })
    }]);
});