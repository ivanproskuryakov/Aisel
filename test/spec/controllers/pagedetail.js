'use strict';

describe('Controller: PagedetailCtrl', function () {

  // load the controller's module
  beforeEach(module('projectxApp'));

  var PagedetailCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PagedetailCtrl = $controller('PagedetailCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
