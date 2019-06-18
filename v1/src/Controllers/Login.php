<?php
    /**
     * Dummy Controller
     * @author Ahmad Zulfan Najib
     * MEI 2019
     */

    use Api\Config\Constants;
    use Api\Helpers\Validation;
    use Api\Helpers\Encryption;
    use Api\Models\LoginModel;
    use Api\Systems\Request;
    use Api\Systems\Response;

    // Defining routes
   
    $this->post("/login", Login::class . ":login" );
    $this->post("/register", Login::class . ":register");
    
    class Login implements Constants {

        /**
         * 
         */
        public function __construct () {

            // Initialize
            $this->validation = new Validation();
            $this->encryption = new Encryption();
            $this->request = new Request();
            $this->response = new Response();
            $this->loginModel = new LoginModel();
        }

        /**
         * Login
         * 
         * @link {host}/login/login
         * @method POST
         * @return object
         */
        public function login ( $request, $response, $args ) {
            
            //parsing request data
            $this->request->parse( $request );

            //validating user
            $valid = $this->validation->filter(
                $this->request->get(),
                [
                    "user"  => "empty|symbol",
                    "pass"  => "empty|min:8"
                    
                ]
            );
            if ( $valid->code != self::SUCCESS ) return $this->response->publish( null, $valid->message, $valid->code );
            
            //encrypt password
            $password = $this->encryption->password( $this->request->get("pass") );
            
            //send parameter
            $user = $this->loginModel->getUser([ 
                ":user" =>  $this->request->get("user"),
                ":password" => $password
            ]);
            if ( isset ( $user->scalar )) return $this->response->publish(null, "user tidak ditemukan", self::NOT_FOUND );
            
            //response
            return $this->response->publish( $user, "Success login", self::SUCCESS );
        }

         /**
         * Register
         * 
         * @link {host}/login/register
         * @method POST
         * @return object
         */
        public function register ($request , $response , $args){

            //parsing request data
            $this->request->parse( $request );

            //validating user
            $valid = $this->validation->filter(
                $this->request->get(),
                [
                    "name"  => "empty|symbol",
                    "password"  => "empty|min:8",
                    
                ]
            );
            if ( $valid->code != self::SUCCESS ) return $this->response->publish( null, $valid->message, $valid->code );
         
            //Email Check
            $email = $this->loginModel->checker([
                ":email" => $this->request->get("email")
            ]);
            if($email->total != 0) return $this->response->publish( null, "Email Sudah Digunakan", self::FORBIDEN );
            
            //encrypt password
            $password = $this->encryption->password( $this->request->get("password") );
            
            //insert data
            $register = [
                ":name" => $this->request->get("name"),
                ":email" => $this->request->get("email"),
                ":password" => $password
            ];
            $this->loginModel->addUser($register);
            return $this->response->publish( $register, "Done", self::FORBIDEN );
           
        }
       
    }
?>