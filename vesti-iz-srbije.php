<?php require_once 'core/init.php';?>
<!DOCTYPE html>
<html>
<head>
<?php require_once 'includes/header.php'; ?>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/sr_RS/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<?php require_once 'includes/nav.php';?>
<div id="map-canvas"></div>
<nav class="navbar navbar-default navbar-static-bottom" id="feed">
        <?php require_once 'includes/feed.php';?>
</nav>
</body>
</html>