'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * Unit Test for Contact Controller.
 */

describe('Unit: Contact Controller', function () {

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
                $scope.config = '{\"Name\":\"Aisel Co.\",\"Email\":\"service@email.com\",\"AddressLine1\":\"1234 South Manhattan Place, LA\",\"AddressLine2\":null,\"information\":\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.<\\\/p>\"}';
            });

            // now run that scope through the controller function,
            // injecting any services or other injectables we need.
            ctrl = $controller('ContactCtrl', {
                '$scope': $scope,
                'rs': rootService
            });

        })
    });

    /* Test 1: Testing an asynchronous service call.
     * Since we've mocked the service with fake call
     * to change $scope.content variable */
    it('Launch mock and ensure that we have config for contact us page', function () {
        rootService.getApplicationConfig();
//        expect(rootService.getApplicationConfig()).toHaveBeenCalled();
        expect($scope.config).not.toBe(false);
    });

});