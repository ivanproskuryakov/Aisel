'use strict';

angular.module('projectxApp')
  .filter('pagination', function () {
    return function(input, limit, total) {

        var pagesTotal =  total / limit;
        if (pagesTotal % 1 !== 0) {
            pagesTotal =  parseInt(pagesTotal) + 1;
        }
        for (var i=1; i<=pagesTotal; i++)
            input.push(i);
        return input;
    };
  }
);
