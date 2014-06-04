'use strict';

describe('Service: Contactservice', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var Contactservice;
  beforeEach(inject(function (_Contactservice_) {
    Contactservice = _Contactservice_;
  }));

  it('should do something', function () {
    expect(!!Contactservice).toBe(true);
  });

});
