Feature: Rename
  Scenario: Rename node
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
    When I rename the node "Child1" to "Renamed Child 1"
    Then The result is
      | name            | lft | rht |
      | Root            | 1   | 8   |
      | Renamed Child 1 | 2   | 5   |
      | GrandChild1     | 3   | 4   |
      | Child2          | 6   | 7   |
