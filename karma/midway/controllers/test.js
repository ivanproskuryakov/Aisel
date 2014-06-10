'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * Midway Test
 */

describe("Midway: 1st test", function() {

    var tester;
    beforeEach(function() {
        if(tester) {
            tester.destroy();
        }
        tester = ngMidwayTester('aiselApp');
    });

    afterEach(function() {
        tester.destroy();
        tester = null;
    });

    it('should have a working scope page', function(done) {
        tester.visit('/contact/', function() {

            var current = tester.inject('$route').current;
            var controller = current.controller;
            var scope = current.scope;

            console.log(tester.path());
            console.log(scope.config);
            console.log(tester.viewElement().html());
            done();
        });
    });

});