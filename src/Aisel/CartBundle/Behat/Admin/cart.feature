@admin.cart
Feature: Cart
  In cart to manage carts from backend
  As a backend user
  I want to make CRUD operations for cart entities

  Scenario: Cart list action works
    Given I'm logged in as backend user
    And I visit cart list route admin_aisel_cart_cart_list
    Then I should see list of rows

  Scenario: Edit cart action works
    Given I'm logged in as backend user
    And I visit cart list route admin_aisel_cart_cart_list
    Then I click on "Edit" button and see edit form

  Scenario: Show cart action works
    Given I'm logged in as backend user
    And I visit cart list route admin_aisel_cart_cart_list
    Then I click on "Show" button and see details

  Scenario: Delete cart action works
    Given I'm logged in as backend user
    And I visit cart list route admin_aisel_cart_cart_list
    Then I click on "Delete" button and see confirmation