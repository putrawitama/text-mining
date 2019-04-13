<?php

    require_once('PreProcessing.php');
    require_once('winnowing/Kgram.php');
    require_once('winnowing/Window.php');
    require_once('winnowing/Winnowing.php');
    require_once('winnowing/JaccardCoeficients.php');

    require_once('vsm/TfIdf.php');

    $stemming = isset($_GET["pre"]) ? (in_array("stemming", $_GET["pre"]) ? true : false) : false;
    $whitespaces = isset($_GET["pre"]) ? (in_array("whitespace", $_GET["pre"]) ? true : false) : false;
    $k = intval($_GET["k"]);
    $hashBasePrime = intval($_GET["prime"]);
    $w = intval($_GET["w"]);
    $algo = $_GET["algoritma"];

    //teksnya
    $teks1 = $_GET["teks1"];
    $teks2 = $_GET["teks2"];
    $teks3 = $_GET["teks3"];

    //================================================================================= PreProcessing

    $preprocess1 = new PreProcessing($teks1, $whitespaces, $stemming);
    $preprocess2 = new PreProcessing($teks2, $whitespaces, $stemming);

    $preprocessText1 = $preprocess1->getResult();
    $preprocessText2 = $preprocess2->getResult();

    if($algo == 'vsm') {
        $preprocess3 = new PreProcessing($teks3, $whitespaces, $stemming);

        $preprocessText3 = $preprocess3->getResult();
    }

    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;

    if ($algo == 'vsm') {

        $tfIdf = new TfIdf($preprocessText1, $preprocessText2, $preprocessText3);
        $hasil = $tfIdf->getResult();
        // echo '<pre>';
        // var_dump($hasil);

        $result = $hasil["hasil"];
        $result2 = $hasil["hasil2"];

        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);

    } else {
        

        //================================================================================= Kgram
        
        $kgram1 = new Kgram($k, $hashBasePrime, $preprocessText1);
        $kgram2 = new Kgram($k, $hashBasePrime, $preprocessText2);

        $kgramResult1  = $kgram1->getResult();
        $kgramResult2  = $kgram2->getResult();

        //================================================================================= Window

        $window1 = new Window($w, $kgramResult1);
        $window2 = new Window($w, $kgramResult2);

        $windowResult1 = $window1->getResult();
        $windowResult2 = $window2->getResult();


        //================================================================================= Winnowing

        $winnowing1 = new Winnowing($windowResult1);
        $winnowing2 = new Winnowing($windowResult2);

        $fingerprint1 = $winnowing1->getResult();
        $fingerprint2 = $winnowing2->getResult();

        //================================================================================= Similarity JaccardCoeficients
    
        $similarity = new JaccardCoeficients($fingerprint1, $fingerprint2);
        $result =  $similarity->getResult();

        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);

        // echo '<pre>';
        // var_dump($fingerprint1);
        // var_dump($arrayTeks);
        $windowTampil1 = [];
        $windowTampil2 = [];
        foreach ($windowResult1 as $key) {
            array_push($windowTampil1, join(", ", $key));
        }

        foreach ($windowResult2 as $key) {
            array_push($windowTampil2, join(", ", $key));
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil</title>

    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <span class="navbar-brand mb-0 h1">Winnowing vs VSM</span>
    </nav>

    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-body">
                <h3>Presentase Kemiripan pembanding: <?php echo  number_format($result,2) ?>% & selesai dalam waktu <?php echo $total_time ?> detik</h3>
                <?php if ($algo == "vsm") { ?>
                    <h3>Presentase Kemiripan pembanding 2: <?php echo  number_format($result2,2) ?>% & selesai dalam waktu <?php echo $total_time ?> detik</h3>
                <?php } ?>
                <hr>

                <div class="row mt-3 mb-3">
                    <div class="col-12">
                        <h5>PreProcessing</h5>

                        <div class="form-group">
                            <label>teks uji</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"><?php echo $preprocessText1?></textarea>
                        </div>
                        <div class="form-group">
                            <label>teks pembanding 1</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"><?php echo $preprocessText2?></textarea>
                        </div>
                        <?php if ($algo == "vsm") { ?>
                            <div class="form-group">
                                <label>teks pembanding 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"><?php echo $preprocessText3?></textarea>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($algo == "winnowing") { ?>

                    <div class="row mt-3 mb-3">
                        <div class="col-12">
                            <h5>K-Gram</h5>

                            <div class="form-group">
                                <label>teks 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">[<?php echo join("], [", $kgramResult1["string"])?>]</textarea>
                            </div>
                            <div class="form-group">
                                <label>teks 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">[<?php echo join("], [", $kgramResult2["string"])?>]</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Rolling Hash</h5>

                            <div class="form-group">
                                <label>teks 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">[<?php echo join("], [", $kgramResult1["hash"])?>]</textarea>
                            </div>
                            <div class="form-group">
                                <label>teks 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">[<?php echo join("], [", $kgramResult2["hash"])?>]</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Window</h5>

                            <div class="form-group">
                                <h6>teks 1</h6>
                                <hr>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8">
                                    <?php foreach($windowResult1 as $key => $value): ?>
                                        <?php echo $key+1 .".) [".join(", ", $value)."] \n"?>    
                                    <?php endforeach; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <h6>teks 2</h6>
                                <hr>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8">
                                    <?php foreach($windowResult2 as $key => $value): ?>
                                        <?php echo $key+1 .".) [".join(", ", $value)."] \n"?>    
                                    <?php endforeach; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Fingerprint</h5>

                            <div class="form-group">
                                <label>teks 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"><?php echo join(", ", $fingerprint1)?></textarea>
                            </div>
                            <div class="form-group">
                                <label>teks 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"><?php echo join(", ", $fingerprint2)?></textarea>
                            </div>
                        </div>
                    </div>
                
                <?php } else { ?>
                
                    <div class="row mt-3 mb3">
                        <div class="col-12">
                            <h5>TF-IDF</h5>
                            <hr>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Token</th>
                                        <th scope="col">Q</th>
                                        <th scope="col">D</th>
                                        <th scope="col">D2</th>
                                        <th scope="col">DF</th>
                                        <th scope="col">IDF log(d/df)</th>
                                        <th scope="col">W(Q)</th>
                                        <th scope="col">W(D1)</th>
                                        <th scope="col">W(D2)</th>
                                        <th scope="col">W(Q)*W(D1)</th>
                                        <th scope="col">W(Q)*W(D2)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($hasil["tfIdf"] as $key => $value): ?>
                                        <tr>
                                            <td><?php echo $value["kata"]; ?></td>
                                            <td><?php echo $value["q"]; ?></td>
                                            <td><?php echo $value["d"]; ?></td>
                                            <td><?php echo $value["d2"]; ?></td>
                                            <td><?php echo $value["df"]; ?></td>
                                            <td><?php echo $value["idf"]; ?></td>
                                            <td><?php echo $value["wQ"]; ?></td>
                                            <td><?php echo $value["wD"]; ?></td>
                                            <td><?php echo $value["wDD"]; ?></td>
                                            <td><?php echo $value["vsm1"]; ?></td>
                                            <td><?php echo $value["vsm2"]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3 mb3">
                        <div class="col-4">
                            <h5>Panjang Vector</h5>
                            <hr>

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Q</th>
                                        <th scope="col">D1</th>
                                        <th scope="col">D2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Jumlah</th>
                                        <td><?php echo $hasil["cosine"]["jumlahQ"]; ?></td>
                                        <td><?php echo $hasil["cosine"]["jumlahD"]; ?></td>
                                        <td><?php echo $hasil["cosine"]["jumlahD2"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">SQRT</th>
                                        <td><?php echo $hasil["cosine"]["sqrtQ"]; ?></td>
                                        <td><?php echo $hasil["cosine"]["sqrtD"]; ?></td>
                                        <td><?php echo $hasil["cosine"]["sqrtD2"]; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3 mb3">
                        <div class="col-12">
                            <h5>Cosine Similarity</h5>
                            <hr>

                            <dl class="row">
                                <dt class="col-sm-3 text-right">cosine(D1)</dt>
                                <dd class="col-sm-9">= sum Q(D1) / Sqrt(Q)*Sqrt(D1)</dd>

                                <dt class="col-sm-3"></dt>
                                <dd class="col-sm-9">
                                    <p>= <?php echo "(".$hasil["cosine"]["jumlahDQ"]." / (".$hasil["cosine"]["sqrtQ"]." x ".$hasil["cosine"]["sqrtD"].")) x 100%"?></p>
                                    <p>= <?php echo $hasil["hasil"]."%" ?></p>
                                </dd>
                            </dl>

                            <dl class="row">
                                <dt class="col-sm-3 text-right">cosine(D2)</dt>
                                <dd class="col-sm-9">= sum Q(D2) / Sqrt(Q)*Sqrt(D2)</dd>

                                <dt class="col-sm-3"></dt>
                                <dd class="col-sm-9">
                                    <p>= <?php echo "(".$hasil["cosine"]["jumlahDQ"]." / (".$hasil["cosine"]["sqrtQ"]." x ".$hasil["cosine"]["sqrtD2"].")) x 100%"?></p>
                                    <p>= <?php echo $hasil["hasil2"]."%" ?></p>
                                </dd>
                            </dl>
                        </div>
                    </div>

                <?php } ?>
                
            </div>
        </div>
    </div>

    <script src="./asset/js/bootstrap.min.js"></script>
</body>
</html>