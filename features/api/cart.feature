@api.cart
Feature: Cart
  In order view cart
  As a visitor
  I want to be able to have access to Cart REST API

  Scenario: Cart API is working
    Given Script access api_aisel_cart_details route
    Then Content contains valid JSON