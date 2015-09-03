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
        function ($controller, $stateParams, $scope, resourceService, Environment, mediaService, notify) {

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
            $scope.domain = Environment.settings.domain;
            $scope.uploadPath = Environment.settings.api + '/media/image/upload/?id=' + $stateParams.id;

            // Delete file

            var deleteFile = function (id) {
                mediaService.delete(id).success(
                    function (data, status) {
                        notify('Attached image was removed');

                        angular.forEach($scope.item.images, function (image, key) {
                            if (image.id === id) {
                                $scope.item.images.splice(
                                    $scope.item.images.indexOf(image), 1
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
                $scope.item.images.splice(id, 1);
                $scope.editSave(deleteFile(id));
            };

            $scope.fileUploaded = function ($file, $message, $flow) {
                var uploadedImage = JSON.parse($message);
                var image = {
                    filename: uploadedImage,
                    title: '',
                    description: '',
                    product: {
                        id: $stateParams.id
                    }
                };

                mediaService.new(image).success(
                    function (data, status, headers, config) {
                        image.id = headers("Location").split('/').pop();
                        $scope.item.images.push(image);
                        $scope.editSave();
                    }
                );
            };

        });
});
