<?php
	session_start();
	require_once('scripts/config.php');

    if(isset($_POST[ 'firstname' ]) && isset($_POST[ 'lastname' ]) && isset($_POST[ 'address' ]) && isset($_POST[ 'age' ]) && isset($_POST[ 'gender' ]) && isset($_POST[ 'region' ]) && isset($_POST[ 'tel' ]) && isset($_POST[ 'email' ]) && isset($_POST[ 'password' ]) && isset($_POST[ 'retype_password' ]))
    {
    	$firstname = htmlspecialchars($_POST[ 'firstname' ]);
    	$lastname = htmlspecialchars($_POST[ 'lastname' ]);
 		$address = htmlspecialchars($_POST[ 'address' ]);
 		$age = htmlspecialchars($_POST[ 'age' ]);
 		$gender = htmlspecialchars($_POST[ 'gender' ]);
 		$tel = htmlspecialchars($_POST[ 'region' ]) . htmlspecialchars($_POST[ 'tel' ]);
	    $email = htmlspecialchars($_POST[ 'email' ]);
	    $password = htmlspecialchars($_POST[ 'password' ]);
	    $retype_password = htmlspecialchars($_POST[ 'retype_password' ]);



	    if ($check = $DB -> query("SELECT Email FROM user WHERE Email = '$email'")) {
            if($DB -> affected_rows == 0)
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    if(filter_var(trim($age), FILTER_VALIDATE_INT))
                    {
                        if(filter_var(trim($_POST[ 'tel' ]), FILTER_VALIDATE_INT))
                        {
                        	if($password !== $retype_password)
                        	{
                        		header('Location:signup.php?signup_err=password');
                        	}else
                        	{
                        		$password = hash('sha256', $password);
                        		$IP = $_SERVER['REMOTE_ADDR'];

                        		if($insert = $DB -> query("INSERT INTO user (LastName, FirstName, Gender, Age, Address, PhoneNumber, Email, Password, IP) VALUES ('$lastname', '$firstname', '$gender', '$age', '$address', '$tel', '$email', '$password', '$IP')"))
                  				{
                                    if($recup = $DB -> query("SELECT ID FROM user WHERE Email='$email'"))
                                    {
                                        if($DB -> affected_rows == 1)
                                        {
                                            $id = $recup -> fetch_assoc();
                                            $_SESSION['user'] = $id['ID'];
                                            header('Location:landing.php?method=signup');
                                        }else header('Location:landing.php?method=error');
                                    }else header('Location:landing.php?method=error');
            	                }else header('Location:landing.php?method=error');
                        	}
                        }else header('Location:signup.php?signup_err=tel');
                    }else header('Location:signup.php?signup_err=age');
                }else header('Location:signup.php?signup_err=email');
            }else header('Location:signup.php?signup_err=already');
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
        <link rel="stylesheet" href="css/signup_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>
        	
        <main>
            <div class="login-box">
                <h2>Sign Up</h2>
                <form action="" method="post">
                    <div class="user-box">
                        <input type="text" name="firstname" id="firstname" maxlenght="255" required autocomplete="off" />
                        <label for="firstname">First name</label>
                    </div>

                    <div class="user-box">
                        <input type="text" name="lastname" id="lastname" maxlenght="255" required autocomplete="off" />
                        <label for="lastname">Last name</label>
                    </div>

                    <div class="user-box">
                        <input type="text" name="address" id="address" maxlenght="255" required autocomplete="off" />
                        <label for="address">Address</label>
                    </div>

                    <div class="user-box">
                        <input type="text" name="age" id="age" maxlength="3" required autocomplete="off" />
                        <label for="age">Age</label>
                    </div>
                    <?php
                        if(isset($_GET[ 'signup_err' ]) && $_GET[ 'signup_err' ] == 'age')
                            echo "<p class=\"error\">The value is not correct !</p>";
                    ?>

                    <div class="user-box">
                        <select name="gender" id="gender">
                            <option value="Unknown">I don't wish to share it</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="gender">Gender</label>
                    </div>

                    <div class="user-box">
                        <select name="region" id="region">
                            <option value="(+33)">+33</option>
                            <option value="(+49)">+49</option>
                            <option value="(+61)">+61</option>
                            <option value="(+55)">+55</option>
                            <option value="(+81)">+81</option>
                            <option value="(+86)">+86</option>
                            <option value="(+1)">+1</option>
                        </select>
                        <input type="text" name="tel" id="tel" maxlenght="50" required autocomplete="off" />
                        <label for="tel region">Phone number</label>
                    </div>
                    <?php
                        if(isset($_GET[ 'signup_err' ]) && $_GET[ 'signup_err' ] == 'tel')
                            echo "<p class=\"error\">The value is not correct !</p>";
                    ?>

                    <div class="user-box">
                        <input type="text" name="email" id="email" maxlenght="255" required autocomplete="off" />
                        <label for="email">Email</label>
                    </div>
                    <?php
                        if(isset($_GET[ 'signup_err' ]) && $_GET[ 'signup_err' ] == 'already')
                            echo "<p class=\"error\">This email address is already being used !</p>";
                        elseif(isset($_GET[ 'signup_err' ]) && $_GET[ 'signup_err' ] == 'email')
                            echo "<p class=\"error\">Your email address is not recognized !</p>";
                    ?>

                    <div class="user-box">
                        <input type="password" name="password" id="password" maxlenght="255" required autocomplete="off" />
                        <label for="password">Password</label>
                    </div>

                    <div class="user-box">
                        <input type="password" name="retype_password" id="retype_password" maxlenght="255" required autocomplete="off" />
                        <label for="password">Retype Password</label>
                    </div>
                    <?php
                        if(isset($_GET[ 'signup_err' ]) && $_GET[ 'signup_err' ] == 'password')
                            echo "<p class=\"error\">The password fields do not match !</p>";
                    ?>

                    <p>
                        <a href="signin.php" title="signin">Already have an account ?</a>
                    </p>
                    <button>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Submit
                    </button>
                </form>
            </div>
		</main>

        <?php
            require_once('scripts/footer.php');
        ?>
	</body>
</html>