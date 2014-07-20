'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * Unit Test for Homepage Controller.
 */

describe('Unit: Homepage Controller', function () {

    var $scope,
        $rootScope,
        ctrl,
        $controller,
        rootService;

    beforeEach(
        module('aiselApp')
    );

    beforeEach(
        inject(function ($injector) {

            $rootScope = $injector.get('$rootScope');
            $scope = $rootScope.$new();
            $controller = $injector.get('$controller');

            ctrl = $controller('HomepageCtrl', {
                '$scope': $scope
            });

        })
    );

    /* Test 1: The simplest of the simple.
     * here we're going to test that some $scope.content
     * populated when the controller function was evaluated. */
    it('Check that our $scope.content eq. false', function () {
        expect($scope.content).toBe(false);
    });

});
