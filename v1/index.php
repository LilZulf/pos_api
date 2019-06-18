<?php
    /**
     * Main Rest API
     * @author Robet Atiq Maulana RIFQI
     * MEI 2019
     */

    require_once ( './vendor/autoload.php' );
    require_once ( '../vendor/autoload.php' );

    use Api\Main;

    $api = new Main();
    $api->run();
?>