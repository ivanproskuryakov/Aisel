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

define(['app'], function(app) {
    console.log('Kernel init service loaded ...');
    angular.module('app')
        .service('initService', [
            '$http',
            '$rootScope',
            'settingsService',
            'authService',
            'userService',
            'pageCategoryService',
            'productCategoryService',
            'Environment',
            '$timeout',
            function(
                $http,
                $rootScope,
                settingsService,
                authService,
                userService,
                pageCategoryService,
                productCategoryService,
                Environment,
                $timeout
            ) {
                return {
                    launch: function() {

                        // Load user status
                        userService.getUserInformation().success(
                            function(data, status) {
                                console.log(data);
                                if (data.email) {
                                    $rootScope.user = data;
                                } else {
                                    $rootScope.user = undefined;
                                }
                            }
                        );

                        // Load settings data
                        settingsService.getApplicationConfig().success(
                            function(data, status) {

                                var settings = data.settings[Environment.currentLocale()];

                                $rootScope.footer = settings.content.footerContent;
                                $rootScope.disqusShortname = settings.disqus.shortname;
                                $rootScope.disqusStatus = false;
                                $rootScope.currency = settings.general.currency;
                                $rootScope.paymentMethods = settings.general.paymentMethods;

                                console.log('----------- Aisel Loaded! -----------');
                                var setLocale = function() {
                                    $rootScope.availableLocales = Environment.settings.locale.available;
                                    $rootScope.locale = Environment.currentLocale();
                                };
                                var setMetaData = function() {
                                    $rootScope.pageTitle = settings.meta.defaultMetaTitle;
                                    $rootScope.metaDescription = settings.meta.defaultMetaDescription;
                                    $rootScope.metaKeywords = settings.meta.defaultMetaKeywords;
                                };

                                // Init
                                setLocale();
                                setMetaData();

                                // Hook for on route change
                                $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
                                    console.log('State Change ...');
                                    setLocale();
                                    setMetaData();

                                    //startGremlins();
                                });
                            }
                        );

                        // Load navigation menu
                        settingsService.getMenu().success(
                            function(data, status) {
                                $rootScope.topMenu = data;
                            }
                        );
                        // Load page categories
                        pageCategoryService.getPageCategoryTree().success(
                            function(data, status) {
                                $rootScope.pageCategoryTree = data;
                            }
                        );
                        // Load product categories
                        productCategoryService.getProductCategoryTree().success(
                            function(data, status) {
                                $rootScope.productCategoryTree = data;
                            }
                        );

                        //// Test with Gremlins.js
                        //var startGremlins = function () {
                        //    console.log('Gremlins...');
                        //    if (Environment.settings.gremlins.enabled) {
                        //        gremlins.createHorde()
                        //            .gremlin(gremlins.species.clicker().clickTypes(['click']))
                        //            .unleash({ nb: Environment.settings.gremlins.time});
                        //    }
                        //};
                        //$timeout(function() {
                        //    startGremlins();
                        //}, 1000);

                    }
                }
            }
        ]);
});
