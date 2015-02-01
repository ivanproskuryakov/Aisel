'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSearch
 * @description     ...
 */

define(['app'], function (app) {
    app.directive('ngSearchRedirect', ['$location',
        function ($location) {
            return {
                restrict: 'A',
                link: function postLink(scope, element, attrs) {
                    element.bind('keyup', function (e) {
                        if (e.keyCode === 13) {
                            if (attrs.ngSearchRedirect.length > 1) {
                                window.location.assign('/en/search/' + attrs.ngSearchRedirect);
                            }
                        }
                    });
                }
            };
        }]);
});