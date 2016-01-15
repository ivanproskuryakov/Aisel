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
    app.service('resourceService', ['$http', 'Env',
        function ($http, Env) {

            var resourceService = function (name) {
                this.resource = name;
            };

            resourceService.prototype.getCollection = function (params) {
                var locale = Env.currentLocale();
                var url = Env.api +
                    '/' + locale +
                    '/' + this.resource +
                    '/?limit=' + params.limit +
                    '&current=' + params.page +
                    '&order=' + params.order +
                    '&orderBy=' + params.orderBy +
                    '&category=' + params.categoryId;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.getItemByURL = function ($url) {
                var locale = Env.currentLocale();
                var url = Env.api +
                    '/' + locale +
                    '/' + this.resource +
                    '/' + $url;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.addReview = function (data) {
                console.log("addReview", data);
                var locale = Env.currentLocale();
                var url = Env.api +
                    '/' + locale +
                    '/' + this.resource +
                    '/review/';

                console.log(url);
                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            };

            return resourceService;
        }
    ]);
});
