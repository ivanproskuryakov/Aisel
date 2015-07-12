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
        function($controller, $stateParams, $scope, resourceService, Environment, mediaService, notify) {

        $scope.route = {
            name: 'Product',
            collection: 'products',
            edit: 'productEdit'
        };

        var itemService = new resourceService('product');
        angular.extend(this, $controller('AbstractDetailsCategoryCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

        // Product Images
        $scope.domain = Environment.settings.domain;
        $scope.uploadPath = Environment.settings.api + '/media/image/upload/?id=' + $stateParams.id;

        $scope.fileDelete = function (id){
            mediaService.delete(id).success(
                function(data, status) {
                    notify('Item removed');
                }
            ).error(
                function(data, status) {
                    if (data.error.code == 404) {
                        $state.transitionTo('home', {
                            locale: locale
                        });
                        notify('404 Noting found');
                        console.log(data);
                    } else {
                        notify(data.error.message);
                    }
                }
            )
        };

        $scope.fileUploaded = function ( $file, $message, $flow ){
            var uploadedImage = JSON.parse($message);
            var data = {
                filename: uploadedImage,
                title: '',
                description: '',
                product: {
                    id: $stateParams.id
                }
            };

            mediaService.new(data).success(
                function(data, status) {
                    console.log(status);
                    console.log(data);
                }
            );
        };

    });
});
