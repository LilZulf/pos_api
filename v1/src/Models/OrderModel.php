<?php
    /**
     * Add Order Model
     * @author Ahmad Zulfan Najib
     * MEI 2019
     */

    namespace Api\Models;

    use Api\Systems\Connection;

    class OrderModel {

        public function __construct() {

            // Initialize
            $this->db = new Connection();
        }

        /**
         * Function Get Comodity
         * 
         * @param array
         * @return object
         */
        public function getComodity () {

            // Querying sql
            $this->db->query( "SELECT * FROM `pmr_t_post_commodities`");

            // Return
            return $this->db->fetchAll();
        
        }
        

        /**
         * Get search Commodity
         * 
         * @param array
         * @return object
         */
        public function searchComo ( $params ) {

            // Querying sql
            $this->db->query( "SELECT * FROM `pmr_t_post_commodities` WHERE `name` LIKE :name ", $params );
           
            // Return
            return $this->db->fetchAll();
        }
      
    }
?>