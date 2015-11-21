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
    app.directive('aiselProductImages', ['$compile', 'Environment',
        function ($compile, Environment) {
            return {
                restrict: 'EA',
                scope: {
                    images: '=',
                    imgWidth: '=',
                    imgHeight: '=',
                    slider: '='
                },
                link: function ($scope, element, attrs) {
                    $scope.media = Environment.settings.media;
                    $scope.width = attrs.imgWidth ? attrs.imgWidth +'px' : '100%';
                    $scope.height = attrs.imgHeight ? attrs.imgHeight + 'px' : 'auto';
                    $scope.interval = 0;
                },
                templateUrl: '/app/Aisel/Product/views/directives/product-images.html'
            };
        }
    ]);
});
