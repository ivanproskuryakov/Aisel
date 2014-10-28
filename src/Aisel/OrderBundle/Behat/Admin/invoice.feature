@admin.order
Feature: Invoice
  In order to manage invoices from backend
  As a backend user
  I want to make CRUD operations for invoice entities

  Scenario: Region list action works
    Given I'm logged in as backend user
    And I visit invoice list route admin_aisel_order_invoice_list
    Then I should see list of rows

  Scenario: Edit invoice action works
    Given I'm logged in as backend user
    And I visit invoice list route admin_aisel_order_invoice_list
    Then I click on "Edit" button and see edit form

  Scenario: Show invoice action works
    Given I'm logged in as backend user
    And I visit invoice list route admin_aisel_order_invoice_list
    Then I click on "Show" button and see details

  Scenario: Delete invoice action works
    Given I'm logged in as backend user
    And I visit invoice list route admin_aisel_order_invoice_list
    Then I click on "Delete" button and see confirmation