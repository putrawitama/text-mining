<?php

class Winnowing{

    private $windows;
    private $fingerprints;

    function __construct($windows){

        $this->windows = $windows;
        $this->fingerprints = [];
        $this->findFingerprints();

    }

    public function getResult(){

        return $this->fingerprints;

    }

    function findFingerprints(){

        foreach ($this->windows as $i => $window) {
            $minHash = min($window);

            if (!array_search($minHash, $this->fingerprints)) {
                array_push($this->fingerprints, $minHash);
            }
        }
    }
}