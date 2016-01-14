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

define(['app'], function (app) {
    app.controller('ProductDetailsCtrl',
        function ($controller, $stateParams, $scope, resourceService, Env, mediaService, notify) {

            $scope.route = {
                name: 'Product',
                collection: 'products',
                edit: 'productEdit'
            };

            var itemService = new resourceService('product');

            angular.extend(this, $controller('AbstractDetailsNodeCtrl', {
                $scope: $scope,
                itemService: itemService
            }));

            // Product Images
            $scope.uploadPath = Env.api + '/media/upload/image/';

            // Delete file
            var deleteFile = function (id) {
                mediaService.delete(id).success(
                    function (data, status) {
                        notify('Attached media was removed');

                        angular.forEach($scope.item.medias, function (image, key) {
                            if (image.id === id) {
                                $scope.item.medias.splice(
                                    $scope.item.medias.indexOf(image), 1
                                );
                            }
                        });
                    }
                ).error(
                    function (data, status) {
                        if (data.error.code == 404) {
                            $state.transitionTo('home', {
                                locale: locale
                            });
                            notify('404 Noting found');
                        } else {
                            notify(data.error.message);
                        }
                    }
                );
            };

            $scope.fileDelete = function (id) {
                $scope.item.medias.splice(id, 1);
                $scope.editSave(deleteFile(id));
            };

            $scope.fileUploaded = function ($file, $message, $flow) {
                var image = JSON.parse($message);
                $scope.item.medias.push(image);
                $scope.editSave();
            };
        });
});
