@api.page
Feature: Pages
  In order view pages
  As a visitor
  I want to be able to have access to Page REST API

  Scenario: Page API is working
    Given Script access api_aisel_pagelist route
    Then Content should contain valid JSON