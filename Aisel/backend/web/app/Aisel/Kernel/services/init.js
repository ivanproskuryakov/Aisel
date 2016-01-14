'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     Most important data are loaded here
 */

define(['app'], function (app) {
    console.log('Kernel init service loaded ...');
    angular.module('app')
        .service('initService',
            ['$http', '$rootScope', 'Env', 'authService',
                function ($http, $rootScope, Env, authService) {
                    return {
                        launch: function () {

                            console.log('----------- Aisel Loaded! -----------');
                            $rootScope.pageTitle = Env.pageTitle;
                            $rootScope.availableLocales = Env.locale.available;
                            $rootScope.locale = Env.currentLocale();
                            $rootScope.adminMenu = [];
                            $rootScope.sellerMenu = [];
                            $rootScope.domain = Env.domain;
                        }
                    }
                }
            ]);
});
