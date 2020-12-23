<?php

use Codeception\Util\Locator;

class notFoundCest
{
	/**
	 * Set up the test scenario.
	 *
	 * @param AcceptanceTester $I
	 */
    public function _before(AcceptanceTester $I)
    {
    	// Navigate to test URL.
	    $I->amOnPage( '/page-does-not-exist' );
    }

	/**
	 * Test that 404 pages generate as expected.
	 *
	 * @param AcceptanceTester $I
	 */
    public function verifyNotFoundTest(AcceptanceTester $I)
    {
	    // Ensure test page is a 404 pageand is treated as expected.
	    $I->canSeeResponseCodeIs( 404 );

	    $I->see( 'Page Not Found', 'h1' );
    }
}
