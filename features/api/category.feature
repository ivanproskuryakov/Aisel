@api.category
Feature: Categories
  In order view categories
  As a visitor
  I want to be able to have access to Category REST API

  Scenario: Category API is working
    Given Script access api_aisel_categorylist route
    Then Content contains valid JSON