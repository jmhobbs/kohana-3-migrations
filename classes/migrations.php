<?php

	class Migrations {

		protected $config;
		protected $group;

		public function __construct( $group = 'default' ) {
			$this->config = Kohana::config( 'migrations' );
			$this->group  = $group;
			$this->config['path'] = $this->config['path'][$group];
			$this->config['info'] = $this->config['path'] . $this->config['info'] . '/';
		}

		public function get_schema_version () {
			if( ! is_dir( $this->config['path'] ) )
				mkdir( $this->config['path'] );

			if ( ! is_dir( $this->config['info'] ) )
				mkdir( $this->config['info'] );

			if ( ! file_exists( $this->config['info'] . 'version' ) ) {
				$fversion = fopen( $this->config['info'] . 'version', 'w' );
				fwrite( $fversion, '0' );
				fclose( $fversion );
				return 0;
			}
			else {
				$fversion = fopen( $this->config['info'] . 'version','r' );
				$version = fread( $fversion, 11 );
				fclose( $fversion );
				return $version;
			}
			return 0;
		}

		public function set_schema_version ( $version ) {
			$fversion = fopen( $this->config['info'] . 'version', 'w' );
			fwrite( $fversion, $version );
			fclose( $fversion );
		}

		public function last_schema_version () {
			$migrations = $this->get_up_migrations();
			end( $migrations );
			return key( $migrations );
		}

		public function get_up_migrations () {
			$migrations = glob( $this->config['path'] . '*UP.sql' );
			$actual_migrations = array();
			foreach ( $migrations as $i => $file ) {
				$name = basename( $file, '.sql' );
				$matches = array();
				if ( preg_match( '/^(\d{3})_(\w+)$/', $name, $matches ) )
					$actual_migrations[intval( $matches[1] )] = $file;
			}
			return $actual_migrations;
		}

		public function get_down_migrations () {
			$migrations = glob( $this->config['path'] . '*DOWN.sql' );
			$actual_migrations = array();
			foreach ( $migrations as $i => $file ) {
				$name = basename( $file, '.sql' );
				$matches = array();
				if ( preg_match( '/^(\d{3})_(\w+)$/', $name, $matches ) )
					$actual_migrations[intval( $matches[1] )] = $file;
			}

			return $actual_migrations;
		}

		public function migrate ( &$controller, $from, $to ) {
			if( $from < $to ) {
				$migrations = $this->get_up_migrations();
				foreach( $migrations as $index => $migration )
					if( $index > $from and $index <= $to ) {
						try {
							$controller->out( $this->run_migration( $migration ) );
							$this->set_schema_version( $index );
						}
						catch( Exception $e ) {
							$controller->out( "Error running migration $index UP: " . $e->getMessage() . "\n" );
							break;
						}
					}
			}
			else {
				$migrations = $this->get_down_migrations();
				$item = end( $migrations );
				while( false !== $item ) {
					$index = key( $migrations );
					if( $index <= $from and $index > $to ) {
						try {
							$controller->out( $this->run_migration( $item ) );
							$this->set_schema_version( $index - 1 );
						}
						catch( Exception $e ) {
							$controller->out( "Error running migration $index DOWN: " . $e->getMessage() . "\n" );
							break;
						}
					}
					$item = prev( $migrations );
				}
			}
		} // migrate

		public function run_migration ( $file ) {

			$contents = file_get_contents( $file );
			$queries = explode( ';', $contents );

			$db = Database::instance( $this->group );

			foreach( $queries as $query ) {
				$query = trim( $query );
				if( empty( $query ) ) { continue; }
				$db->query( Database::UPDATE, $query, false );
			}

			return "Migrated: " . basename( $file ) . "\n";
		}

	}
