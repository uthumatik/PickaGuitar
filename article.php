<?php
    session_start();
    require_once 'scripts/config.php';

    if(isset($_GET['product']))
    {
        $product = $_GET['product'];
        if($check = $DB -> query("SELECT Name from product WHERE Name = '$product'"))
        {
            if($DB -> affected_rows == 1)
            {
                $images = array("images/".$product."/".$product."1.jpg", "images/".$product."/".$product."2.jpg", "images/".$product."/".$product."3.jpg", "images/".$product."/".$product."4.jpg", "images/".$product."/".$product."5.jpg");

                if($query = $DB -> query("SELECT ID, Price, Producer, Description, Caracteristics, Stock FROM product WHERE Name = '$product'"))
                {
                    if($DB -> affected_rows == 1)
                    {
                        $array = $query -> fetch_assoc();
                        $price = $array['Price'];
                        $producer = $array['Producer'];
                        $description = $array['Description'];
                        $caracteristics = $array['Caracteristics'];
                        $stock = $array['Stock'];
                        $id = intval($array['ID']);
                        if(isset($_GET['add']))
                        {
                            if(!isset($_SESSION['cart']))
                                $_SESSION['cart'] = array($id => 1);
                            else
                            {
                                if(isset($_SESSION['cart'][$id]))
                                    $_SESSION['cart'][$id]++;
                                else
                                    $_SESSION['cart'][$id] = 1;
                            }
                        }
                    }else header('Location:landing.php?method=error');
                }else header('Location:landing.php?method=error');
            }else header('Location:landing.php?method=error');
        }else header('Location:landing.php?method=error');
    }else header('Location:landing.php?method=error');
?>

<html lang="en" id="head">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="css/common_styles.css">
        <link rel="stylesheet" href="css/article_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>

    <body>
        <?php
            require_once('scripts/header.php');
        ?>

    <main>
        <div class="container p-4">
            <div class="row" id="main-infos">
                <div class="col-md-8" id="guitar-images">
                    <div class="row" id="main-image">
                        <?php
                            echo "
                                <img class=\"img-fluid\" src=\"$images[0]\" alt=\"$images[0]\" />
                            ";
                        ?>
                    </div>
                    <div class="row">
                        <?php
                            echo "
                                <div id=\"miniatures\">
                                    <img class=\"img-fluid col-md-3 miniature\" src=\"$images[1]\" alt=\"$images[1]\" />
                                    <img class=\"img-fluid col-md-3 miniature\" src=\"$images[2]\" alt=\"$images[2]\" />
                                    <img class=\"img-fluid col-md-3 miniature\" src=\"$images[3]\" alt=\"$images[3]\" />
                                    <img class=\"img-fluid col-md-3 miniature\" src=\"$images[4]\" alt=\"$images[4]\" />
                                </div>
                            ";
                        ?>
                    </div>
                </div>

                <div class="col-md-4" id="infos-product">
                    <span>
                        <?php
                            echo "
                                <h1>$product</h1>
                                <h4>$producer</h4>
                                <h1 id=\"prix\">$price$</h1>
                                <p>Price includes VAT</p>
                            ";
                            if($stock > 10)
                            {
                                echo "
                                    <div class=\"alert-success alert\" id=\"disponibility\">Available</div>
                                    <div class=\"float-right\" id=\"add-button\">
                                        <form method=\"get\" action=\"article.php\">
                                            <input type=\"hidden\" value=\"$product\" name=\"product\" />
                                            <button type=\"submit\" value=\"$product\" name=\"add\" class=\"btn btn-primary\">
                                                Add To Cart<i class=\"fas fa-shopping-cart\"></i>
                                            </button>
                                        </form>
                                      ";
                                if(isset($_GET['add']) && isset($_SESSION['cart'][$id]))
                                {
                                    echo "
                                        <p id=\"success\">Success, this item was added to your cart !</p>
                                    ";
                                }
                                echo "</div>";
                            }else if($stock == 0)
                            {
                                echo "
                                    <div class=\"alert-danger alert\" id=\"disponibility\">Unavailable</div>
                                ";
                            }else
                            {
                                echo "
                                    <div class=\"alert-warning alert\" id=\"disponibility\">Only $stock available</div>
                                    <div id=\"add-cart\">
                                        <form method=\"get\" action=\"article.php\">
                                            <input type=\"hidden\" value=\"$product\" name=\"product\" />
                                            <button type=\"submit\" value=\"$product\" name=\"add\" class=\"btn btn-primary\">
                                                Add To Cart<i class=\"fas fa-shopping-cart\"></i>
                                            </button>
                                        </form>
                                ";
                                if(isset($_GET['add']) && isset($_SESSION['cart'][$id]))
                                {
                                    echo "
                                        <p id=\"success\">Success, this item was added to your cart !</p>
                                    ";
                                }
                                echo "</div>";
                            }
                        ?>
                    </span>
                </div>
            </div>
            <hr id="separator"/>
            <div class="row" id="infos">
                <div id="description">
                    <h3>Description</h3>
                    <?php
                        echo "$description";
                    ?>
                </div>
                <div id="caracteristics">
                    <h3>Caracteristics</h3>
                    <?php
                        echo "$caracteristics";
                    ?>
                </div>
            </div>
        </div>
    </main>

        <?php
            require_once('scripts/footer.php');
        ?>
    </body>
</html>