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

define(['app'], function(app) {
    app.directive('aiselProductImages', ['$compile', 'Env',
        function($compile, Env) {
            return {
                restrict: 'EA',
                scope: {
                    images: '=',
                    imgSize: '='
                },
                link: function($scope, element, attrs) {
                    $scope.domain = Env.domain;
                    $scope.size = attrs.imgSize;
                },
                templateUrl: '/app/Aisel/Product/views/directives/product-images.html'
            };
        }
    ]);
});
