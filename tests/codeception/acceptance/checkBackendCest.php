<?php

class checkBackendCest
{
	/**
	 * Set up the test scenario.
	 *
	 * @param AcceptanceTester $I
	 */
    public function _before(AcceptanceTester $I)
    {
	    $I->loginAsAdmin();
    }

	/**
	 * Test that the backend can be used.
	 *
	 * @param AcceptanceTester $I
	 */
    public function editPostPageTest( AcceptanceTester $I )
    {
	    $I->amEditingPostWithId( 1 );

	    // Make sure no server errors happened loading the editor.
	    $I->canSeeResponseCodeIsSuccessful();

	    // Check if "Warning:" is found in the source, which indicate deprecation notices or similar.
	    $I->dontSeeInSource( 'Warning: ' );
    }
}
