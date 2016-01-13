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
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("countries", {
                    url: "/:locale/addressing/country/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'AddressingCountryCtrl'
                })
                .state("countryEdit", {
                    url: "/:locale/addressing/country/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl'
                })
                .state("countryNew", {
                    url: "/:locale/addressing/country/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl'
                })

                .state("regions", {
                    url: "/:locale/addressing/region/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'AddressingRegionCtrl'
                })
                .state("regionEdit", {
                    url: "/:locale/addressing/region/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl'
                })
                .state("regionNew", {
                    url: "/:locale/addressing/region/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl'
                })

                .state("cities", {
                    url: "/:locale/addressing/city/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'AddressingCityCtrl'
                })
                .state("cityEdit", {
                    url: "/:locale/addressing/city/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl'
                })
                .state("cityNew", {
                    url: "/:locale/addressing/city/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {

            $rootScope.topMenu.push({
                "ordering": 900,
                "roles": 'ROLE_ADMIN',
                "title": 'Addresses',
                "children": {
                    "countries": {
                        "ordering": 100,
                        "roles": 'ROLE_ADMIN',
                        "slug": '/addressing/country/',
                        "title": 'Countries'
                    },
                    "regions": {
                        "ordering": 200,
                        "roles": 'ROLE_ADMIN',
                        "slug": '/addressing/region/',
                        "title": 'Regions'
                    },
                    "cities": {
                        "ordering": 300,
                        "roles": 'ROLE_ADMIN',
                        "slug": '/addressing/city/',
                        "title": 'Cities'
                    }
                }
            });
        }]);
});
