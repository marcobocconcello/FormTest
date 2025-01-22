<?php
/*
incapsulamento rendendo i campi privati, modificabili solo mediante getter e setter
costruttore full parametrico.
*/
    class Suggested{
        private int $id;
        private string $possibleValue;
        
        public function __construct(int $id, string $possibleValue)
        {
            $this->id = $id;
            $this->possibleValue = $possibleValue;            
        }
        public function get_id() : int{
            return $this -> id;
        }
        public function get_possibileValue(): string{
            return $this -> possibleValue;
        }
        public function set_id(int $id) {
            $this -> id = $id;
        }
        public function set_possilbeValue(string $possibleValue) {
            $this -> possibleValue = $possibleValue;
        }

    }
?>