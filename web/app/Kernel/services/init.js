'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Init service
 */
define(['app'], function (app) {
    console.log('Kernel Init service loaded ...');
    angular.module('app')
        .service('initService', ['$http', '$routeParams', '$rootScope', 'rootService', 'appSettings',
            function ($http, $routeParams, $rootScope, rootService, appSettings) {
                return {
                    launch: function () {
                        var meta = false;
                        var disqus = false;
                        var general = false;

                        // Load user status
                        rootService.getUserInformation().success(
                            function (data, status) {
                                //console.log(data);
                                if (data.username) {
                                    $rootScope.user = data;
                                    $rootScope.isAuthenticated = true;
                                }
                            }
                        );

                        // Load settings data
                        rootService.getApplicationConfig().success(
                            function (data, status) {
                                appSettings = data.settings;
                                general = JSON.parse(data.config_general);
                                meta = JSON.parse(data.config_meta);
                                disqus = JSON.parse(data.config_disqus);
                                $rootScope.disqusShortname = disqus.shortname;
                                $rootScope.disqusStatus = disqus.status;
                                $rootScope.currency = general.currency;

                                console.log('----------- Init start -----------');
                                var setLocale = function () {
                                    $rootScope.availableLocales = appSettings.locale.available;
                                    $rootScope.locale = Aisel.getLocale();
                                }
                                var setMetaData = function () {
                                    $rootScope.pageTitle = meta.defaultMetaTitle;
                                    $rootScope.metaDescription = meta.defaultMetaDescription;
                                    $rootScope.metaKeywords = meta.defaultMetaKeywords;
                                }

                                // Init
                                setLocale();
                                setMetaData();

                                // Hook for on route change
                                $rootScope.$on('$routeChangeStart', function (event, to, from) {
                                    console.log('Route Change ...');
                                    setLocale();
                                    setMetaData();
                                });
                            }
                        );

                        // Load navigation menu
                        rootService.getMenu().success(
                            function (data, status) {
                                $rootScope.topMenu = data;
                            }
                        );
                        // Load page categories
                        rootService.getPageCategoryTree().success(
                            function (data, status) {
                                $rootScope.pageCategoryTree = data;
                            }
                        );
                        // Load product categories
                        rootService.getProductCategoryTree().success(
                            function (data, status) {
                                $rootScope.productCategoryTree = data;
                            }
                        );
                    },
                }
            }
        ]);
});