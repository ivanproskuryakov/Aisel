'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselReview
 * @description     ...
 */

define(['app'], function (app) {
    app.directive('aiselReviewCollection', ['$compile', 'Env',
        function ($compile, Env) {
            return {
                restrict: 'EA',
                scope: {
                    reviews: '='
                },
                link: function ($scope, element, attrs) {
                },
                templateUrl: '/app/Aisel/Review/views/directives/review-collection.html'
            };
        }
    ]);
});
