# WordPress Acceptance

This project is a rough example of how one could set up a composer-ized deployment layer of WordPress, with built in
acceptance testing for incoming Pull Requests, and deployments.

---

## Building

Grab WordPress, themes and plugins by fetching them through composer.

`composer install`

---

### Testing

When a Pull Request (PR) is opened, certain tests will be performed against the PR if it is done against a specific branch.

- PR towards the `master` branch will have tests ran that **must** pass to merge the PR.
- PR towards the `stage` branch will have tests ran that **should** pass to merge the PR, but are allowed to fail if there's an intent behind it.
- PR towards the `develop` branch will **not** have tests ran, this branch may be broken while performing development tasks.

The build system intentionally separates the build, and the test framework with two different composer files, this allows for more flexibility in removing elements before a deploy.

#### Syntax checking

Each PHP file in the project is checked for syntax errors according ot the PHP version defined in the
test file (this version is currently **7.3**), and should also match the PHP dependency set in the `composer.json` file.

#### Security

Automated security tests are done using various code standard rules, most notably `WordPress.Security` from WPCS (WordPress Coding Standards), a set of custom rules for PHPCS.

The rules are defined in `./tests/phpcs.xml.dist`, where other options, as well as exceptions and runtime alternatives are set.

#### Acceptance testing

To run acceptance tests, start by setting up the composer dependencies for it by running `composer install` inside the `./tests` directory.

Running the actual tests can be done with `composer run codecept`, also from within the `./tests` directory.

Your local test site should be a single site install, for the purpose of testing this is sufficient, and will be faster than a multisite in this case.

The acceptance test uses WP-Browser, a layer on top of Codeception for emulating a real user browsing a website. This allows tests to be written which interact with forms, navigate menu items, and so on.

##### Test data

The test data gets populated using WP-CLI, by creating posts or pages, and fetching the content for them from the `./tests/codeception/_data/` directory.

This method allows for faster creation of test data, than the more frequent method of loading up SQL files.

The naming format of the test data files should be `{post_type}-{post_title}.txt`, any new file introduced will be parsed and the page created at runtime.

**Note:** Should there in the future be need to test data manipulation, this should be migrated to an SQL dump format, to allow for easy resets between individual tests.

##### Tests scenarios

Tests can be found in the `tests/codeception/acceptance/` directory.

You can scaffold a new test easily by running `composer run make-test -- <objectToTest>` from the `tests` directory, where `<objectToTest>` is the name of the feature that should be tested (proper naming makes it easy to quickly identify which files does what).
