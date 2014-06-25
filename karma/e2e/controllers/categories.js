'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Category listing
 */

describe("E2E: Check category listing is working", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/categories/');
    });

    it('We should have a working /categories/ route', function() {
        expect(browser().location().path()).toBe("/categories/");
    });

    it('Check that page contains at least 1 category and pagination is working', function() {
        expect(element('.pageList li').count()).toBeGreaterThan(0);
        element('.pagination li:eq(2) a').click();
        expect(element('.pagination-info').html()).toContain('Current: 2');
    });

});