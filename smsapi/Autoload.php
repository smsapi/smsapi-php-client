<?php

spl_autoload_register(
	function ($class) {
		static $classes = null;
		static $path = null;

		if ( $path === null ) {
			$path = dirname( __FILE__ );
		}

		if ( !isset( $classes[ $class ] ) ) {

			if ( preg_match( '/^SMSApi/', $class ) ) {

				$class = explode( "\\", $class );
				unset( $class[ 0 ] );
				$class = implode( DIRECTORY_SEPARATOR, $class );

				$classes[ $class ] = $path . DIRECTORY_SEPARATOR . $class . '.php';
			}
		}

		if ( isset( $classes[ $class ] ) ) {
			require $classes[ $class ];
		}
	}
);
