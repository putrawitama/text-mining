<?php

class JaccardCoeficients{

    private $fingerprint1;
    private $fingerprint2;

    private $intersection;
    private $union;
    private $similarity;

    function __construct($fingerprint1, $fingerprint2){

        $this->fingerprint1 = array_unique($fingerprint1);
        $this->fingerprint2 = array_unique($fingerprint2);

        $this->calculateIntersection();
        $this->calculateUnion();
        $this->calculateSimilarity();

    }

    public function getResult(){

        return $this->similarity;

    }

    function calculateIntersection(){

        $this->intersection = array_intersect($this->fingerprint1, $this->fingerprint2);
        
    }

    function calculateUnion(){

        $this->union = array_merge(array_diff($this->fingerprint1, $this->fingerprint2), $this->intersection);

    }

    function calculateSimilarity(){

        $this->similarity = (count($this->intersection) / count($this->union)) * 100;

    }

}