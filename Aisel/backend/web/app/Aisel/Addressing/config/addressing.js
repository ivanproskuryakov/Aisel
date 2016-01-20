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
                    controller: 'AddressingCountryCtrl',
                })
                .state("countryEdit", {
                    url: "/:locale/addressing/country/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl',
                })
                .state("countryNew", {
                    url: "/:locale/addressing/country/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-country.html',
                    controller: 'AddressingCountryDetailsCtrl',
                })

                .state("regions", {
                    url: "/:locale/addressing/region/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'AddressingRegionCtrl',
                })
                .state("regionEdit", {
                    url: "/:locale/addressing/region/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl',
                })
                .state("regionNew", {
                    url: "/:locale/addressing/region/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-region.html',
                    controller: 'AddressingRegionDetailsCtrl',
                })

                .state("cities", {
                    url: "/:locale/addressing/city/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'AddressingCityCtrl',
                })
                .state("cityEdit", {
                    url: "/:locale/addressing/city/edit/:id/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl',
                })
                .state("cityNew", {
                    url: "/:locale/addressing/city/new/",
                    templateUrl: '/app/Aisel/Addressing/views/edit-city.html',
                    controller: 'AddressingCityDetailsCtrl',
                })
        }])
        .run(['$rootScope', 'Env', function ($rootScope, Env) {

            $rootScope.adminMenu.push({
                "ordering": 100,
                "title": 'Pages',
                "children": {
                    "pages": {
                        "ordering": 100,
                        "slug": '/page/',
                        "title": 'Pages'
                    },
                    "pageNode": {
                        "ordering": 200,
                        "slug": '/page/node/',
                        "title": 'Nodes'
                    },
                    "pageReview": {
                        "ordering": 300,
                        "slug": '/page/review/',
                        "title": 'Reviews'
                    }
                }
            });

            $rootScope.adminMenu.push({
                "ordering": 900,
                "title": 'Addresses',
                "children": {
                    "countries": {
                        "ordering": 100,
                        "slug": '/addressing/country/',
                        "title": 'Countries'
                    },
                    "regions": {
                        "ordering": 200,
                        "slug": '/addressing/region/',
                        "title": 'Regions'
                    },
                    "cities": {
                        "ordering": 300,
                        "slug": '/addressing/city/',
                        "title": 'Cities'
                    }
                }
            });
        }]);
});
