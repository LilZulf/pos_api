<?php
    /**
     * Filtering authorization middleware
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Middlewares;

    use Api\Helpers\Encryption;
    use Api\Config\Constants;
    use Api\Systems\Request;

    class Filter implements Constants {

        public function __construct () {

            // Intializing request system
            $this->request = new Request();

            // Initializing encryption helper
            $this->encryption = new Encryption();
        }

        /**
         * Invoking authorization
         */
        public function __invoke ( $request, $response, $next ) {

            // Parsing request data
            $this->request->parse ( $request );

            // Get auth
            $auth = $this->request->getAuth();

            // Check auth
            if ( $auth == "" ) {

                // Return
                return $response->withJSON([
                    "status"    => false,
                    "message"   => "Illegal Access",
                    "code"      => self::FORBIDEN
                ]);
            }

            // Exploding token
            $token = explode ( ":", $auth );

            // Check token
            if ( $token[1] != $this->encryption->tokenEncode( $token[0] ) ) {

                // Return
                return $response->withJSON([
                    "status"    => false,
                    "message"   => "Token missmatch!",
                    "code"      => self::FORBIDEN
                ]);
            }

            // Return
            return $next ( $request, $response );
        }
    }
?>