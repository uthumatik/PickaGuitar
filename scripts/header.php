<header>
    <nav>
        <div id="firstheader">
            <li><a href="index.php" title="home">HOME</a></li>
            <li><a href="store.php" title='store'>STORE</a></li>
            <li>
                <form method="get" action="store.php">
                    <input type="search" placeholder="Search" name="search"></input>
                    <button>
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </form>
            </li>
        </div>

        <div id="logoheaderdiv">
            <a href="#head" title="head"><img id="logoheader" src="images/logo.png" alt=""></a>
        </div>

        <div id="secondheader">
            <li>
                <a href="#contact" title="contact">CONTACT</a>
            </li>
            <li>ACCOUNT
                <ul id="sub-menu">
                    <?php
                        if($_SESSION['user'] != "localhost")
                        {
                            echo "
                                <li>
                                    <a href=\"profile.php\" title=\"profile\">PROFILE</a>
                                </li>
                                <li>
                                    <a href=\"scripts/signout.php\" title=\"signout\">SIGN OUT</a>
                                </li>";
                        }
                        else
                        {
                            echo "
                                <li>
                                    <a href=\"signup.php\" title=\"signup\">SIGN UP</a>
                                </li>
                                <li>
                                    <a href=\"signin.php\" title=\"signin\">SIGN IN</a>
                                </li>";
                        }
                    ?>
                </ul>
            </li>
            <li>
                <a href="cart.php" title="cart">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </a>
            </li>
        </div>
    </nav>
</header>