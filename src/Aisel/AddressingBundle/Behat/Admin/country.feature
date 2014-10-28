@admin.addressing
Feature: Country
  In order to manage countries from backend
  As a backend user
  I want to make CRUD operations for country entities

  Scenario: Country list action works
    Given I'm logged in as backend user
    And I visit country list route admin_aisel_addressing_country_list
    Then I should see list of rows

  Scenario: Edit country action works
    Given I'm logged in as backend user
    And I visit country list route admin_aisel_addressing_country_list
    Then I click on "Edit" button and see edit form

  Scenario: Show country action works
    Given I'm logged in as backend user
    And I visit country list route admin_aisel_addressing_country_list
    Then I click on "Show" button and see details

  Scenario: Delete country action works
    Given I'm logged in as backend user
    And I visit country list route admin_aisel_addressing_country_list
    Then I click on "Delete" button and see confirmation