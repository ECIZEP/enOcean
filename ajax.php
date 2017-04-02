<?php

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? isset($_SERVER['HTTP_ORIGIN']) : '';
        $data = $_POST["type"];
        //header('Access-Control-Allow-Origin:'.$origin);
        //header('Access-Control-Allow-Methods:POST');
        // echo '{"origin": '.$origin.',"data": "'.$data.'"}';
        $i = 0;
        while ($i++ < 10) {
            echo $i."sdfd";
            flush();
            sleep(1);
        }
        
    }

?>