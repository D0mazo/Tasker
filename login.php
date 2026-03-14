<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">

<div class="login-box">

    <h2>Task Planner</h2>

    <form method="POST">

        <input type="text" name="user" placeholder="Username" required>
        <input type="password" name="pass" placeholder="Password" required>

        <button>Login</button>

    </form>

    <?php

    session_start();

    if(isset($_POST["user"])){

        $user=$_POST["user"];
        $pass=$_POST["pass"];

        if($user=="admin" && $pass=="admin123"){

            $_SESSION["user"]="admin";

            header("Location:index.php");
            exit;

        }else{

            echo "<p class='error'>Wrong login</p>";

        }

    }

    ?>

</div>

</body>
</html>