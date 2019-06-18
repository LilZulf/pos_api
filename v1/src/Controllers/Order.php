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

    // Defining routes
    $this->get("/getcomo", Order::class . ":getcomo" );

    class Order implements Constants {

        /**
         * 
         */
        public function __construct () {
            // Initialize
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

       
    }
?>