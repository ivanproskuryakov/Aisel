@api.order
Feature: Order
  In order view order
  As a visitor
  I want to be able to have access to Order REST API

  Scenario: Order API is working
    Given Script access api_aisel_orderlist route
    Then Content contains valid JSON