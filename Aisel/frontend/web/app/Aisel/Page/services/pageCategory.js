'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     ...
 */

define(['app'], function(app) {
    app.service('pageCategoryService', ['$http', 'Env',
        function($http, Env) {
            return {
                getCollection: function(params) {
                    var locale = Env.currentLocale();
                    var url = Env.api +
                        '/' + locale +
                        '/page/node/?limit=' + params.limit +
                        '&current=' + params.page +
                        '&order=' + params.order +
                        '&orderBy=' + params.orderBy;

                    console.log(url);
                    return $http.get(url);
                },
                getPageCategoryTree: function() {
                    var locale = Env.currentLocale();
                    var url = Env.api + '/' + locale + '/page/node/tree/';
                    console.log(url);

                    return $http.get(url);
                }
            };
        }
    ]);
});
