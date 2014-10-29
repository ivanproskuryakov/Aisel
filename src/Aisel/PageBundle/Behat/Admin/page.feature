@admin.page
Feature: Page
  In order to manage pages from backend
  As a backend user
  I want to make CRUD operations for page entities

  Scenario: Page list action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I should see list of rows

  Scenario: Edit page action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I click on "Edit" button and see edit form

  Scenario: Show page action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I click on "Show" button and see details

  Scenario: Delete page action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I click on "Delete" button and see confirmation