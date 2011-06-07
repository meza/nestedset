@lib
Feature: List
  Scenario: List nodes
    Given I have a set
      | name        | lft | rht |
      | Root        | 1   | 8   |
      | Child1      | 2   | 5   |
      | GrandChild1 | 3   | 4   |
      | Child2      | 6   | 7   |
    When I list the tree
    Then The resulting html fragment should be '<ul><li id="Root" name="Root">Root<ul><li id="Child1" name="Root/Child1">Child1<ul><li id="GrandChild1" name="Root/Child1/GrandChild1">GrandChild1</li></ul></li></ul><ul><li id="Child2" name="Root/Child2">Child2</li></ul></li></ul>'

  Scenario: List partial nodes
    Given I have a set
      | name             | lft | rht |
      | Root             |    1 |   14 |
      | Child1           |    2 |   11 |
      | GrandChild1      |    3 |    8 |
      | GrandGrandChild1 |    4 |    5 |
      | GrandGrandChild2 |    6 |    7 |
      | GrandChild2      |    9 |   10 |
      | Child2           |   12 |   13 |
    When I list the tree from node "Child1"
    Then The resulting html fragment should be '<ul><li id="Child1" name="Child1">Child1<ul><li id="GrandChild1" name="Child1/GrandChild1">GrandChild1<ul><li id="GrandGrandChild1" name="Child1/GrandChild1/GrandGrandChild1">GrandGrandChild1</li></ul><ul><li id="GrandGrandChild2" name="Child1/GrandChild1/GrandGrandChild2">GrandGrandChild2</li></ul></li></ul><ul><li id="GrandChild2" name="Child1/GrandChild2">GrandChild2</li></ul></li></ul>'