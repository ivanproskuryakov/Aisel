@api.product
Feature: Product
  In order view products
  As a visitor
  I want to be able to have access to Product REST API

  Scenario: Product API is working
    Given Script access api_aisel_productlist route
    Then Content contains valid JSON