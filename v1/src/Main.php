<?php
    /**
     * Main API version 1.0
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */
    
    namespace Api;

    use Slim\App;
    use Api\Config\Constants;
    use Api\Config\Routes;

    /**
     * 
     */
    class Main implements Constants, Routes {

        /**
         * Creating Application
         */
        public function __construct () {

            // Set default Timezone
            date_default_timezone_set ( 'Asia/Jakarta' );
        }

        /**
         * Routing
         */
        private function _route ( $x = 0 ) {

            // Get controller
            $_SESSION['route'] = self::Routes[$x];

            // Make route group
            $this->app->group ( '/' . strtolower( $_SESSION['route'] ), function(){

                // Get Controller path
                $path = self::CONTROLLER_PATH . ucfirst ( $_SESSION['route'] ) . self::PHP;

                // Requiring controller
                if ( file_exists ( $path ) ) require_once ( $path );
            });

            // Make loop
            if ( $x < sizeof ( self::Routes ) - 1 ) $this->_route( $x + 1 );
        }

        /**
         * Run rest api
         */
        public function run () {

            // Call slim framework
            $this->app = new App();

            // check framework
            $this->app->map ( [ 'GET', 'POST' ], '/', function ( $request, $response, $args ) {

                return $response->withJSON([
                    "name"          => self::APP_NAME,
                    "version"       => self::APP_VERSION,
                    "description"   => self::APP_DESC
                ]);
            });

            // Routing
            $this->_route();

            // Cors setup
            $this->app->add ( function( $request, $response, $next ){

                $return = $next ( $request, $response );

                return $return
                    ->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )
                    ->withHeader ( 'Content-Type', 'application/json; charset=utf-8' );
            });

            // Running rest api
            $this->app->run();
        }
    }
?>