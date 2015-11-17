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
 * @description     resourceService
 */

define(['app'], function (app) {
    app.service('resourceService', ['$http', 'Environment',
        function ($http, Environment) {

            var resourceService = function (name) {
                this.resource = name;
            };

            resourceService.prototype.getCollection = function (params) {
                var locale = Environment.currentLocale();
                var url = Environment.settings.api +
                    '/' + locale +
                    '/' + this.resource + '/?limit=' + params.limit +
                    '&current=' + params.page +
                    '&order=' + params.order +
                    '&orderBy=' + params.orderBy +
                    '&category=' + params.categoryId;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.getItemByURL = function ($url) {
                var locale = Environment.currentLocale();
                var url = Environment.settings.api +
                    '/' + locale +
                    '/' + this.resource + '/' + $url;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.addReview = function (params) {
                console.log("addReview", params);
            };

            return resourceService;
        }
    ]);
});
