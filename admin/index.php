<?php
require ("core/init.php");
if(isset($_POST["email"])) {
    $email=sanitize($_POST["email"]);
    $pass=md5(sanitize($_POST["pwd"]));
    $db=new DB();
    $db->get("SELECT * FROM korisnici WHERE sifra='$pass' AND email='$email' ");
    if ($db->num==1) {
        $r=$db->res;
        $_SESSION["id_korisnika"]=$r[0]["id_korisnika"];
        header("Location:pocetna.php");
        die();
    } else {
        $error=true;
    }
} else {
    $error=false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>CMS</title>
<?php require ("includes/header.php")?>
</head>
<body>
    <div class="container">
        <form class="form-signin" method="POST" action="index.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pwd" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <?php
            if ($error) {
                echo "<br/><span class='label label-danger'>Pogresan unos za email ili sifru!</span>";
            }
        ?>
      </form>
    </div>
</body>
</html>