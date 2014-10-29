@admin.contact
Feature: Contact Settings
  In order to edit contact settings
  As a backend user
  I want to have access to contact settings page

  Scenario: Contact settings action works
    Given I'm logged in as backend user
    And I visit contact settings route config_contact
    Then I should see contact settings form
