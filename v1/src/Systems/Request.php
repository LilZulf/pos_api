<?php
    /**
     * Request systems
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Systems;

    class Request {

        /**
         * 
         */
        public function __construct () {

            $this->params = ( object ) [];

            $this->auth = "";
        }

        /**
         * parsing request data
         * 
         * @param object
         */
        public function parse ( $request ) {

            // Parsing request data
            if ( $request->isPost() ) $this->params = ( object ) $request->getParsedBody();
            else $this->params = ( object ) $request->getQueryParams();

            // parsing authorization
            if ( isset ( $request->getHeader( 'HTTP_AUTHORIZATION' ) [0] )) $this->auth = $request->getHeader( 'HTTP_AUTHORIZATION')[0];
        }

        /**
         * Getting params
         * 
         * @param string|null
         * @return string
         */
        public function get ( $key = null ) {

            if ( is_null ( $key ) ) return $this->params;
            else if ( isset ( $this->params->$key )) return $this->params->$key;
            else return "";
        }

        /**
         * Get Authorization
         */
        public function getAuth () {

            return $this->auth;
        }

        /**
         * Set params
         * 
         * @param string
         * @param string|int|bool
         */
        public function set ( $key, $value ) {

            $this->params->$key = $value;
        }

        /**
         * Unsetting params
         * 
         * @param string
         */
        public function unset ( $key ) {

            unset ( $this->params->$key );
        }
    }
?>