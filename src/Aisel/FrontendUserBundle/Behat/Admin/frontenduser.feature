@admin.frontenduser
Feature: FrontendUser
  In order to manage frontend users from backend
  As a backend user
  I want to make CRUD operations for user entities

  Scenario: frontend user list action works
    Given I'm logged in as backend user
    And I visit frontend user list route admin_aisel_frontenduser_frontenduser_list
    Then I should see list of rows

  Scenario: Edit frontend user action works
    Given I'm logged in as backend user
    And I visit frontend user list route admin_aisel_frontenduser_frontenduser_list
    Then I click on "Edit" button and see edit form

  Scenario: Show frontend user action works
    Given I'm logged in as backend user
    And I visit frontend user list route admin_aisel_frontenduser_frontenduser_list
    Then I click on "Show" button and see details

  Scenario: Delete frontend user action works
    Given I'm logged in as backend user
    And I visit frontend user list route admin_aisel_frontenduser_frontenduser_list
    Then I click on "Delete" button and see confirmation