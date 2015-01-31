@admin.settings
Feature: Settings
  In order to edit settings
  As a backend user
  I want to have access to settings page

  Scenario: Homepage settings action works
    Given I'm logged in as backend user
    And I visit content settings route config_content
    Then I should see homepage settings form

  Scenario: Disqus settings action works
    Given I'm logged in as backend user
    And I visit disqus settings route config_disqus
    Then I should see disqus settings form

  Scenario: META settings action works
    Given I'm logged in as backend user
    And I visit META settings route config_meta
    Then I should see META settings form
