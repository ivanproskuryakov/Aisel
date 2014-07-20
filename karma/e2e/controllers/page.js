'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Page
 */

describe("E2E: Check that page is working", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/page/about-aisel/');
    });

    it('We should have a working /page/:pageId/ route', function() {
        expect(browser().location().path()).toBe("/page/about-aisel/");
    });

    it('Check that category description contains text', function() {
        expect(element('.page-header').html()).toContain('About Us');
    });

});