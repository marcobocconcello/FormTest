<?php

    //singleton Class
    class FileManager{

        //devo renderla nullable con ? alrrimenti problemi.
        //non posso usare il construttore privato su un campo statico per inizalizzarlo
        private static ?FileManager $istance = null;

        private function __construct()
        {
            self::createDir();
            self::createLogFile();
        }

        public static function istance(){

            if(self::$istance === null){
                self::$istance = new FileManager();
            }
            return self::$istance;
        }

        private static function createDir(){
            $dirPathArray = explode('/' , FILE_NAME);
            $dirPathTmp = "";

            for($i = 0; $i < count($dirPathArray) - 1; $i++){
                $dirPathTmp = $dirPathTmp . $dirPathArray[$i] . '/';
            }

            $dirPath = substr($dirPathTmp,0,-1);
            if(!file_exists($dirPath )){
                mkdir($dirPath , 0777, true);
            }
        }

        private static function createLogFile(){
            if(!file_exists(FILE_NAME)){
                fopen(FILE_NAME,"w");
            }
        }
    }
?>