'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

angular.module('aiselApp')
    .service('rootService', ['$http', '$routeParams', '$rootScope', 'API_URL', 'appSettings',
        function ($http, $routeParams, $rootScope, API_URL, appSettings) {
            return {
                init: function () {
                    var meta = false;
                    var disqus = false;
                    this.getApplicationConfig().success(
                        function (data, status) {
                            console.log('************************ Init Start ************************');
                            appSettings = data.settings;
                            $rootScope.availableLocales = appSettings.locale.available;
                            $rootScope.locale = location.hash.substr(2, 2);
                            console.log($rootScope.availableLocales);
                            console.log($rootScope.availableLocales.indexOf($rootScope.locale));

                            if ($rootScope.availableLocales.indexOf($rootScope.locale) == -1) {
                                $rootScope.locale = $routeParams.locale.primary;
                            }
                            console.log('getApplicationConfig Locale ----> ' + $rootScope.locale);
                            console.log('getApplicationConfig Available Locale ----> ' + $rootScope.availableLocales);
                            console.log('************************ Init End **************************');

                            // Meta
                            meta = JSON.parse(data.config_meta);
                            $rootScope.pageTitle = meta.defaultMetaTitle;
                            $rootScope.metaDescription = meta.defaultMetaDescription;
                            $rootScope.metaKeywords = meta.defaultMetaKeywords;

                            // Disqus
                            disqus = JSON.parse(data.config_disqus);
                            $rootScope.disqusShortname = disqus.shortname;
                            $rootScope.disqusStatus = disqus.status;

                            // Hook for routeChange
                            $rootScope.$on('$routeChangeStart', function (event, to, from) {
                                console.log('************************ Route Start ************************');
                                $rootScope.availableLocales = appSettings.locale.available;
                                $rootScope.locale = location.hash.substr(2, 2);
                                console.log($rootScope.availableLocales);
                                console.log($rootScope.availableLocales.indexOf($rootScope.locale));

                                if ($rootScope.availableLocales.indexOf($rootScope.locale) == -1) {
                                    $rootScope.locale = $routeParams.locale.primary;
                                }
                                console.log('Route Locale ----> ' + $rootScope.locale);
                                console.log('Route Available Locale ----> ' + $rootScope.availableLocales);
                                console.log('************************ Route End **************************');


                                $rootScope.pageTitle = meta.defaultMetaTitle;
                                $rootScope.metaDescription = meta.defaultMetaDescription;
                                $rootScope.metaKeywords = meta.defaultMetaKeywords;
                            });
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
                    //console.log(url);
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
    ])
;
