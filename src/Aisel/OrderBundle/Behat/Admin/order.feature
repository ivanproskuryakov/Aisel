@admin.order
Feature: Order
  In order to manage orders from backend
  As a backend user
  I want to make CRUD operations for order entities

  Scenario: Order list action works
    Given I'm logged in as backend user
    And I visit order list route admin_aisel_order_order_list
    Then I should see list of rows

  Scenario: Edit order action works
    Given I'm logged in as backend user
    And I visit order list route admin_aisel_order_order_list
    Then I click on "Edit" button and see edit form

  Scenario: Show order action works
    Given I'm logged in as backend user
    And I visit order list route admin_aisel_order_order_list
    Then I click on "Show" button and see details

  Scenario: Delete order action works
    Given I'm logged in as backend user
    And I visit order list route admin_aisel_order_order_list
    Then I click on "Delete" button and see confirmation