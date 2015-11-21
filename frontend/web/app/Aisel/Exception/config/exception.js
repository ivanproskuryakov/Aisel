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

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("exception", {
                url: "/:locale/exception/:code",
                templateUrl: '/app/Aisel/Exception/views/exception.html',
                controller: 'ExceptionCtrl'
            });
    }]);

    app.factory('errorInterceptor',
        ['$rootScope', '$q', '$injector', '$location', 'Environment',
            function ($rootScope, $q, $injector, $location, Environment) {
                return {
                    request: function (config) {
                        return config;
                    },
                    responseError: function (response) {
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
                };
            }
        ]
    );


    app.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.interceptors.push('errorInterceptor');
    }]);

});
