'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * Midway Contact Page Test
 */

describe("Midway: Ensure that our contact page is working ", function() {

    var tester;
    beforeEach(function() {
        tester = ngMidwayTester('aiselApp');
    });

    afterEach(function() {
        tester.destroy();
        tester = null;
    });

    it('should have a working Contact page', function(done) {
        tester.visit('/contact/', function() {

            var current = tester.inject('$route').current;
            var controller = current.controller;
            var template = current.templateUrl;

            expect(controller).to.eql('ContactCtrl');
            expect(template).to.eql('views/contact.html');
            done();
        });
    });

});