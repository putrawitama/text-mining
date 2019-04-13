<?php

class TfIdf {

    private $key;
    private $q;
    private $d;
    private $d2;
    private $text1;
    private $text2;
    private $text3;
    private $tfDf;
    private $hasil;
    private $hasil2;
    private $cosine;

    function __construct($text1, $text2, $text3)
    {
        $this->text1 = $text1;
        $this->text2 = $text2;
        $this->text3 = $text3;

        $this->toArray();
        $this->getKey();
        $this->getCount();
        $this->vsm();
    }

    public function getResult()
    {
        $data = [
            "tfIdf" => $this->tfDf,
            "cosine" => $this->cosine,
            "hasil" => $this->hasil,
            "hasil2" => $this->hasil2,
        ];

        return $data;
    }

    function toArray()
    {
        $this->q = explode(' ', $this->text1);
        $this->d = explode(' ', $this->text2);
        $this->d2 = explode(' ', $this->text3);
    }

    function getKey()
    {
        $temp_array = array_merge($this->q, $this->d, $this->d2);
        $this->key = array_unique($temp_array);
    }

    function getCount()
    {
        $totalQ = array_count_values($this->q);
        $totalD = array_count_values($this->d);
        $totalD2 = array_count_values($this->d2);
        $jumlahQ = count($this->q);
        $jumlahD = count($this->d);
        $jumlahD2 = count($this->d2);

        foreach ($this->key as $key => $value) {


            $q = in_array($value, $this->q) ? $totalQ[$value] : 0;
            $d = in_array($value, $this->d) ? $totalD[$value] : 0;
            $d2 = in_array($value, $this->d2) ? $totalD2[$value] : 0;
            $df = 1;
            if ($d > 0 && $q > 0) {
                $df++;
            }
            if ($d2 > 0 && $q > 0) {
                $df++;
            }
            $idf = log((2/$df), 10);
            $wQ = $q*$idf;
            $wD = $d*$idf;
            $wD2 = $d2*$idf;


            $this->tfDf[] = [
                'kata' => $value,
                'q' => $q,
                'd' => $d,
                'd2' => $d2,
                'df' => $df,
                'idf' => $idf,
                'wQ' => $wQ,
                'wD' => $wD,
                'wDD' => $wD2,
                'wQ2' => pow($wQ,2),
                'wD2' => pow($wD,2),
                'wDD2' => pow($wD2,2),
                'vsm1' => $wQ*$wD,
                'vsm2' => $wQ*$wD2,
            ];
        }
    }

    function vsm()
    {
        $jumlahDQ = 0;
        $jumlahD2Q = 0;
        $jumlahD = 0;
        $jumlahD2 = 0;
        $jumlahQ = 0;

        foreach ($this->tfDf as $key => $value) {
            $jumlahDQ += $value["vsm1"];
            $jumlahD2Q += $value["vsm2"];
            $jumlahD += $value["wD2"];
            $jumlahD2 += $value["wDD2"];
            $jumlahQ += $value["wQ2"];
        }

        $sqrtD = sqrt($jumlahD);
        $sqrtD2 = sqrt($jumlahD2);
        $sqrtQ = sqrt($jumlahQ);

        $this->cosine = [
            "jumlahDQ" => $jumlahDQ,
            "jumlahD2Q" => $jumlahD2Q,
            "jumlahD" => $jumlahD,
            "jumlahD2" => $jumlahD2,
            "jumlahQ" => $jumlahQ,
            "sqrtD" => $sqrtD,
            "sqrtD2" => $sqrtD2,
            "sqrtQ" => $sqrtQ,
        ];

        $hasil = $jumlahDQ / ($sqrtD * $sqrtQ);
        $hasil2 = $jumlahD2Q / ($sqrtD2 * $sqrtQ);

        $this->hasil = $hasil*100;
        $this->hasil2 = $hasil2*100;
    }

}