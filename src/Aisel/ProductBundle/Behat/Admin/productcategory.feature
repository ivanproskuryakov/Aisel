@admin.productcategory
Feature: Category
  In category to manage product categories from backend
  As a backend user
  I want to make CRUD operations for product category entities

  Scenario: Category list action works
    Given I'm logged in as backend user
    And I visit category list route admin_aisel_product_category_list