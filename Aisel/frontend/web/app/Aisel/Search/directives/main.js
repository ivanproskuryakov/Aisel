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
    app.directive('ngSearchRedirect', ['$state', 'Env',
        function ($state, Env) {
            return {
                restrict: 'A',
                link: function postLink(scope, element, attrs) {
                    element.bind('keyup', function (e) {
                        if (e.keyCode === 13) {
                            var query = attrs.ngSearchRedirect;

                            if (query.length > 1) {
                                var locale = Env.currentLocale();

                                $state.transitionTo('search', {
                                    locale: locale,
                                    query: query
                                });
                            }
                        }
                    });
                }
            };
        }
    ]);
});
