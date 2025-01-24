<?php
    require_once 'C:\xampp\htdocs\FormTest\Be\Dto\Response.php'; 
    /*
        * il controller base funge da super classe per il controller quindi contiene campi metodi comuni a tutti i controller
    */
    class BaseController{
        protected static function setResponse(string $statusCode, 
                                       array $data,
                                       array $header) : Response{
            
            if($statusCode <= 0 ){
                throw new Exception("Nessuno status code da settare in response");
            }

            if($header == null || $header == ""){
                throw new Exception("Nessun header impostato in response"); 
            }

            foreach($header as $headerValue){
                header($headerValue);
            }

            return new Response($statusCode, $data);
        }
    }

?>