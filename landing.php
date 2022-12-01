<?php
	session_start();

	if(!isset($_GET[ 'method' ]))
		header('Location:index.php');
    if($_GET['method'] == 'delete')
        session_destroy();
    header( "refresh:5;url=index.php" );
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
        <link rel="stylesheet" href="css/landing_styles.css">
        <title>Welcome to PickaGuitar</title>
    </head>
    <body>
        <?php
            require_once('scripts/header.php');
        ?>

        <main>
            <div>
            	<?php
            		if($_GET[ 'method' ] == 'signin')
            		{
    	        		echo "<p>The connexion is a success !<br /> Please wait a few seconds, you'll be redirected onto the main page.</p>";
    	        	}
    	        	elseif($_GET[ 'method' ] == 'signup')
    	        	{
    	        		echo "<p>The registration is a success !<br /> Please wait a few seconds, you'll be redirected onto the main page.</p>";
    	        	}
    	        	elseif($_GET[ 'method' ] == 'error')
    	        	{
    	        		echo "<p>Something went wrong... Try again later.<br /> Please wait a few seconds, you'll be redirected onto the main page.</p>";
    	        	}
                    elseif($_GET['method'] == 'delete')
                    {
                        echo "<p>Your account was successfully deleted !<br />We'll miss you fellow guitar lover... :(<br /> Please wait a few seconds, you'll be redirected onto the main page.</p>";
                    }
    	        ?>
                <div class="loader">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </main>

        <?php
            require_once('scripts/footer.php');
        ?>
	</body>
</html>