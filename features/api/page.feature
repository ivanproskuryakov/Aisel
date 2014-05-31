@page.api
Feature: Pages
  In order view page list and single page
  As a visitor
  I want to be able to have access to Page API

  Scenario: List 2 files in a directory
    Given is Behat installed and working "one"
    Then I should get "one"
      """
      one
      one
      """