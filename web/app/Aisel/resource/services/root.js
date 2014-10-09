'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */
define(['app'], function (app) {
    console.log('Root Service Loaded ...');
    angular.module('app')
        .service('rootService', ['$http', '$routeParams', '$rootScope', 'API_URL', 'appSettings',
            function ($http, $routeParams, $rootScope, API_URL, appSettings) {
                return {
                    init: function () {
                        var meta = false;
                        var disqus = false;
                        this.getApplicationConfig().success(
                            function (data, status) {

                                // Get settings data
                                appSettings = data.settings;
                                meta = JSON.parse(data.config_meta);
                                disqus = JSON.parse(data.config_disqus);
                                $rootScope.disqusShortname = disqus.shortname;
                                $rootScope.disqusStatus = disqus.status;

                                console.log('*********** Init Start *************');
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
                                    console.log('*********** Route Change ***********');
                                    setLocale();
                                    setMetaData();
                                    console.log('************  Route End ************');
                                });
                                console.log('************ Init End **************');
                            }
                        );

                        // Load menu, categories and so on ...
                        this.getMenu().success(
                            function (data, status) {
                                $rootScope.topMenu = data;
                            }
                        );
                        this.getCategoryTree().success(
                            function (data, status) {
                                $rootScope.categoryTree = data;
                            }
                        );
                        this.getUserInformation().success(
                            function (data, status) {
                                $rootScope.isAuthenticated = false;
                                if (data.username) {
                                    $rootScope.isAuthenticated = true;
                                    $rootScope.user = data;
                                }
                            }
                        );

                    },
                    getApplicationConfig: function () {
                        var url = API_URL + '/config/settings.json';
//                    console.log(url);
                        return $http.get(url);
                    },
                    getCategoryTree: function () {
                        var url = API_URL + '/page/category/tree.json';
//                console.log(url);
                        return $http.get(url);
                    },
                    getMenu: function () {
                        var url = API_URL + '/navigation/menu.json';
//                console.log(url);
                        return $http.get(url);
                    },
                    getUserInformation: function () {
                        var url = API_URL + '/user/information.json';
//                console.log(url);
                        return $http.get(url);
                    }
                };
            }
        ]);
});