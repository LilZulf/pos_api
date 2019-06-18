<?php
    /**
     * Dummy Model
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Models;

    use Api\Systems\Connection;

    class DummyModel {

        public function __construct() {

            // Initialize
            $this->db = new Connection();
        }

        /**
         * Get single user
         * 
         * @param array
         * @return object
         */
        public function getUser ( $params ) {

            // Querying sql
            $this->db->query( "SELECT * FROM `user` WHERE `id` = :id", $params );

            // Return
            return $this->db->fetch();
        }

        /**
         * Get mltiple user
         * 
         * @return object
         */
        public function getAll () {

            // Querying sql
            $this->db->query( "SELECT * FROM `user`" );

            // Return
            return $this->db->fetchAll();
        }
    }
?>