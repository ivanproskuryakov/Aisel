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
    app.directive('aiselProductImages', ['$compile', 'Env',
        function ($compile, Env) {
            return {
                restrict: 'EA',
                scope: {
                    images: '=',
                    imgWidth: '=',
                    imgHeight: '=',
                    slider: '='
                },
                link: function ($scope, element, attrs) {
                    $scope.media = Env.media;
                    $scope.width = attrs.imgWidth ? attrs.imgWidth + 'px' : '100%';
                    $scope.height = attrs.imgHeight ? attrs.imgHeight + 'px' : 'auto';
                    $scope.interval = 0;

                    $scope.slides = [];
                    $scope.$watch('images', function () {
                        if ($scope.images) {
                            angular.forEach($scope.images, function (image, key) {
                                $scope.slides.push({
                                    image: Env.media + image.filename,
                                    id: key
                                });
                            });
                        }
                    });

                },
                templateUrl: '/app/Aisel/Product/views/directives/product-images.html'
            };
        }
    ]);
});
