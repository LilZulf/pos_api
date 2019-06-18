<?php
    /**
     * Response systems
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Systems;

    use Api\Config\Constants;

    class Response implements Constants {

        /**
         * Set private attribute
         */
        private $data = [];

        /**
         * Sending response data
         * 
         * @param array|null
         * @param string
         * @param int
         * 
         * @return string
         */
        public function publish ( $data = null, $message = "", $code = self::ERROR ) {

            $result['status'] = $code != self::ERROR;
            $result['data'] = $data;
            $result['message'] = $message;
            $result['code'] = $code;

            return json_encode ( $result );
        }
    }

?>