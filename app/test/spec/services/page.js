'use strict';

describe('Service: Page', function () {

  // load the service's module
  beforeEach(module('appApp'));

  // instantiate service
  var Page;
  beforeEach(inject(function (_Page_) {
    Page = _Page_;
  }));

  it('should do something', function () {
    expect(!!Page).toBe(true);
  });

});
