<?php
    session_start();
    require_once 'scripts/config.php';
?>

<html lang="en" id="head">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="css/common_styles.css">
        <link rel="stylesheet" href="css/index_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>

        <main>
            <div class="container p-4">
                <div class="row">
                    <div class="pic-ctn col-12">
                        <!--Premier carroussel (presentation)-->
                        <img src="images/pres/pres-pic1.jpg" alt="" class="pic">
                        <img src="images/pres/pres-pic2.jpg" alt="" class="pic">
                        <img src="images/pres/pres-pic3.jpg" alt="" class="pic">
                        <img src="images/pres/pres-pic4.jpg" alt="" class="pic">
                    </div>
                </div>

                <hr class="separateur">
                <h1 class="titre1">Highlights</h1>
                <div class="carrousel row">
                    <div class="populaires col-5">
                        <!--deuxieme carrousel (avec guitares)-->
                        <div id="myCarousel1" class="carousel slide border" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active" style="text-align: center !important;">
                                    <a href="article.php?product=Gibson-SG"><img src="images/Gibson-SG/Gibson-SG1.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Gibson SG</p>
                                    </div>
                                </div>
                                <div class="carousel-item" style="text-align: center !important;">
                                    <a href="article.php?product=LTD-EII-Eclipse"><img src="images/LTD-EII-Eclipse/LTD-EII-Eclipse1.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>LTD EII Eclipse</p>
                                    </div>
                                </div>
                                <div class="carousel-item" style="text-align: center !important;">
                                    <a href="article.php?product=Harley-Benton-D120"><img src="images/Harley-Benton-D120/Harley-Benton-D1201.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Harley Benton D120</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="carousel-control-prev" href="#myCarousel1" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel1" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
                    </div>
                    <div class="populaires col-5">
                    <!--troisieme carrousel (avec guitares)-->
                        <div id="myCarousel2" class="carousel slide border" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active" style="text-align: center !important;">
                                    <a href="article.php?product=Sterling-Cutlass-TE"><img src="images/Sterling-Cutlass-TE/Sterling-Cutlass-TE1.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Sterling Cutlass TE</p>
                                    </div>
                                </div>
                                <div class="carousel-item" style="text-align: center !important;">
                                    <a href="article.php?product=Larry-Carlton-T7"><img src="images/Larry-Carlton-T7/Larry-Carlton-T71.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Larry Carlton T7</p>
                                    </div>
                                </div>
                                <div class="carousel-item" style="text-align: center !important;">
                                    <a href="article.php?product=Squier-ST"><img src="images/Squier-ST/Squier-ST1.jpg" alt=""></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>Squier ST 40th Anniversary</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="carousel-control-prev" href="#myCarousel2" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel2" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
                    </div>
                </div>
                <hr class="separateur">
                <h1 class="titre1">Our favorite</h1>
                <div class="row">
                    <div class="col-5">
                        <!--partie "notre favorite"-->
                        <a href="article.php?product=Gretsch-12-FalconRanger"><img src="images/Gretsch-12-FalconRanger/Gretsch-12-FalconRanger1.jpg" alt="" class="img-fluid pb-3" /></a>
                        <div class="text-deals">
                            <h4>Gretsch 12 FalconRanger</h4>
                            $609
                        </div>
                    </div>
                    <div class="col-7">
                        <p class="text">
                            Gretsch Ranger acoustics are back and better than ever!
                        </p>
                        <p class="text">
                            The G5022CWFE-12 Rancher Falcon Jumbo 12-String gives you lavishly full 12-string tone, 
                            sparkling gilded appointments and onboard electronics for peerless amplified tone. 
                        </p>
                        <p class="text">
                            Its jumbo cutaway body is finished in gloss white, with dazzling gold-sparkle binding on the top, back, sound hole, fingerboard and headstock.
                        </p>
                    </div>
                </div>
                <div>
                </div>
                <hr class="separateur">
                <!--partie bonnes affaires -> bootstrap 4 blocs avec une guitare en promo chacun-->
                <h1 class="titre1">Good Deals</h1>
                <div class="container p-4">
                    <div>
                        <div class="row" style="align-items: center;">
                            <div class="row">
                                <div class="col-6">
                                    <a href="article.php?product=ESP-SnakeByte"><img src="images/ESP-SnakeByte/ESP-SnakeByte1.jpg" class=" img-fluid pb-3"></a>
                                    <div class="text-deals">
                                        <h4>ESP Snakebyte</h4>
                                        <span class="striked">$1799</span> <span class="promo">$1499</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="article.php?product=Fender-Troy-Jazzmaster"><img src="images/Fender-Troy-Jazzmaster/Fender-Troy-Jazzmaster1.jpg" class=" img-fluid pb-3"></a>
                                    <div class="text-deals">
                                        <h4>Fender Troy Jazzmaster</h4>
                                        <span class="striked">$1499</span> <span class="promo">$1499</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="article.php?product=Dangelico-Premier"><img src="images/Dangelico-Premier/Dangelico-Premier1.jpg" class=" img-fluid pb-3"></a>
                                    <div class="text-deals">
                                        <h4>D'Angelico Premier</h4>
                                        <span class="striked">$1099</span> <span class="promo">$899</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="article.php?product=Fender-Vintera"><img src="images/Fender-Vintera/Fender-Vintera1.jpg" class=" img-fluid pb-3"></a>
                                    <div class="text-deals">
                                        <h4>Fender Vintera</h4>
                                        <span class="striked">$1150</span> <span class="promo">$1050</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php
            require_once('scripts/footer.php');
        ?>
    </body>
</html>