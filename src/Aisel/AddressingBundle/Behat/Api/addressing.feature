@api.addressing
Feature: City
  In order view cities
  As a visitor
  I want to be able to have access to city REST API

  Scenario: Addressing API for cities is working
    Given Script access api_aisel_addressing_city_list route
    Then Content contains valid JSON