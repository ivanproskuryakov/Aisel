@admin.addressing
Feature: City
  In order to manage cities from backend
  As a backend user
  I want to make CRUD operations for city entities

  Scenario: City list actions works
    Given I'm logged in as backend user
    And I visit city list route admin_aisel_addressing_city_list
    Then I should see cities

#  Scenario: Show city action works
#    Given I'm logged in as backend user
#    And I visit city list route admin_aisel_addressing_city_list
#    Then I should see list of the cities