'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Contact us page test
 */

describe("E2E: Contact page contains information and contact form is working ", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/contact/');
    });

    it('We should have a working /contact/ route', function() {
        expect(browser().location().path()).toBe("/contact/");
    });

    it('Contact page should have name', function() {
        expect(element('.config-name').html()).toContain('Aisel Co.');
    });

});