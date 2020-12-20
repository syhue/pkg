
<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
    <title>Minimal TCP Stateful PKG</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/nav.css">
    <link rel = "icon" href ="product-logo-rm-bk.png" type = "image/x-icon">
</head>

<body class="body-nav">
    <div><img class="icon-menu" src="icon-menu.png"></div>
    <div class ="container">
        <!-- <div><img class = "nav-logo" src = "product-logo-rm-bk.png"></div> -->
        <div class = "flex-item category1"><a class="font-category">Category 1</a>
            <div class = "dropdown-content content1">
                <a class ="little-item" href="kmnew.php">Init Keystore</a>
                <a class ="little-item" href="kmcsr.php">GetCSR Ckey</a>
                <a class ="little-item" href="kmncr.php">Certify CKey</a>
                <a class ="little-item"href="kmvcr.php">GetCRT Ckey</a>
                <a class ="little-item" href="kmlod.php">Load Keystore</a>
                <a class ="little-item" href="mskini.php">Init MasterKey</a>
                <a class ="little-item" href="mskdel.php">Delete MasterKey</a>
            </div>
        </div>

        <div class = "flex-item category2"><a class="font-category">Category 2</a>
            <div class = "dropdown-content content2">
                <a class ="little-item" href="mpkget.php">View MPKs</a>
                <a class ="little-item" href="mpkcms.php">GetCMS MPKs</a>
                <a class ="little-item" href="uskder.php">Derive USK</a>
                <a class ="little-item" href="uskchk.php">Check USK</a>
            </div>
        </div>

        <div class = "flex-item category3"><a class="font-category">Category 3</a>
            <div class = "dropdown-content content3">
                <a class ="little-item" href="ibsgen.php">Test IBS Gen</a>
                <a class ="little-item" href="ibschk.php">Test IBS Check</a>
            </div>
        </div>
    </div>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

<script>
    $(document).ready(

            function myFunction(x) {
              if (x.matches) { // If media query matches

                $('.container').hide();
                $('.dropdown-content').hide();

                $('.icon-menu').click(function() {
                    $('.container').toggle();

                });

                $('.category1').click(function() {
                    $('.content1').toggle();

                });

                $('.category2').click(function() {
                    $('.content2').toggle();

                });

                $('.category3').click(function() {
                    $('.content3').toggle();

                });
              }
            }

            var x = window.matchMedia("(max-width: 600px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes

    );

</script>

</body>
</html>
