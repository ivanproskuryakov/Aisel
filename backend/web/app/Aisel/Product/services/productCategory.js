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
 * @description     productCategoryService
 */

define(['app'], function (app) {
    app.service('productCategoryService', ['resourceService', function (resourceService) {
        return new resourceService('product/category');
    }]);
});