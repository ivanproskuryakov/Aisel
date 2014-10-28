@admin.backenduser
Feature: BackendUser
  In order to manage backend users from backend
  As a backend user
  I want to make CRUD operations for user entities

  Scenario: Backend user list action works
    Given I'm logged in as backend user
    And I visit backend user list route admin_aisel_backenduser_backenduser_list
    Then I should see list of rows

  Scenario: Edit backend user action works
    Given I'm logged in as backend user
    And I visit backend user list route admin_aisel_backenduser_backenduser_list
    Then I click on "Edit" button and see edit form

  Scenario: Show backend user action works
    Given I'm logged in as backend user
    And I visit backend user list route admin_aisel_backenduser_backenduser_list
    Then I click on "Show" button and see details

  Scenario: Delete backend user action works
    Given I'm logged in as backend user
    And I visit backend user list route admin_aisel_backenduser_backenduser_list
    Then I click on "Delete" button and see confirmation