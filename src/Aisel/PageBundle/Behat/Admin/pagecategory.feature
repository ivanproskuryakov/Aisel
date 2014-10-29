@admin.pagecategory
Feature: Category
  In category to manage page categories from backend
  As a backend user
  I want to make CRUD operations for page category entities

  Scenario: Category list action works
    Given I'm logged in as backend user
    And I visit category list route admin_aisel_page_category_list