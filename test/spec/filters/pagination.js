'use strict';

describe('Filter: pagination', function () {

  // load the filter's module
  beforeEach(module('projectxApp'));

  // initialize a new instance of the filter before each test
  var pagination;
  beforeEach(inject(function ($filter) {
    pagination = $filter('pagination');
  }));

  it('should return the input prefixed with "pagination filter:"', function () {
    var text = 'angularjs';
    expect(pagination(text)).toBe('pagination filter: ' + text);
  });

});
