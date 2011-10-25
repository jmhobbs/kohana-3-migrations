<?php
	defined('SYSPATH') or die('No direct script access.');

	class Controller_Migrations extends Controller {

		public function __construct () {
			// Command line access ONLY
			if( 'cli' != PHP_SAPI ) { die( 'oops' ); url::redirect( '/' ); }
			$this->stdout = fopen( 'php://stdout', 'w' );
			$this->out( "\n=======================[ Kohana Migrations ]=======================\n\n" );
			$this->migrations = new Migrations();
		}

		public function __destruct () {
			fclose( $this->stdout );
		}

		public function out ( $line = "\n" ) {
			fwrite( $this->stdout, $line );
			fflush( $this->stdout );
		}

		public function action_index () {
			$this->_print_status();
			$this->out();
			$this->out( "===================================================================\n\n" );
		}

		public function action_up ( $version = null ) { $this->_migrate( intval( $version ) ); }

		public function action_down ( $version = null ) { $this->_migrate( intval( $version ), true ); }

		protected function _migrate ( $version, $down = false ) {
			if( is_null( $version ) or ( ! $down and 0 == $version ) )
				$version = $this->migrations->last_schema_version();

			$current_version = $this->migrations->get_schema_version();
			$last_version = $this->migrations->last_schema_version();

			$direction = ( $down ) ? 'DOWN' : 'UP';

			$this->_print_status( 'Migrate' );

			$out = <<<EOF

===================================================================

  Requested Migration: $version
            Migrating: $direction

===================================================================


EOF;
		$this->out( $out );

			if( $down ) {
				if( $version >= $current_version ) { $this->out( "  Nothing To Do!" ); }
				else { $this->migrations->migrate( $this, $current_version, $version ); }
			}
			else {
				if( $version <= $current_version ) { $this->out( "  Nothing To Do!" ); }
				else { $this->migrations->migrate( $this, $current_version, $version ); }
			}
			$this->out();
			$this->out();
			$this->out( "===================================================================\n\n" );
			$this->_print_status();
			$this->out( "\n===================================================================\n\n" );
		}

		protected function _print_status () {
			$current_version = $this->migrations->get_schema_version();
			$last_version = $this->migrations->last_schema_version();
			$out = <<<EOF
    Current Migration: $current_version
     Latest Migration: $last_version

EOF;
			$this->out( $out );
		}

	}
