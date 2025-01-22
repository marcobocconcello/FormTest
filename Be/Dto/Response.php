<?php

    class Response {
        private int $statusCode;
        private array $textArray; //= array();

        public function getTexts() : array{
            return $this->textArray;
        }

        public function setTexts(array $texts){
            $this->textArray = $texts;
        }

        public function __construct(string $statusCode, array $data)
        {  
            $this->statusCode = $statusCode;
            $this->textArray = $data;
        }

        public function toJson(){
            return json_encode([
                "StatusCode" => $this->statusCode,
                "Items" => $this->textArray
            ]);
        }
    }

?>