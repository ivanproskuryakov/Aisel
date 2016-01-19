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
 * @description     Grabs application settings from backend
 */

define(['app'], function (app) {
    console.log('Kernel settings loaded ...');
    angular.module('app')
        .service('settingsService', ['$http', '$rootScope', 'Env',
            function ($http, $rootScope, Env) {
                return {
                    getMenu: function () {
                        var locale = Env.currentLocale();
                        var url = Env.api + '/' + locale + '/navigation/';
                        return $http.get(url);
                    }
                };
            }
        ]);
});
