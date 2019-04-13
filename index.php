<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Text Similarity</title>

    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-primary">
        <span class="navbar-brand mb-0 h1">Winnowing vs VSM</span>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h3>Perbandingan Teks (winnowing & VSM)</h3>
                <hr>

                <form action="main.php" method="get">
                
                    <div class="row">
                        <div class="col-6">
                            <h5>Teks</h5>
                            <hr>
                            <div class="form-group">
                                <label>Teks Uji</label>
                                <textarea name="teks1" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Teks Pembanding 1</label>
                                <textarea name="teks2" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Teks Pembanding 2</label>
                                <textarea name="teks3" class="form-control" rows="3" id="text3"></textarea>
                            </div>
                        </div>

                        <div class="col-6">
                            <h5>Pengaturan</h5>
                            <hr>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="pre[]" type="checkbox" value="stemming" checked="checked">
                                <label class="form-check-label" for="inlineCheckbox1">Stemming</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="pre[]" type="checkbox" value="whitespace" checked="checked">
                                <label class="form-check-label" for="inlineCheckbox2">Whitespace</label>
                            </div>

                            <div class="form-row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">K-Gram</label>
                                    <input type="number" name="k" class="form-control" placeholder="K-Gram" value="10">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Basis Bilangan Prima</label>
                                    <input type="number" name="prime" class="form-control" placeholder="Bilangan Prima" value="2">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress2">Window</label>
                                <input type="number" name="w" class="form-control" placeholder="Window" value="7">
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="algoritma" onclick="algo(this.value)" class="custom-control-input" value="winnowing">
                                <label class="custom-control-label" for="customRadio1">Winnowing</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="algoritma" onclick="algo(this.value)" class="custom-control-input" value="vsm">
                                <label class="custom-control-label" for="customRadio2">VSM</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Process</button>
                        </div>
                    </div>

                </form>
                
            </div>
        </div>
    </div>
    

    <script src="./asset/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function algo(val) {
            if (val == "vsm") {
                document.getElementById("text3").disabled = false;
            } else {
                document.getElementById("text3").disabled = true;
            }
        }
    </script>
</body>
</html>