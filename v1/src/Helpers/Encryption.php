<?php
    /**
     * Encryption helper
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Helpers;

    use Api\Config\Constants;

    class Encryption implements Constants {

        /**
         * Encrypting password
         * 
         * @param string
         * @param string
         * 
         * @return object
         */
        public function password ( $password ) {
            $secure = sha1(self::ENC_KEY."don't leave me behind");
            return md5($secure . self::ENC_KEY . $password . self::ENC_KEY . $secure);
        }

        /**
         * Encoding token
         * 
         * @param int
         * @return string
         */
        public function tokenEncode ( $id ) {

            // Delimiter
            $delimiter = md5 ( base64_encode ( self::ENC_KEY ) );

            // Assembler
            $assembler = base64_encode ( strval ( $id ) ) . $delimiter . crc32 ( date ( "Y/m/d" ) );

            // Return
            return base64_encode ( $assembler );
        }

        /**
         * Decoding token
         * 
         * @param string
         * @return int
         */
        public function tokenDecode ( $token ) {

            // Delimiter
            $delimiter = md5 ( base64_encode ( self::ENC_KEY ) );

            // Decoding token
            $decoded = base64_decode ( $token );

            // Exploding token
            $exploded = explode ( $delimiter, $decoded );

            // Return
            return intval ( base64_decode ( $exploded[0] ) );
        }

        /**
         * Generating pin
         * 
         * @param int
         * @return string
         */
        public function pin ( $size = self::DEF_MAX_PIN ) {

            return str_pad ( rand ( 0, pow ( 10, $size ) - 1), $size, '0', STR_PAD_LEFT );
        }
    }
?>