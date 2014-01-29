'use strict';

describe('Service: Search', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var Search;
  beforeEach(inject(function (_Search_) {
    Search = _Search_;
  }));

  it('should do something', function () {
    expect(!!Search).toBe(true);
  });

});
