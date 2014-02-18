'use strict';

describe('Service: User', function () {

  // load the service's module
  beforeEach(module('projectxApp'));

  // instantiate service
  var User;
  beforeEach(inject(function (_User_) {
    User = _User_;
  }));

  it('should do something', function () {
    expect(!!User).toBe(true);
  });

});
