@api.page
Feature: Pages and categories
  In order view pages and categories
  As a visitor
  I want to be able to have access to Page REST API

  Scenario: Page API is working
    Given Script access api_aisel_pagelist route
    Then Content contains valid Page JSON

  Scenario: Page category API is working
    Given Script access api_aisel_page_categorylist route
    Then Content contains valid Category JSON