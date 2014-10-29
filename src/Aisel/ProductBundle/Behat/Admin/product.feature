@admin.product
Feature: Page
  In product to manage products from backend
  As a backend user
  I want to make CRUD operations for product entities

  Scenario: Product list action works
    Given I'm logged in as backend user
    And I visit product list route admin_aisel_product_product_list
    Then I should see list of rows

  Scenario: Edit product action works
    Given I'm logged in as backend user
    And I visit product list route admin_aisel_product_product_list
    Then I click on "Edit" button and see edit form

  Scenario: Show product action works
    Given I'm logged in as backend user
    And I visit product list route admin_aisel_product_product_list
    Then I click on "Show" button and see details

  Scenario: Delete product action works
    Given I'm logged in as backend user
    And I visit product list route admin_aisel_product_product_list
    Then I click on "Delete" button and see confirmation