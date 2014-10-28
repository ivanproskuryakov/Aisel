@api.frontenduser
Feature: FrontendUser
  In order have access to user specific functionality
  As a visitor
  I want to be able to have access to User REST API

  Scenario: User API is working
    Given Script access api_aisel_user_information route
    Then Content contains valid JSON