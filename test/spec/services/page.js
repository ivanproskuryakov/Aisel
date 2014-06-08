'use strict';

describe('Controller: page', function () {

    // load the controller's module
    beforeEach(module('aiselApp'));

//    var MainCtrl,
//        scope;
//
//    // Initialize the controller and a mock scope
//    beforeEach(inject(function ($controller, $rootScope, appConfig) {
//        scope = $rootScope.$new();
//        MainCtrl = $controller('MainCtrl', {
//            $scope: scope
//        });
//    }));


    var $scope, $location, $rootScope, createController;

    beforeEach(inject(function($injector) {
        $location = $injector.get('$location');
        $rootScope = $injector.get('$rootScope');
        $scope = $rootScope.$new();

        var $controller = $injector.get('$controller');

        createController = function() {
            return $controller('MainCtrl', {
                '$scope': $scope
            });
        };
    }));

    it('Simple test, we check that our tests is working', function () {
        var controller = createController();
        expect($scope.test).toBe('test');
    });
});
