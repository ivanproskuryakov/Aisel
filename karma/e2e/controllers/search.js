'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 *
 * E2E Page
 */

describe("E2E: Page search", function() {

    beforeEach(function() {
        browser().navigateTo('/#!/search/and');
    });

    it('We should have a working /search/:query route', function() {
        expect(browser().location().path()).toBe("/search/and");
    });

    it('Check that we have search results and pagination working', function() {
        expect(element('.pageList li').count()).toBeGreaterThan(0);
        element('.pagination li:eq(2) a').click();
        expect(element('.pull-right.pagination').html()).toContain('Current: 2');
    });

});