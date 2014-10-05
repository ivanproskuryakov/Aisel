'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Category page
 */

describe("E2E: Check category page is working", function() {

    beforeEach(function() {
        browser().navigateTo('/#/en/category/category-first-level-1/');
    });

    it('We should have a working /category/:categoryId/ route', function() {
        expect(browser().location().path()).toBe("/category/category-first-level-1/");
    });

    it('Check that category description contains text', function() {
        expect(element('.page-header').html()).toContain('First 1');
    });

});