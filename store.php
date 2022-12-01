<?php
    session_start();
    require_once 'scripts/config.php';

    //toute la gestion des filtres
    
    $request = "SELECT Name, Price FROM product";
    if(isset($_GET['submit']))
    {
        if(isset($_GET['type']) || isset($_GET['disponibility']) || isset($_GET['price-range']) || isset($_GET['search']) || isset($_GET['sort']))
        {
            $request = $request." WHERE";
            if(isset($_GET['type']))
            {
                $type = $_GET['type'];
                $length = count($type);
                if($length > 1)
                {  
                    $request = $request . " (";
                    foreach($type as $value)
                    {
                        $tmp = htmlspecialchars($value);
                        $request = $request." Category = '$tmp'";
                        if($length-- > 1)
                            $request = $request." OR";
                    }
                    $request = $request . " )";
                }else
                {
                    $tmp = htmlspecialchars($type[0]);
                    $request = $request." Category = '$tmp'";
                }
            }
            if(isset($_GET['disponibility']))
            {
                if(isset($type))
                    $request = $request." AND";
                $disponibility = $_GET['disponibility'];
                $length = count($disponibility);
                if($length > 1)
                {
                    $request = $request . " (";
                    foreach($disponibility as $value)
                    {
                        if($value == "available")
                            $request = $request." Stock > 10";
                        if($value == "few-available")
                            $request = $request." Stock < 10 AND Stock > 0";
                        if($length-- > 1)
                            $request = $request." OR";
                    }
                    $request = $request . " )";
                } else
                {
                    $value = $disponibility[0];
                    if($value == "available")
                        $request = $request." Stock > 10";
                    if($value == "few-available")
                        $request = $request." Stock < 10 AND Stock > 0";
                } 
            }
            if(isset($_GET['price-range']))
            {
                $price_range = htmlspecialchars($_GET['price-range']);
                if(isset($type) || isset($disponibility))
                    $request = $request." AND";
                $request = $request." Price < '$price_range'";
            }
            if(isset($_GET['sort']))
            {
                $sort = htmlspecialchars($_GET['sort']);
                if($sort == "(A-Z)")
                    $request = $request." ORDER BY Name ASC";
                elseif($sort == "(Z-A)")
                    $request = $request." ORDER BY Name DESC";
                elseif($sort == "+ to -")
                    $request = $request." ORDER BY Price DESC";
                elseif($sort == "- to +")
                    $request = $request." ORDER BY Price ASC";
                elseif($sort =="popularity")
                    $request = $request." ORDER BY Evaluation DESC";
            }
            if(isset($_GET['search']))
            {
                $search = "%".htmlspecialchars($_GET['search'])."%";
                echo $search;
                if(isset($type) || isset($disponibility) || isset($price_range))
                    $request = $request." AND";
                $request = $request." UPPER(Name) LIKE UPPER('$search')";
            }
        }
    }
    elseif(isset($_GET['search']))
    {
        $search = "%".htmlspecialchars($_GET['search'])."%";
        $request = $request." WHERE UPPER(Name) LIKE UPPER('$search')";
    }

    if($query = $DB -> query($request)){}
    else header('Location:landing.php?method=error');
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
        <link rel="stylesheet" href="css/store_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>

        <main>
            <div class="container p-4">
                <h1>STORE</h1>
                <hr />
                <div class="row">
                    <div class="col-md-9 items">
    <!--affichage de tous les produits avec un boucles, infos : image1 pris nom-->
                        <?php
                            echo "<div class=\"row\">";
                            
                            if(isset($_GET['page']))
                                $page = $_GET['page'];
                            else
                                $page = 1;
                            $ite = 0;
                            $nbpage = $page;

                            while($row = $query -> fetch_assoc())
                            {
                                if($ite >= 9 * $page)
                                {
                                    $ite++;
                                    continue;
                                    echo "ok".$ite;
                                }
                                if($ite < 9 * ($page - 1))
                                {
                                    $ite++;
                                    continue;
                                }

                                $name = $row['Name'];
                                $price = $row['Price'];
                                echo "
                                    <div class=\"item\">
                                        <div>
                                            <a href=\"article.php?product=$name\"><img src=\"images/".$name."/".$name."1.jpg\" alt=\"".$name."\" /></a>
                                            <h1>$name</h1>
                                        </div>
                                        <h2>$price$</h2>
                                    </div>
                                ";
                                $ite++;
                                if($ite % 3 == 0)
                                    echo "
                                        </div>
                                        <div class=\"row\">";
                            }
                            echo "</div>";
                            if(gettype($ite / 9) == "integer")
                                $nbpage = intval($ite / 9);
                            else
                                $nbpage = intval($ite / 9) + 1;
                        ?>
                    </div>
                    <div class="col-md-3">
    <!--formulaires avec tous les filtres, faire en sorte qu'ils restent sélectionnés après le rafraichissement-->
                        <form action="" method="get">
                            <div id="filter">
                                <div id="sort">
                                    <legend>Sort By</legend>
                                    <div>
                                        <select name="sort" id="sort" class="custom-select">
                                            <option value="popularity"
                                            <?php
                                                if(isset($sort))
                                                {
                                                    if($sort == "popularity")
                                                        echo " selected";
                                                }
                                            ?>
                                            >Popularity</option>
                                            <option value="(A-Z)"
                                            <?php
                                                if(isset($sort))
                                                {
                                                    if($sort == "(A-Z)")
                                                        echo " selected";
                                                }
                                            ?>
                                            >Alphabetical Order (A-Z)</option>
                                            <option value="(Z-A)"
                                            <?php
                                                if(isset($sort))
                                                {
                                                    if($sort == "(Z-A)")
                                                        echo " selected";
                                                }
                                            ?>
                                            >Alphabetical Order (Z-A)</option>
                                            <option value="- to +"
                                            <?php
                                                if(isset($sort))
                                                {
                                                    if($sort == "- to +")
                                                        echo " selected";
                                                }
                                            ?>
                                            >Price : - to +</option>
                                            <option value="+ to -"
                                            <?php
                                                if(isset($sort))
                                                {
                                                    if($sort == "+ to -")
                                                        echo " selected";
                                                }
                                            ?>
                                            >Price : + to -</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="type">
                                    <legend>Type</legend>
                                    <div>
                                        <input id="electric" name="type[]" type="checkbox" value="Electric"
                                        <?php
                                            if(isset($type)) {
                                                foreach($type as $value)
                                                {
                                                    if($value == "Electric")
                                                        echo "checked";
                                                }
                                            }
                                        ?>
                                        />
                                        <label for="electric">Electric</label>
                                    </div>
                                    <div>
                                        <input id="electroacoustic" name="type[]" type="checkbox" value="Electroacoustic"
                                        <?php
                                            if(isset($type)) {
                                                foreach($type as $value)
                                                {
                                                    if($value == "Electroacoustic")
                                                        echo "checked";
                                                }
                                            }
                                        ?>
                                        />
                                        <label for="electroacoustic">Electroacoustic</label>
                                    </div>
                                    <div>
                                        <input id="acoustic" name="type[]" type="checkbox" value="Acoustic"
                                        <?php
                                            if(isset($type)) {
                                                foreach($type as $value)
                                                {
                                                    if($value == "Acoustic")
                                                        echo "checked";
                                                }
                                            }
                                        ?>
                                        />
                                        <label for="acoustic">Acoustic</label>
                                    </div>
                                </div>
                                <div id="price">
                                    <legend>Price Range</legend>
                                    <div>
                                        <input type="range" name="price-range" id="price-range" min="0" max="6000"
                                        <?php
                                            if(isset($price_range))
                                                echo " value=\"$price_range\"";
                                            else
                                                echo " value=\"6000\"";
                                        ?>
                                        oninput="this.nextElementSibling.value = this.value" />
                                        <output>
                                            <?php
                                                if(isset($price_range))
                                                    echo " ".$price_range;
                                                else
                                                    echo " 6000";
                                            ?>
                                        </output>
                                    </div>
                                </div>
                                <div id="dispo">
                                    <legend>Disponibility</legend>
                                    <div>
                                        <input type="checkbox" id="available" name="disponibility[]" value="available"
                                        <?php
                                            if(isset($disponibility))
                                            {
                                                foreach($disponibility as $key => $value)
                                                {
                                                    if($value == "available")
                                                        echo "checked";
                                                }
                                            }
                                        ?>
                                        />
                                        <label for="available">Available</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="few-available" name="disponibility[]" value="few-available"
                                        <?php
                                            if(isset($disponibility))
                                            {
                                                foreach($disponibility as $key => $value)
                                                {
                                                    if($value == "few-available")
                                                        echo "checked";
                                                }
                                            }
                                        ?>
                                        />
                                        <label for="few-available">Few-Available</label>
                                    </div>
                                </div>
                                <div id="submit">
                                    <a role="button" href="store.php?page=<?php echo $page; ?>">Reset All</a>
                                    <button type="submit" name="submit" value="true">Apply</button>
                                </div>
                            </div>
                            <div id="pages">
                                <?php
                                    if($page > 1)
                                    {
                                        echo "
                                            <button name=\"page\" type=\"submit\" value=\"1\"><<</button>
                                            <button name=\"page\" type=\"submit\" value=\"".($page - 1)."\"><</button>";
                                    }

                                    echo "<button name=\"page\" type=\"submit\" formmethod=\"get\" formtarget=\"_self\" value=\"".$page."\">".$page."</button>";

                                    if($page < $nbpage)
                                    {
                                        echo "
                                            <button name=\"page\" type=\"submit\" value=\"".($page + 1)."\">></button>
                                            <button name=\"page\" type=\"submit\" value=\"".$nbpage."\">>></button>
                                        ";
                                    }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        
        <?php
            require_once('scripts/footer.php');
        ?>
    </body>
</html>