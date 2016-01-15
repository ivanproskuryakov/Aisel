'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductCtrl', ['$scope', '$stateParams', 'resourceService', 'Env', '$controller',
        function ($scope, $stateParams, resourceService, Env, $controller) {
            $scope.media = Env.media;

            var productService = new resourceService('product');

            angular.extend(this, $controller('AbstractCollectionCtrl', {
                $scope: $scope,
                itemService: productService
            }));
        }
    ]);
});
