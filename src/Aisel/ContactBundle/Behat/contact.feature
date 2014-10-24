@api.contact
Feature: Contact
  In order to have contact functionality working
  As a visitor
  I want to be able to have access to contact REST API

  Scenario: Contact API is working
    Given Script access api_aisel_contactsend route
    Then Content contains valid JSON