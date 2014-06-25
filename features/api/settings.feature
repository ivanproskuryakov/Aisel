@api.settings
Feature: Settings
  In order view homepage and have settings
  As a visitor
  I want to be able to have access to Settings REST API

  Scenario: Settings API is working
    Given Script access api_aisel_config route
    Then Content contains valid JSON