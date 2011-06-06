@ajax
Feature: Insert
  Insert a Root to the nested set

  Scenario: New root element
    Given I have an empty set
     When I http put a node with the name "Root"
     Then The result is
       | name | lft | rht |
       | Root | 1   | 2   |
      And The response code is 201

  Scenario: New child element
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 6   |
      | Child1      | 2   | 3   |
      | Child2      | 4   | 5   |
    When I http put a node to "Child1" with the name "GrandChild1"
    Then The result is
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
     And The response code is 201
