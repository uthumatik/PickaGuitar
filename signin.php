<?php
    session_start();
    require_once 'scripts/config.php';

    if(isset($_POST[ 'email' ]) && isset($_POST[ 'password' ]))
    {
	    $email = htmlspecialchars($_POST[ 'email' ]);
	    $password = htmlspecialchars($_POST[ 'password' ]);
        $password = hash('sha256', $password);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            header('Location:signin.php?login_err=true');
        
        if ($check = $DB -> query("SELECT ID FROM user WHERE Email = '$email' AND Password = '$password'")) {
            if($DB -> affected_rows == 1)
            {
                $data = $check -> fetch_assoc();
                $_SESSION['user'] = $data['ID'];
                header('Location:landing.php?method=signin');
            }else header('Location:signin.php?login_err=true');
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
        <link rel="stylesheet" href="css/signin_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>

<!--Contenu-->
        <main>
            <div class="login-box">
                <h2>Sign In</h2>
                <form action="" method="post">
                    <div class="user-box">
                        <input type="text" name="email" id="email" required autocomplete="off" />
                        <label for="email">Email</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="password" id="password" required autocomplete="off" />
                        <label for="password">Password</label>
                    </div>
                    <?php
                        if(isset($_GET['login_err']) && $_GET['login_err'] == "true")
                            echo "<p class=\"error\">Please verify your email address and password !</p>";
                    ?> 
                    <p>
                        <a href="#" title="">Forgot password?</a>
                        <a href="signup.php" title="signup">Sign Up</a>
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