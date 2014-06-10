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


    beforeEach(function () {

        module('aiselApp');

        /* declare mock for our rootService service
         * and use it with call to set our $scope.content variable
         */
        rootService = jasmine.createSpyObj('rootService', ['getApplicationConfig']);

        inject(function ($injector) {

            $rootScope = $injector.get('$rootScope');
            $scope = $rootScope.$new();
            $controller = $injector.get('$controller');

            // set content for homepage
            rootService.getApplicationConfig.andCallFake(function () {
                $scope.content = 'homepage content';
            });

            // now run that scope through the controller function,
            // injecting any services or other injectables we need.
            ctrl = $controller('HomepageCtrl', {
                '$scope': $scope,
                'rs': rootService
            });

        })
    });

    /* Test 1: The simplest of the simple.
     * here we're going to test that some $scope.content
     * populated when the controller function was evaluated. */
    it('Check that our $scope.content eq. false', function () {
        expect($scope.content).toBe(false);
    });

    /* Test 2: Testing an asynchronous service call.
     * Since we've mocked the service with fake call
     * to change $scope.content variable */
    it('Launch mock and ensure that we have content for homepage', function () {
        rootService.getApplicationConfig();
//        expect(rootService.getApplicationConfig()).toHaveBeenCalled();
        expect($scope.content).not.toBe(false);
    });

});
