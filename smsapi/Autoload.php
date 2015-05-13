<?php

spl_autoload_register(
    function ($class) {
        static $classes = null;
        static $path = null;

        if ( $path === null ) {
            $path = dirname( __FILE__ );
        }

        $cname = strtolower(str_replace("\\", "", $class));

        if ( !isset( $classes[ $cname ] ) ) {

            if ( preg_match( '/^smsapi/', $cname ) ) {

                $classmap = include 'autoload_classmap.php';

                if(isset($classmap[$cname])){
                    $class = explode( "\\", $classmap[$cname] );
                }else{
                    $class = explode( "\\", $class );
                }

                unset( $class[ 0 ] );
                $class = implode( DIRECTORY_SEPARATOR, $class );

                $classes[ $cname ] = $path . DIRECTORY_SEPARATOR . $class . '.php';
            }

        }

        if ( isset( $classes[ $cname ] ) ) {
            require $classes[ $cname ];
        }
    }
);
