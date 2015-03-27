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
 * @description     PageCategoryCtrl
 */

define(['app'], function (app) {
    app.controller('PageCategoryCtrl', function ($scope, $stateParams, pageService, $state, Environment) {

        $scope.sectionName = 'Page categories';
        $scope.categoryJson = Environment.settings.api + '/page/category/';

    });
});