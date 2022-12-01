<?php
    session_start();
    require_once 'scripts/config.php';

    $user = $_SESSION['user'];

    if(isset($_POST['modify']))
        $_SESSION['modify'] = "true";
    if(!isset($_POST['modify']) && !isset($_GET['profile_err']))
        unset($_SESSION['modify']);

    if($user != "localhost")
    {
        if($query = $DB->query("SELECT FirstName, LastName, Gender, Age, Address, PhoneNumber, Email, Password FROM user WHERE ID = '$user'"))
        {
            if($DB -> affected_rows == 1)
            {
                if(isset($_POST['delete']))
                {
                    if($query = $DB->query("SELECT ID FROM cart WHERE IdUser = '$user'"))
                    {
                        if($DB -> affected_rows > 0)
                        {
                            if($query = $DB->query("DELETE FROM cart WHERE IdUser = '$user'"));
                            else header('Location:landing.php?method=error');
                        }
                        if($query = $DB->query("DELETE FROM user WHERE ID = '$user'"))
                            header('Location:landing.php?method=delete');
                        else header('Location:landing.php?method=error');
                    }else header('Location:landing.php?method=error');
                }
                else
                {
                    $data = $query -> fetch_assoc();
                    $oldpassword = $data['Password'];
                    $firstname = $data['FirstName'];
                    $lastname = $data['LastName'];
                    $address = $data['Address'];
                    $age = $data['Age'];
                    $gender = $data['Gender'];
                    $tel = $data['PhoneNumber'];
                    $email = $data['Email'];
                    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['address']) && isset($_POST['age']) && isset($_POST['gender']) && isset($_POST['region']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['old_password']) && isset($_POST['password']) && isset($_POST['retype_password']))
                    {
                        $firstname = htmlspecialchars($_POST[ 'firstname' ]);
                        $lastname = htmlspecialchars($_POST[ 'lastname' ]);
                        $address = htmlspecialchars($_POST[ 'address' ]);
                        $age = htmlspecialchars($_POST[ 'age' ]);
                        $gender = htmlspecialchars($_POST[ 'gender' ]);
                        $tel = htmlspecialchars($_POST[ 'region' ]) . htmlspecialchars($_POST[ 'tel' ]);
                        $email = htmlspecialchars($_POST[ 'email' ]);
                        $oldp = hash('sha256', htmlspecialchars($_POST[ 'old_password' ]));
                        $password = htmlspecialchars($_POST[ 'password' ]);
                        $retype_password = htmlspecialchars($_POST[ 'retype_password' ]);
                        if ($check = $DB -> query("SELECT Email FROM user WHERE Email = '$email' AND ID = '$user'"))
                        {
                            if($DB -> affected_rows == 1 || $DB -> affected_rows == 0)
                            {
                                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                                {
                                    if(filter_var(trim($age), FILTER_VALIDATE_INT))
                                    {
                                        if(filter_var(trim($_POST[ 'tel' ]), FILTER_VALIDATE_INT))
                                        {
                                            if($password !== $retype_password)
                                            {
                                                $_SESSION['modify'] = "true";
                                                header('Location:profile.php?profile_err=password');
                                            }
                                            elseif($oldpassword !== $oldp)
                                            {
                                                $_SESSION['modify'] = "true";
                                                header('Location:profile.php?profile_err=old_password');
                                            }
                                            else
                                            {
                                                $password = hash('sha256', $password);

                                                if($query = $DB -> query("UPDATE user SET LastName = '$lastname', FirstName = '$firstname', Gender = '$gender', Address = '$address', Age = '$age', PhoneNumber = '$tel', Email = '$email', Password = '$password' WHERE ID = '$user'"))
                                                {
                                                    if(isset($_SESSION['modify']))
                                                        unset($_SESSION['modify']);
                                                }
                                                else header('Location:landing.php?method=error');
                                            }
                                        }
                                        else
                                        {
                                            $_SESSION['modify'] = "true";
                                            header('Location:profile.php?profile_err=tel');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['modify'] = "true";
                                        header('Location:profile.php?profile_err=age');
                                    }
                                }
                                else
                                {
                                    $_SESSION['modify'] = "true";
                                    header('Location:profile.php?profile_err=email');
                                }
                            }else header('Location:profile.php?profile_err=already');
                        }
                    }
                }
            }else header('Location:landing.php?method=error');
        }else header('Location:landing.php?method=error');
    }else header('Location:index.php');
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
        <link rel="stylesheet" href="css/profile_styles.css">
        <title>My Profile - PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>

        <main>
            <?php
                if(!isset($_SESSION['modify']))
                {
                    echo "
                        <div class=\"login-box\">
                            <h2>Profile</h2>
                            <hr />
                            <div class=\"infos-profile\">
                                <h2>Last Name</h2>
                                <p>".$lastname."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>First Name</h2>
                                <p>".$firstname."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>Gender</h2>
                                <p>".$gender."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>Age</h2>
                                <p>".$age."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>Address</h2>
                                <p>".$address."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>Phone Number</h2>
                                <p>".$tel."</p>
                            </div>

                            <div class=\"infos-profile\">
                                <h2>Email</h2>
                                <p>".$email."</p>
                            </div>
                            <div id=\"buttons\">
                                <form method=\"post\" action=\"\" >
                                    <button type=\"submit\" id=\"modify\" name=\"modify\" value=\"true\" class=\"btn btn-outline-light\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        Modify
                                    </button>
                                    <button type=\"submit\" id=\"delete\" name=\"delete\" value=\"true\" class=\"btn btn-outline-light\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    ";
                }
                else
                {
                    echo "
                        <div class=\"login-box\">
                            <h2>Profile</h2>
                            <form action=\"\" method=\"post\">
                                <div class=\"user-box\">
                                    <input type=\"text\" name=\"firstname\" id=\"firstname\" maxlenght=\"255\" required autocomplete=\"off\" value=\"".$firstname."\"/>
                                    <label for=\"firstname\">First name</label>
                                </div>

                                <div class=\"user-box\">
                                    <input type=\"text\" name=\"lastname\" id=\"lastname\" maxlenght=\"255\" required autocomplete=\"off\" value=\"".$lastname."\"/>
                                    <label for=\"lastname\">Last name</label>
                                </div>

                                <div class=\"user-box\">
                                    <input type=\"text\" name=\"address\" id=\"address\" maxlenght=\"255\" required autocomplete=\"off\" value=\"".$address."\"/>
                                    <label for=\"address\">Address</label>
                                </div>

                                <div class=\"user-box\">
                                    <input type=\"text\" name=\"age\" id=\"age\" maxlength=\"3\" autocomplete=\"off\" required value=\"".$age."\"/>
                                    <label for=\"age\">Age</label>
                                </div>
                        ";
                    if(isset($_GET[ 'profile_err' ]) && $_GET[ 'profile_err' ] == 'age')
                        echo "<p class=\"error\">The value is not correct !</p>";
                    echo "

                                <div class=\"user-box\">
                                    <select name=\"gender\" id=\"gender\">
                                        <option value=\"Unknown\"
                        ";
                    if($gender === "unknown")
                        echo " selected";
                    echo "
                                        >I don't wish to share it</option>
                                        <option value=\"Male\"
                        ";
                    if($gender === "Male")
                        echo " selected";
                    echo "
                                        >Male</option>
                                        <option value=\"Female\"
                    ";
                    if($gender === "Female")
                        echo " selected";
                    echo "
                                        >Female</option>
                                        <option value=\"Other\"
                    ";
                    if($gender === "Other")
                        echo " selected";
                    echo "
                                        >Other</option>
                                    </select>
                                    <label for=\"gender\">Gender</label>
                                </div>

                                <div class=\"user-box\">
                                    <select name=\"region\" id=\"region\">
                                        <option value=\"(+33)\">+33</option>
                                        <option value=\"(+49)\">+49</option>
                                        <option value=\"(+61)\">+61</option>
                                        <option value=\"(+55)\">+55</option>
                                        <option value=\"(+81)\">+81</option>
                                        <option value=\"(+86)\">+86</option>
                                        <option value=\"(+1)\">+1</option>
                                    </select>
                                    <input type=\"text\" name=\"tel\" id=\"tel\" maxlenght=\"50\" required autocomplete=\"off\" />
                                    <label for=\"tel region\">Phone number</label>
                                </div>
                    ";
                    if(isset($_GET[ 'profile_err' ]) && $_GET[ 'profile_err' ] == 'tel')
                        echo "<p class=\"error\">The value is not correct !</p>";
                    echo "

                                <div class=\"user-box\">
                                    <input type=\"text\" name=\"email\" id=\"email\" maxlenght=\"255\" required autocomplete=\"off\" value=\"".$email."\"/>
                                    <label for=\"email\">Email</label>
                                </div>
                    ";
                    if(isset($_GET[ 'profile_err' ]) && $_GET[ 'profile_err' ] == 'already')
                        echo "<p class=\"error\">This email address is already being used !</p>";
                    elseif(isset($_GET[ 'profile_err' ]) && $_GET[ 'profile_err' ] == 'email')
                        echo "<p class=\"error\">Your email address is not recognized !</p>";
                    echo "
                                <div class=\"user-box\">
                                    <input type=\"password\" name=\"old_password\" id=\"old_password\" maxlenght=\"255\" required autocomplete=\"off\" />
                                    <label for=\"old_password\">Old Password</label>
                                </div>

                                <div class=\"user-box\">
                                    <input type=\"password\" name=\"password\" id=\"password\" maxlenght=\"255\" required autocomplete=\"off\" />
                                    <label for=\"password\">New Password</label>
                                </div>

                                <div class=\"user-box\">
                                    <input type=\"password\" name=\"retype_password\" id=\"retype_password\" maxlenght=\"255\" required autocomplete=\"off\" />
                                    <label for=\"retype_password\">Retype New Password</label>
                                </div>
                    ";
                    if(isset($_GET[ 'profile_err' ]) && $_GET[ 'profile_err' ] == 'password')
                        echo "<p class=\"error\">The new-password fields do not match !</p>";
                    elseif(isset($_GET['profile_err']) && $_GET['profile_err'] == 'old_password')
                        echo "<p class=\"error\">The old-password is not correct !</p>";
                    echo "
                                <div id=\"buttons\">
                                    <button type=\"submit\" id=\"submit\" name=\"modify\" value=\"true\" class=\"btn btn-outline-light\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        Submit
                                    </button>
                                    <a role=\"button\" href=\"profile.php\" id=\"cancel\" class=\"btn btn-outline-light\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    ";
                }
            ?>
        </main>

        <?php
            require_once('scripts/footer.php');
        ?>
    </body>
</html>