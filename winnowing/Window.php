<?php

class Window{

    private $windowLength;
    private $kgrams;
    private $finalWindow;

    function __construct($w, $kgrams){

        $this->windowLength = $w;
        $this->kgrams = $kgrams["hash"];
        $this->finalWindow = [];

        $this->createWindow();

    }

    public function getResult(){

        return $this->finalWindow;

    }

    function createWindow(){
        
        $kgramLength = count($this->kgrams);
        $limit = $kgramLength - ($this->windowLength - 1);
        $start = 0;
        $end = $this->windowLength;

        while($end < $limit){

            $windowArray = [];

            for($i = $start; $i < $end; $i++){
                array_push($windowArray, $this->kgrams[$i]);
            }

            array_push($this->finalWindow, $windowArray);

            $start++;
            $end++;

        }

    }

}