<?php
/**
 * Create test data.
 *
 * @package Dekode\Tests
 */

$demo_content_dir = new DirectoryIterator( __DIR__ . '/codeception/_data' );

foreach ( $demo_content_dir as $file ) {
	// Skip dot-files used for directory traversal.
	if ( $file->isDot() || '.' === substr( $file->getFilename(), 0, 1 ) ) {
		continue;
	}

	preg_match( '/(.+?)-(.+)/', $file->getFilename(), $post_parts );

	$post_title = str_replace(
		array(
			'.' . $file->getExtension(),
			'-',
		),
		array(
			'',
			' ',
		),
		$post_parts[2]
	);

	$command = sprintf(
		'wp post create --post_title="%s" --post_status="publish" --post_type="%s" "%s"',
		ucfirst( $post_title ),
		$post_parts[1],
		$file->getPath() . '/' . $file->getFilename()
	);

	echo $command . "\n";

	exec( $command );
}
