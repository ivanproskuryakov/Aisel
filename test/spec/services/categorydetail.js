'use strict';

describe('Service: Categorydetail', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var Categorydetail;
  beforeEach(inject(function (_Categorydetail_) {
    Categorydetail = _Categorydetail_;
  }));

  it('should do something', function () {
    expect(!!Categorydetail).toBe(true);
  });

});
