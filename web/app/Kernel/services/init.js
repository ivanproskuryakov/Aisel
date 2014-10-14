'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
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
                                meta = JSON.parse(data.config_meta);
                                disqus = JSON.parse(data.config_disqus);
                                $rootScope.disqusShortname = disqus.shortname;
                                $rootScope.disqusStatus = disqus.status;

                                console.log('----------- Init start -----------');
                                var setLocale = function () {
                                    $rootScope.availableLocales = appSettings.locale.available;
                                    $rootScope.locale = location.hash.substr(2, 2);
                                    if ($rootScope.availableLocales.indexOf($rootScope.locale) == -1) {
                                        $rootScope.locale = $routeParams.locale.primary;
                                    }
                                    console.log('Locale ----> ' + $rootScope.locale);
                                    console.log('Locales ----> ' + $rootScope.availableLocales);
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

                                console.log('----------- Init End -----------');
                            }
                        );

                        // Load navigation menu
                        rootService.getMenu().success(
                            function (data, status) {
                                $rootScope.topMenu = data;
                            }
                        );
                        // Load categories
                        rootService.getCategoryTree().success(
                            function (data, status) {
                                $rootScope.categoryTree = data;
                            }
                        );
                    },
                }
            }
        ]);
});