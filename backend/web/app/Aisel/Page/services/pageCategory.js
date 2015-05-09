'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     pageCategoryService
 */

define(['app'], function (app) {
    app.service('pageCategoryService', ['resourceService', function (resourceService) {
        return new resourceService('page/category');
    }]);
});