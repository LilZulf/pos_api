<?php
    /**
     * Connection system
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Systems;

    use \PDO;
    use Api\Config\Constants;

    /**
     * 
     */
    class Connection implements Constants {

        /**
         * Create connection
         */
        public function __construct () {

            // Create connection
            $this->_connect();
        }

        /**
         * Connecting database
         */
        private function _connect () {

            // Get database configuration
            $db = ( object ) self::DB;

            // Create connection
            $pdo = new PDO ( "mysql:host=" . $db->host . ";dbname=" . $db->db, $db->user, $db->pass );

            // Set attribute
            $pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $pdo->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );

            // make global pdo
            $this->pdo = $pdo;
        }

        /**
         * Parsing data
         * 
         * @param object
         * @param array
         * @param int
         */
        private function _parse ( $object, $data, $x = 0 ) {

            // invoking data
            $data[$x] = $object ( $data[$x] );

            // make loop
            if ( $x < sizeof ( $data ) - 1 ) return $this->_parse ( $object, $data, $x + 1 );

            // return
            return $data;
        }

        /**
         * Setting query
         * 
         * @param string
         * @param array
         */
        public function query ( $query = "", $params = [] ) {

            // Check connection
            if ( is_null( $this->pdo ) ) $this->_connect();

            // Preparing statement
            $stmt = $this->pdo->prepare ( $query );

            // Executing statement
            $stmt->execute ( $params );

            // Saving statement
            $this->stmt = $stmt;
        }

        /**
         * Fetching single data
         * 
         * @param object|null
         */
        public function fetch ( $object = null ) {

            // Getting data
            $data = $this->stmt->fetch();

            // Closing connection
            $this->_close();

            // Check object exists
            if ( ! is_null ( $object ) ) $data = $object ( $data );

            // Return
            return ( object ) $data;
        }

        /**
         * Fetch multiple data
         * 
         * @param object|null
         */
        public function fetchAll ( $object = null ) {

            // Getting data
            $data = $this->stmt->fetchAll();

            // Closing connection
            $this->_close();

            // parsing data
            if ( ! is_null ( $object ) && sizeof ( $data ) > 0 ) $data = $this->_parse ( $object, $data );

            // Return
            return ( object ) $data;
        }

        /**
         * Closing connection
         */
        private function _close () {

            // deleting connection
            $this->stmt = null;
            $this->pdo = null;
        }
    }
?>