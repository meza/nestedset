@lib
Feature: Removing nodes should be possible with the api.
  Scenario: Remove node
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
    When I remove the node "GrandChild1"
    Then The result is
      | name        | lft | rht |
      | Root        | 1   | 6   |
      | Child1      | 2   | 3   |
      | Child2      | 4   | 5   |

  Scenario: Remove parent node
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
