@lib
Feature: Remove
  Scenario: Remove node
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
    When I remove the node "Child1"
    Then The result is
      | name        | lft | rht |
      | Root        | 1   | 4   |
      | Child2      | 2   | 3   |
