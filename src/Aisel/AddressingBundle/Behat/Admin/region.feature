@admin.addressing
Feature: Region
  In order to manage regions from backend
  As a backend user
  I want to make CRUD operations for region entities

  Scenario: Region list action works
    Given I'm logged in as backend user
    And I visit region list route admin_aisel_addressing_region_list
    Then I should see list of rows

  Scenario: Edit region action works
    Given I'm logged in as backend user
    And I visit region list route admin_aisel_addressing_region_list
    Then I click on "Edit" button and see edit form

  Scenario: Show region action works
    Given I'm logged in as backend user
    And I visit region list route admin_aisel_addressing_region_list
    Then I click on "Show" button and see details

  Scenario: Delete region action works
    Given I'm logged in as backend user
    And I visit region list route admin_aisel_addressing_region_list
    Then I click on "Delete" button and see confirmation