@ajax
Feature: Renaming nodes should be available through REST POST
  Scenario: Rename node
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
    When I http post to the node "Child1" the name "Renamed Child 1"
    Then The result is
      | name            | lft | rht |
      | Root            | 1   | 8   |
      | Renamed Child 1 | 2   | 5   |
      | GrandChild1     | 3   | 4   |
      | Child2          | 6   | 7   |
    And The response code is 200
