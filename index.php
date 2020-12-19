<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="css/index.css">
<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500;1,700;1,800&display=swap" rel="stylesheet">
</head>

<!-- navbar-->
<?php require 'nav.php'?>
<body>
    <div class="container-first-page">
        <div><img src = "product-logo-rm-bk.png"></div>
        <div><h1 class="welcome">Welcome to Minimal TCP Stateful PKG.</h1><div>
        <div class="intro-text"><p>If you have not created a keystore, please create one first</p></div>
        <div class="intro-text">
        <p>If a keystore is created, please load it first upon http service start</p></div>
    </div>
</body>

<script>
    $(document).ready(function() {

        $('.icon-menu').click(function() {
            $('.container-first-page').toggle();




        });
});

</script>
</html>
