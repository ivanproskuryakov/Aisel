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
 * @description     ProductDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('ProductDetailsCtrl',
        function($controller, $stateParams, $scope, resourceService, Environment) {

        $scope.route = {
            name: 'Product',
            collection: 'products',
            edit: 'productEdit'
        };
        $scope.media = Environment.settings.media;
        $scope.uploadPath = Environment.settings.api + '/media/image/upload/?id=' + $stateParams.id;

        $scope.fileUploaded = function ( $file, $message, $flow ){
            console.log($file);
            console.log($message);
            console.log($flow);
        };

        var itemService = new resourceService('product');
        angular.extend(this, $controller('AbstractDetailsCategoryCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});
