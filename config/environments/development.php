<?php
/**
 * Development Environment
 *
 * @package Dekode
 */

declare( strict_types = 1 );

define( 'SAVEQUERIES', true );
define( 'WP_DEBUG', true );
define( 'SCRIPT_DEBUG', true );

// Needed for Azure storage plugin to work
define( 'DISALLOW_FILE_MODS', true );
