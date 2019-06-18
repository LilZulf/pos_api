<?php
    /**
     * Dummy Controller
     * @author Robet Atiq Maulana Rifqi
     * MEI 2019
     */

    use Api\Config\Constants;
    use Api\Helpers\Validation;
    use Api\Helpers\Encryption;
    use Api\Middlewares\Filter;
    use Api\Models\DummyModel;
    use Api\Systems\Request;
    use Api\Systems\Response;

    // Defining routes
    $this->get("/get", Dummy::class . ":get" );
    $this->post("/post", Dummy::class . ":post" );
    $this->get("/args/{id}", Dummy::class . ":args" );
    $this->get("/middleware", Dummy::class . ":middleware" )->add(new Filter());

    class Dummy implements Constants {

        /**
         * 
         */
        public function __construct () {

            // Initialize
            $this->validation = new Validation();
            $this->encryption = new Encryption();
            $this->validation = new Validation();
            $this->request = new Request();
            $this->response = new Response();
            $this->dummyModel = new DummyModel();
        }

        /**
         * Get function
         * 
         * @link {host}/dummy/get
         * @method GET
         * @return object
         */
        public function get ( $request, $response, $args ) {

            // Parsing request data
            $this->request->parse ( $request );

            // Simple validation
            $valid = $this->validation->filter(
                $this->request->get(),
                [
                    "name"  => "empty|symbol",
                    "wao" => "symbol"
                ]
            );

            // Validation
            if ( $valid->code != self::SUCCESS ) return $this->response->publish( null, $valid->message, $valid->code );

            // Return
            return $this->response->publish ( $this->request->get("wao"), "succes get", self::SUCCESS );
        }

        /**
         * Post function
         * 
         * @link {host}/dummy/post
         * @method POST
         * @return object
         */
        public function post ( $request, $response, $args ) {

            // Parsing request data
            $this->request->parse( $request );

            /**
             * Encrypting data
             */

            // Password
            $password = $this->encryption->password( $this->request->get("password") );
            
            // random pin
            $pin = $this->encryption->pin();

            // Encoding token
            $token = $this->encryption->tokenEncode( $this->request->get("id") );

            // Decoding token
            $decode = $this->encryption->tokenDecode( $token );

            // Set result
            $result = [
                "id"            => $this->request->get("id"),
                "password"      => $password,
                "pin"           => $pin,
                "tokenEncode"   => $token,
                "tokenDecode"   => $decode,
            ];

            // Return
            return $this->response->publish( $result, "Success post", self::SUCCESS );
        }

        /**
         * Args function
         * 
         * @link {host}/dummy/args/{id}
         * @method GET
         * @return object
         */
        public function args ( $request, $response, $args ) {

            // Get user data
            $user = $this->dummyModel->getUser([ ":id" => $args['id'] ]);

            // Check user avaible
            if ( isset ( $user->scalar )) return $this->response->publish(null, "user tidak ditemukan", self::NOT_FOUND );

            // Return
            return $this->response->publish( $user, "behasil ambil user data", self::SUCCESS );
        }

        /**
         * Middleware function
         * 
         * @link {host}/dummy/middleware
         * @method GET
         * @return object
         */
        public function middleware ( $request, $response, $args ) {

            // Get all user
            $users = $this->dummyModel->getAll();

            // Check user avaible
            if ( isset ( $users->scalar )) return $this->response->publish(null, "user tidak ditemukan", self::NOT_FOUND );

            // Return
            return $this->response->publish( ( array ) $users, "behasil ambil user data", self::SUCCESS );
        }
    }
?>