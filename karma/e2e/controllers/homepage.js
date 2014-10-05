'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Homepage test
 */

describe("E2E: We check that our app is feeling nice and homepage contains some information  ", function() {

    beforeEach(function() {
        browser().navigateTo('/#/en/');
    });

    it('We should have a working / route', function() {
        expect(browser().location().path()).toBe("/");
    });

    it('Homepage should contain some content', function() {
        expect(element('#dynamic-content').html()).toContain('This is Homepage');
    });

});