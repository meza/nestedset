Feature: Insert
  Insert a Root to the nested set

  Scenario: New root element
    Given I have an empty set
     When I enter a node with the name "Root"
     Then The result is
       | name | lft | rht |
       | Root | 1   | 2   |

  Scenario: New child element
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 6   |
      | Child1      | 2   | 3   |
      | Child2      | 4   | 5   |
    When I enter a node under "Child1" with the name "GrandChild1"
    Then The result is
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |

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