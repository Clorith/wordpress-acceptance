<?php

use Codeception\Util\Locator;

class kitchenSinkCest {
	/**
	 * Set up the test scenario.
	 *
	 * @param AcceptanceTester $I
	 */
	public function _before( AcceptanceTester  $I ) {
		$I->amOnPage( '/kitchen-sink' );

		$I->canSeeResponseCodeIsSuccessful();
	}

	/**
	 * Test that the quote blocks generate expected markup.
	 *
	 * @param AcceptanceTester $I
	 */
	public function quotesTest( AcceptanceTester $I ) {
		$I->canSeeElement( '.wp-block-pullquote' );
	}

	/**
	 * Test that the column blocks generate expected markup.
	 *
	 * @param AcceptanceTester $I
	 */
	public function columnBlocksTest( AcceptanceTester $I ) {
		$I->canSeeElement( '.wp-block-columns' );
	}

	/**
	 * Test that the subtitle blocks generate expected markup.
	 *
	 * @param AcceptanceTester $I
	 *
	 * @throws Exception
	 */
	public function subTitleTest( AcceptanceTester $I ) {
		$I->see( 'Subheading', Locator::combine( 'h2', 'h3' ) );
	}

	/**
	 * Test that no warnings are hidden in the site source.
	 *
	 * @param AcceptanceTester $I
	 */
	public function noWarningsTest( AcceptanceTester $I ) {
		$I->dontSeeInSource( 'Warning: ' );
	}
}
