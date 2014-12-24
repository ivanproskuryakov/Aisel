@admin.product
Feature: Page
  In product to manage products from backend
  As a backend user
  I want to make CRUD operations for product entities


  Scenario: Add product action works
    Given I'm logged in as backend user
    And I visit product list route admin_aisel_product_product_list
    Then I click on "Add new" link
    And I enter "Test product" in "name"
    And I enter "test-sku" in "sku"
    And I enter "test-product" in "metaUrl"
    And I select "en" in "locale"
    And I select "0" in "status"
    And I select "100" in "qty"
    And I enter "test short description..." in "descriptionShort"
    And I enter "test description..." in "description"
    And I enter "1000" in "price"
    And I enter "900" in "priceSpecial"
    When I press "Create and return to list" button
    Then New entity with "name" = "Test product" has to be displayed

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
