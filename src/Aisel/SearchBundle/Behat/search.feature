@api.search
Feature: Search
  In order to have search functionality
  As a visitor
  I want to be able to have access to Search REST API

  Scenario: Search API is working
    Given Script access api_aisel_search route
    Then Content contains valid JSON