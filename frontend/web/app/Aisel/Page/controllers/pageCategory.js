'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('PageCategoryCtrl', ['$location', '$scope', '$stateParams', 'pageCategoryService', '$controller',
        function($location, $scope, $stateParams, pageCategoryService, $controller) {

            angular.extend(this, $controller('AbstractCollectionCtrl', {
                $scope: $scope,
                itemService: pageCategoryService
            }));
        }
    ]);
});
