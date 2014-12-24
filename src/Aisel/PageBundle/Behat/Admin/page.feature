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

  Scenario: Add page action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I click on "Add new" link
    And I enter "Test page" in "title"
    And I enter "Dummy test content..." in "content"
    And I enter "test-dummy-url" in "metaUrl"
    And I select "en" in "locale"
    And I select "1" in "status"
    And I select "1" in "commentStatus"
    And I select "1" in "hidden"
    When I press "Create and return to list" button
    Then New entity with "title" = "Test page" has to be displayed

  Scenario: Delete page action works
    Given I'm logged in as backend user
    And I visit page list route admin_aisel_page_page_list
    Then I click on "Delete" button and see confirmation