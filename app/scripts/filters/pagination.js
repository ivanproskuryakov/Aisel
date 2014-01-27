'use strict';

angular.module('projectxApp')
  .filter('pagination', function () {
    return function(input, min, max) {
        min = parseInt(min); //Make string input int
        max = parseInt(max);
        for (var i=min; i<=max; i++)
            input.push(i);
        return input;
    };
  });
