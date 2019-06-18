<?php
    /**
     * Dummy Model
     * @author Ahmad Zulfan Najib
     * MEI 2019
     */

    namespace Api\Models;

    use Api\Systems\Connection;

    class LoginModel {

        public function __construct() {

            // Initialize
            $this->db = new Connection();
        }

        /**
         * Function Login
         * 
         * @param array
         * @return object
         */
        public function getUser ( $params ) {

            // Querying sql
            $this->db->query( "SELECT * FROM `user` WHERE  name = :user && `password` = :password" , $params );

            // Return
            return $this->db->fetch();
        }
        
        /**
         * Function Email checker
         * 
         * @param array
         * @return object
         */
        public function checker ($params){

            //sql
            $this->db->query("SELECT COUNT(*) AS `total` FROM `user` WHERE `email` = :email",$params);
            
            // Return
            return $this->db->fetch();
        }

        /**
         * Function Insert
         * 
         * @param array
         * 
         */        
        public function addUser($params){
            //sql insert
            $this->db->query("INSERT INTO `user` ( `name`, `email`, `password`) VALUES (:name,:email,:password)",$params);
        }

      
    }
?>