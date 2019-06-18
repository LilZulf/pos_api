<?php
    /**
     * Validation Helper
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    namespace Api\Helpers;

    use Api\Config\Constants;

    class Validation implements Constants {

        /**
         * Filtering data
         * 
         * @param array
         * @param array
         * 
         * @return object
         */
        public function filter ( $params, $exp, $x = 0 ) {

            // Getting all exp keys
            $allKeys = array_keys ( $exp );

            // Getting key
            $key = $allKeys[$x];

            // Exploding states
            $states = explode ( "|", $exp[$key] );

            // Validating empty data
            if ( in_array ( "empty", $states )) {

                if ( $params->$key == "" ) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " cannot be empty" ];
                }
            }

            // Validating email
            if ( in_array ( "email", $states )) {

                if ( ! filter_var ( $params->$key, FILTER_VALIDATE_EMAIL )) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "Email is invalid" ];
                }
            }

            // Validating symbol
            if ( in_array ( "symbol", $states )) {

                if ( preg_match ( '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $params->$key ) ) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " cannot contain illegal symbols" ];
                }
            }

            // Validating number
            if ( in_array ( "number", $states )) {

                if ( ! is_numeric ( $params->$key )) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " must be number" ];
                }
            }

            // Validating spaces
            if ( in_array ( "space", $states )) {

                if ( strrpos ( $params->$key, " ") !== false ) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " cannot contain space" ];
                }
            }

            // Matching data
            $matcher = preg_grep ( '/match:(\w+)/i', $states );

            if ( sizeof ( $matcher ) > 0 ) {

                // Getting matching key
                $keys = array_keys ( $matcher );
                $keys = $keys[0];

                // Getting match data
                $match = str_replace ( "match:", "", $matcher[$keys] );

                if ( $params->$keys != $params->$match ) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "Your " . $key . " didn'tmatch" ];
                }
            }

            // Validating enum data
            $enumer = preg_grep ( '/enum:(\w+)/i', $states );

            if ( sizeof ( $enumer ) > 0 ) {

                // Getting enum key
                $keys = array_keys ( $enumer );
                $keys = $keys[0];

                // Getting enum data
                $enum = str_replace ( "enum:", "", $enumer[$keys] );
                $enum = explode ( ",", $enum );

                if ( ! in_array ( $params->$key, $enum )) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "Your " . $key . " is invalid" ];
                }
            }

            // Validating min char
            $miner = preg_grep ( '/min:(\w+)/i', $states );

            if ( sizeof ( $miner ) > 0 ) {

                // Getting min key
                $keys = array_keys ( $miner );
                $keys = $keys[0];

                // Getting min data
                $min = str_replace ( "min:", "", $miner[$keys] );

                if ( strlen ( $params->$key ) < intval ( $min )) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " length must be " . $min . " characters or more" ];
                }
            }

            // Validating max char
            $maxer = preg_grep ( '/max(\w+)/i', $states );

            if ( sizeof ( $maxer ) > 0 ) {

                // Getting max key
                $keys = array_keys ( $maxer );
                $keys = $keys[0];

                // Getting max data
                $max = str_replace ( "max:", "", $maxer[$keys] );

                if ( strlen ( $params->$key ) > intval ( $max )) {

                    // Return
                    return ( object ) [ "code" => self::ERROR, "message" => "coloumn " . $key . " length must be " . $max . " characters or less" ];
                }
            }

            // Make loop
            if ( $x < sizeof ( $exp ) - 1 ) return $this->filter( $params, $exp, $x + 1 );

            // Return
            return ( object ) [ "code" => self::SUCCESS ];
        }

    }
?>