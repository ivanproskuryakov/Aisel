'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAddressing
 * @description     Module configuration
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("countries", {
                url: "/:locale/addressing/country/",
                templateUrl: '/app/Kernel/Resource/views/collection.html',
                controller: 'AddressingCountryCtrl'
            })
            .state("regions", {
                url: "/:locale/addressing/region/",
                templateUrl: '/app/Kernel/Resource/views/collection.html',
                controller: 'AddressingRegionCtrl'
            })
            .state("cities", {
                url: "/:locale/addressing/city/",
                templateUrl: '/app/Kernel/Resource/views/collection.html',
                controller: 'AddressingCityCtrl'
            })
    }]);
});