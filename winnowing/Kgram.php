<?php

class Kgram {

    private $k;
    private $text;
    private $hashBasePrime;
    private $kgram;
    private $hashedKgrams;

    function __construct($k, $hashBasePrime, $text)
    {
        $this->k = $k;
        $this->text = $text;
        $this->hashBasePrime = $hashBasePrime;

        $this->kgrams = [];
        $this->hashedKgrams = [];
        
        $this->createKgram();
        $this->createHash();
    }

    public function getResult()
    {
        $data = [
            'string' => $this->kgrams,
            'hash' => $this->hashedKgrams
        ];

        return $data;
    }

    function createKgram()
    {
        $text_length = strlen($this->text);
        $limit = $text_length - ($this->k - 1);
        $start = 0;
        $end = $this->k; // excluded
    
        while($start < $limit){

            array_push($this->kgrams, substr($this->text, $start, $this->k));

            $start++;
            $end++;
    
        }
    }

    function createHash()
    {
        $i = 0;

        foreach ($this->kgrams as $i => $kgram) {
            if($i > 0){
                array_push($this->hashedKgrams, $this->secondRollingHashFormula($kgram, $i));
            }else{
                array_push($this->hashedKgrams, $this->firstRollingHashFormula($kgram));
            }
        }
    }

    function firstRollingHashFormula($kgram)
    {
        $string = str_split($kgram);
        $total = count($string);
        $power =  $total - 1;
        $hash = 0;

        for($i = 0; $i < $total; $i++){

            $hash += ord($string[$i]) * pow($this->hashBasePrime, $power);
            $power--;

        }

        return $hash;
    }

    function secondRollingHashFormula($kgram, $i)
    {
        $prevHashedKgram = $this->hashedKgrams[$i - 1];
        $firstCharCodeOfPrevKgram = ord($this->kgrams[$i - 1]);
        $string = str_split($kgram);
        $lastCharCodeOfCurrentKgram = ord($string[count($string) - 1]);

        $hash = ($prevHashedKgram - ($firstCharCodeOfPrevKgram * pow($this->hashBasePrime, strlen($kgram) - 1))) * $this->hashBasePrime + $lastCharCodeOfCurrentKgram;

        return $hash;
    }


}