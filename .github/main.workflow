workflow "Test library" {
  on = "push"
  resolves = ["Tests"]
}

action "Lint" {
  uses = "./.github/actions/php"
  runs = "make"
  args = "lint"
}

action "Tests" {
  needs = ["Lint"]
  uses = "./.github/actions/php"
  runs = "make"
  args = "tests"
}
