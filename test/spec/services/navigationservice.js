'use strict';

describe('Service: Navigationservice', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var Navigationservice;
  beforeEach(inject(function (_Navigationservice_) {
    Navigationservice = _Navigationservice_;
  }));

  it('should do something', function () {
    expect(!!Navigationservice).toBe(true);
  });

});
