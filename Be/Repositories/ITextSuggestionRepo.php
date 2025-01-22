<?php

    interface ITextSuggestionRepo{
        public function mock_table(string $columnname) : bool;

        public function select_text(string $text, string $columnname) : array;

        /**
        *@template T
        */
        public function getDbCommand();
    } 

?>