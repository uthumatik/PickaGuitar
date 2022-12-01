<?php
    session_start();
    require_once 'scripts/config.php';
    $user = $_SESSION['user'];
    if(isset($_POST['remove']))
        $remove = $_POST['remove'];
    if(isset($_POST['change']) && isset($_POST['quantity']))
    {
        $change = $_POST['change'];
        $quantity = $_POST['quantity'];
    }
    if($user != "localhost")
    {
        $request = "SELECT IdProduct, Name, Price, Quantity FROM product INNER JOIN cart WHERE product.ID IN (SELECT IdProduct FROM cart WHERE IdUser = '$user')";
        if($query = $DB -> query($request))
        {
            if($DB -> affected_rows == 0)
            {
                if(isset($_SESSION['cart']))
                {
                    foreach($_SESSION['cart'] as $key => $value)
                    {
                        $request = "SELECT Name, Price FROM product WHERE ID = '$key'";
                        if($query = $DB -> query($request))
                        {
                            if($DB -> affected_rows == 1)
                            {
                                $data = $query -> fetch_assoc();
                                if(isset($remove) && $data['Name'] == $remove)
                                {
                                    unset($_SESSION['cart'][$key]);
                                    continue;
                                }
                                elseif(isset($change) && isset($quantity) && $data['Name'] == $change)
                                {
                                    $_SESSION['cart'][$key] = intval($quantity);
                                    $cart[$data['Name']][$data['Price']] = intval($quantity);
                                    $value = intval($quantity);
                                }
                                else
                                    $cart[$data['Name']][$data['Price']] = $value;
                                if($query = $DB -> query("INSERT INTO cart (IdUser, IdProduct, Quantity) VALUES ('$user', '$key', '$value')"));
                                else header('Location:landing.php?method=error');
                            }else unset($_SESSION['cart'][$key]);
                        }else header('Location:landing.php?method=error');
                    }
                }
            }
            else
            {
                if(isset($_SESSION['cart']))
                {
                    var_dump($_SESSION['cart']);
                    foreach($_SESSION['cart'] as $key => $value)
                    {
                        $request = "SELECT Name, Price FROM product WHERE ID = '$key'";
                        if($query = $DB -> query($request))
                        {
                            if($DB -> affected_rows == 1)
                            {
                                $data = $query -> fetch_assoc();
                                if(isset($remove) && $data['Name'] == $remove)
                                {
                                    unset($_SESSION['cart'][$key]);
                                    $value = 0;
                                }
                                elseif(isset($change) && isset($quantity) && $data['Name'] == $change)
                                {
                                    $_SESSION['cart'][$key] = intval($quantity);
                                    $cart[$data['Name']][$data['Price']] = intval($quantity);
                                    $value = intval($quantity);
                                }
                                else
                                    $cart[$data['Name']][$data['Price']] = $value;
                            }else unset($_SESSION['cart'][$key]);
                        }else header('Location:landing.php?method=error');
                        if($value == 0)
                        {
                            if($query = $DB -> query("DELETE FROM cart WHERE IdUser = '$user' AND IdProduct = '$key'"));
                            else header('Location:landing.php?method=error');
                            continue;
                        }
                        if($query = $DB -> query("UPDATE cart SET Quantity = '$value' WHERE IdUser = '$user' AND IdProduct = '$key'"));
                        else header('Location:landing.php?method=error');
                    }
                }
                else
                {
                    $request = "SELECT IdProduct, Name, Price, Quantity FROM product INNER JOIN cart WHERE product.ID IN (SELECT IdProduct FROM cart WHERE IdUser = '$user')";
                    if($query = $DB -> query($request))
                    {
                        if($DB -> affected_rows != 0)
                        {
                            while($row = $query -> fetch_assoc())
                            {
                                $name = $row['Name'];
                                $price = $row['Price'];
                                $quantity = $row['Quantity'];
                                $id = $row['IdProduct'];
                                if(isset($name) && isset($price) && isset($quantity))
                                {
                                    $_SESSION['cart'][$id] = intval($quantity);
                                    $cart[$name][$price] = intval($quantity);
                                }else header('Location:landing.php?method=error');
                            }
                        }
                    }else header('Location:landing.php?method=error');
                }
            }
        }else header('Location:landing.php?method=error');
    }
    else
    {
        if(isset($_SESSION['cart']))
        {
            foreach($_SESSION['cart'] as $key => $value)
            {
                if($value == 0){
                    unset($_SESSION['cart']['$key']);
                    continue;
                } 
                $request = "SELECT Name, Price FROM product WHERE ID = '$key'";
                if($query = $DB -> query($request))
                {
                    if($DB -> affected_rows == 1)
                    {
                        $data = $query -> fetch_assoc();
                        if(isset($remove) && $data['Name'] == $remove)
                        {
                            unset($_SESSION['cart'][$key]);
                            continue;
                        }
                        elseif(isset($change) && isset($quantity) && $data['Name'] == $change)
                        {
                            $_SESSION['cart'][$key] = $quantity;
                            $cart[$data['Name']][$data['Price']] = intval($quantity);
                            continue;
                        }
                        else
                            $cart[$data['Name']][$data['Price']] = $value;
                    }else unset($_SESSION['cart'][$key]);
                }else header('Location:landing.php?method=error');
            }
        }
    }
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
        <link rel="stylesheet" href="css/cart_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
   <body>
        <?php
            require_once('scripts/header.php');
        ?>

        <main>
            <div class="container p-4">
                <h1>Cart</h1>
                <hr />
                <?php
                    if(!isset($cart))
                    {
                        echo "<span id=\"empty\">Your cart is empty !<br /> What are you waiting for ? Go choose a guitar and shred to death !</span>";
                    }
                    else
                    {
                        $total = 0;
                        foreach($cart as $key1 => $value)
                        {
                            foreach($value as $key2 => $key3)
                            {
                                echo "
                                    <div class=\"item row\">
                                        <div class=\"col-md-4\">
                                            <a href=\"article.php?product=$key1\"><img src=\"images/".$key1."/".$key1."1.jpg\" alt=\"".$key1."\" /></a>
                                        </div>
                                        <div class=\"col-md-8 infos\">
                                            <div class=\"name\">
                                                <h2>".$key1."</h2>
                                                <div class=\"form\">
                                                    <form method=\"post\" action=\"\">
                                                        <input type=\"hidden\" value=\"$key1\" name=\"change\" />
                                                        <select class=\"custom-select\" name=\"quantity\">

                                ";
                                for($i=$key3; $i > 0; $i--)
                                {
                                    $total += $key2;
                                    echo"
                                        <option value=\"$i\">".$i."</option>
                                    ";
                                }
                                echo "
                                                        </select>
                                                        <button type=\"submit\" name=\"submit\" value=\"true\" class=\"btn btn-outline-light\">Apply</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class=\"price\">
                                                <div>
                                                    <h2>Price</h2>
                                                    <h3>".($key2 * $key3)."$</h3>
                                                </div>
                                                <form method=\"post\" action=\"\">
                                                    <button type=\"submit\" name=\"remove\" value=\"$key1\" class=\"btn btn-outline-danger\">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }  
                        }
                        echo "
                            <div class=\"row\">
                                <div>
                                    <h2>Total</h2>
                                    <h3>".$total."$</h3>
                                </div>
                                <a href=\"#\" role=\"button\" id=\"validation\" class=\"btn btn-primary\">Validate Cart</a>
                            </div>
                        ";
                    }
                ?>
            </div>
        </main>
        
        <?php
            require_once('scripts/footer.php');        ?>
    </body>
</html>