'use strict';

describe('Service: Category', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var Category;
  beforeEach(inject(function (_Category_) {
    Category = _Category_;
  }));

  it('should do something', function () {
    expect(!!Category).toBe(true);
  });

});
