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
 * @description     Environment vars
 */

define(['angular'],
    function (angular) {
        'use strict';
        console.log('Environment loaded ...');
        angular.module('environment', [])
            .service('Environment', function () {
                var api_domain = document.domain.replace("admin", "api");

                return {
                    settings: {
                        api: 'http://' + api_domain + '/backend/api',
                        pageTitle: 'Aisel - open source project | Admin',
                        locale: {
                            "primary": 'en',
                            "available": ['ru', 'es', 'en']
                        },
                        menu: {
                            "pages": {
                                "ordering": 100,
                                "title": 'Pages',
                                "glyphicon": 'glyphicon-th-list',
                                "children": {
                                    "pages": {
                                        "ordering": 100,
                                        "slug": '/pages/',
                                        "title": 'Pages'
                                    },
                                    "pageCategory": {
                                        "ordering": 200,
                                        "slug": '/page/category/',
                                        "title": 'Categories'
                                    }
                                }
                            },
                            "products": {
                                "ordering": 200,
                                "title": 'Products',
                                "glyphicon": 'glyphicon-th-list',
                                "children": {
                                    "products": {
                                        "ordering": 100,
                                        "slug": '/products/',
                                        "title": 'Products'
                                    },
                                    "productCategory": {
                                        "ordering": 200,
                                        "slug": '/product/category/',
                                        "title": 'Categories'
                                    }
                                }
                            },
                            "users": {
                                "ordering": 300,
                                "title": 'Users',
                                "glyphicon": 'glyphicon-user',
                                "children": {
                                    "frontendUsers": {
                                        "ordering": 100,
                                        "slug": '/users/frontend/',
                                        "title": 'Frontend Users'
                                    },
                                    "backendUsers": {
                                        "ordering": 200,
                                        "slug": '/users/backend/',
                                        "title": 'Backend Users'
                                    }
                                }
                            },
                            "addressing": {
                                "ordering": 900,
                                "title": 'Addresses',
                                "glyphicon": 'glyphicon-th-list',
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
                            },
                            "orders": {
                                "ordering": 400,
                                "glyphicon": 'glyphicon-inbox',
                                "slug": '/orders/',
                                "title": 'Orders'
                            },
                            "navigation": {
                                "ordering": 500,
                                "glyphicon": 'glyphicon-th-list',
                                "slug": '/navigation/',
                                "title": 'Navigation'
                            },
                            "settings": {
                                "ordering": 900,
                                "glyphicon": 'glyphicon-cog',
                                "slug": '/settings/',
                                "title": 'Settings'
                            }
                        }
                    },
                    currentLocale: function () {
                        var locale = window.location.pathname.replace(/^\/([^\/]*).*$/, '$1');
                        if (this.settings.locale.available.indexOf(locale) == -1) {
                            locale = this.settings.locale.primary;
                        }
                        return locale;
                    }
                }
            }
        )
    });