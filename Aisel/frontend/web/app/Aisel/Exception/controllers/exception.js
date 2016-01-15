'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselException
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('ExceptionCtrl', ['$state', '$scope', 'notify', 'Env', '$rootScope',
        function($state, $scope, notify, Env, $rootScope) {

            $scope.exception = undefined;

            if ($rootScope.exception) {
                $scope.exception = $rootScope.exception;
                $rootScope.exception = undefined;

                var errorTrace = $scope.exception.data.error;
                var message = errorTrace.exception[0].message;

                if (!angular.isDefined(message)) {
                    message = errorTrace.message;
                }
                notify(message);

            } else {
                var locale = Env.currentLocale();
                $state.transitionTo('homepage', {
                    locale: locale
                });
            }
        }
    ]);
});
