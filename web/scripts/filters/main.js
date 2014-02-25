'use strict';

angular.module('aiselApp')
  .filter('text', function () {
        return function(text, name){
            return text;
        };
  }
);
