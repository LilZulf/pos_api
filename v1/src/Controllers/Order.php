<?php
    /**
     * Add Order Controller
     * @author Ahmad Zulfan Najib
     * Juni 2019
     */

    use Api\Config\Constants;
    use Api\Systems\Request;
    use Api\Systems\Response;
    use Api\Models\OrderModel;
    use Api\Helpers\Validation;

    // Defining routes
    $this->get("/getcomo", Order::class . ":getcomo" );
    $this->post("/searchcomo", Order::class . ":searchcomo");

    class Order implements Constants {

        /**
         * 
         */
        public function __construct () {
            // Initialize
            $this->validation = new Validation();
            $this->request = new Request();
            $this->response = new Response();
            $this->orderModel = new OrderModel();
        }

        /**
         * get Commodity function
         * 
         * @link {host}/order/getcomo
         * @method GET
         * @return object
         */
        public function getcomo ( $request, $response, $args ) {

            // Get all user
            $como = $this->orderModel->getComodity();

            // Return
            return $this->response->publish( ( array ) $como, "behasil ambil commodity", self::SUCCESS );
        }

        /**
         * Search Commodity function
         * 
         * @link {host}/order/searchcomo
         * @method GET
         * @return object
         */
        public function searchcomo ( $request, $response, $args ) {

            //parsing request data
            $this->request->parse( $request );
            
             //validating name
            $valid = $this->validation->filter(
                $this->request->get(),
                [
                    "name"  => "symbol"            
                ]
            );
            if ( $valid->code != self::SUCCESS ) return $this->response->publish( null, $valid->message, $valid->code );

            //var for like in model
            $name = "%".$this->request->get("name")."%";

            //send params to model 
            $result = $this->orderModel->searchComo([ 
                ":name" =>  $name,
            ]);
            
            // Return
            return $this->response->publish( ( array ) $result, "data ditampilkan", self::SUCCESS );
        }

       
    }
?>