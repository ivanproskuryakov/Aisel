@admin.navigation
Feature: Navigation Menu
  In order to manage navigation menus from backend
  As a backend user
  I want to make CRUD operations for menu entities

  Scenario: navigation menu list action works
    Given I'm logged in as backend user
    And I visit navigation menu tree route admin_aisel_navigation_menu_list
#    Then I should see rows displayed as a tree

  Scenario: Add navigation action works
    Given I'm logged in as backend user
    And I visit navigation menu tree route admin_aisel_navigation_menu_list
    Then I click on "Add new" link
    And I enter "Test link" in "title"
    And I enter "test-dummy-url" in "metaUrl"
    And I select "en" in "locale"
    And I select "0" in "status"
    When I press "Create and return to list" button
    Then New entity with "title" = "Test link" has to be displayed


#  Scenario: Edit navigation menu action works
#    Given I'm logged in as backend user
#    And I visit navigation menu tree route admin_aisel_navigation_menu_list
#    Then I click on "Edit" button and see edit form
#
#  Scenario: Show navigation menu action works
#    Given I'm logged in as backend user
#    And I visit navigation menu tree route admin_aisel_navigation_menu_list
#    Then I click on "Show" button and see details
#
#  Scenario: Delete navigation menu action works
#    Given I'm logged in as backend user
#    And I visit navigation menu tree route admin_aisel_navigation_menu_list
#    Then I click on "Delete" button and see confirmation