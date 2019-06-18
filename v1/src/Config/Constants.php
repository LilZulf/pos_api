<?php
    /**
     * Constant values
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Config;

    interface Constants {

        /**
         * App description
         */
        const APP_NAME = "Rest Api Skeleton v1.0";
        const APP_VERSION = "1";
        const APP_DESC = "Authentication is needed to access api.";

        /**
         * Path configuration
         */
        const CONTROLLER_PATH = "src/Controllers/";
        const PHP = ".php";

        /**
         * Database configuration
         */
        const DB = [
            "host"  => "localhost",
            "user"  => "root",
            "pass"  => "",
            "db"    => "training"
        ];

        /**
         * Status code
         */
        const SUCCESS = 200;
        const FORBIDEN = 403;
        const NOT_FOUND = 404;
        const ERROR = 500;

        /**
         * Encryption configuration
         */
        const ENC_KEY = "staywithme11may";
        const DEF_MAX_PIN = 6;
    }
?>