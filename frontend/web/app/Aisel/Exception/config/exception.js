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
 * @description     Module configuration
 */

define(['app'], function(app) {
    app.config(['$stateProvider', function($stateProvider) {
        $stateProvider
            .state("exception", {
                url: "/:locale/exception/:code",
                templateUrl: '/app/Aisel/Exception/views/exception.html',
                controller: 'ExceptionCtrl'
            });
    }]);

    app.config(function($httpProvider) {

        var exceptionInterceptor = [
            '$q', '$injector', 'Environment', '$rootScope',
            function($q, $injector, Environment, $rootScope) {

                function success(response) {
                    return response;
                }

                function error(response) {
                    console.log(response);
                    $rootScope.exception = response;
                    var locale = Environment.currentLocale();

                    $injector.get('$state').transitionTo(
                        'exception', {
                            locale: locale,
                            code: response.data.error.code
                        }
                    );

                    return $q.reject(response);
                }

                return function(promise) {
                    return promise.then(success, error);
                }
            }
        ];

        $httpProvider.responseInterceptors.push(exceptionInterceptor);
    });
});
