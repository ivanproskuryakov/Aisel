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
    app.controller('ProductCtrl', ['$scope', '$stateParams', 'productService', 'Environment', '$controller',
        function ($scope, $stateParams, productService, Environment, $controller) {
            $scope.media = Environment.settings.media;

            angular.extend(this, $controller('AbstractCollectionCtrl', {
                $scope: $scope,
                itemService: productService
            }));

        }
    ]);
});
