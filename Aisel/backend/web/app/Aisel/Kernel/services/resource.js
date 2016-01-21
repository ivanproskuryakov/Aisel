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
    app.factory('resourceService', ['$http', 'Env', '$rootScope',
        function ($http, Env, $rootScope) {

            var resourceService = function (name, api) {
                this.resource = name;
            };

            resourceService.prototype.getCollection = function (pageLimit, pageNumber, filter) {
                var url = Env.api +
                    '/' + this.resource +
                    '/?limit=' + pageLimit +
                    '&current=' + pageNumber +
                    '&filter=' + filter;

                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.remove = function ($id) {
                var url = Env.api + '/' + this.resource + '/' + $id;
                console.log(url);
                return $http.delete(url);
            };
            resourceService.prototype.get = function ($id) {
                var url = Env.api + '/' + this.resource + '/' + $id;
                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.save = function (data) {
                var url = Env.api + '/' + this.resource +
                    '/' + data.id;
                console.log(data);
                return $http({
                    method: 'PUT',
                    url: url,
                    data: data
                });
            };
            resourceService.prototype.create = function (data) {
                var url = Env.api + '/' + this.resource + '/';

                return $http({
                    method: 'POST',
                    url: url,
                    data: data
                });
            };
            resourceService.prototype.getNodeTree = function (locale) {
                var url = Env.api + '/' + this.resource +
                    '/node/tree/?locale=' + locale;
                console.log(url);
                return $http.get(url);
            };
            resourceService.prototype.getNode = function ($id) {
                var url = Env.api + '/' + this.resource +
                    '/node/' + $id;
                console.log(url);
                return $http.get(url);
            };


            return resourceService;
        }
    ]);
});
