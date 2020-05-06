<?php
require "language.php";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Lien Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Lien police d'écriture -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <!-- Lien Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark" id="nav">
        <div class="container">
            <a class="navbar-brand active" href="index.php" title="">
                <img class="logo" src="img/majordhome.png" title="logo" alt="Logo Majord'home">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link colorLink" href="index.php" title="">
                            <span class="sr-only">(current)</span>
                        </a>


                    <li class="nav-item ">
                        <a class="nav-link colorLink" href="#who" title=""><?php echo $lang['about'] ?></a>

                    <li class="nav-item">
                        <a class="nav-link colorLink" href="#services" title=""><?php echo $lang['service'] ?></a>


                    <li class="nav-item">
                        <a class="nav-link colorLink" href="#contact" title=""><?php echo $lang['contact'] ?></a>

                    <li class="nav-item">

                        <a href="pages/login.php">
                            <button class="btn" id="btnLogin"><?php echo $lang['login'] ?></button>
                        </a>

                    <li class="nav-item">
                        <div class="dropdown">
                            <img src="img/<?php echo $lang['flag'] ?>" type="button" id="dropdownMenuButton"
                                 class="lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="?lang=fr"><img src="img/flag_fr.png"> French</a>
                                <a class="dropdown-item" href="?lang=en"><img src="img/flag_en.png"> English</a>
                            </div>
                        </div>
                       

                </ul>
            </div>
        </div>
    </nav>

    <div class="masthead"></div>

</header>

<section>

    <div class="container-fluid">

        <div class="AboutUs" id="who">
            <h3 class="text-center title"><?php echo $lang['who'] ?></h3>
            <hr class="hr">
        </div>


        <div class="row pt-5">

            <div class="col-md-6 p-0">
                <img src="img/test.jpg" class="img-fluid">
            </div>
            <div class="col-md-6 text-justify containAboutUs p-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>


        </div>


        <div class="row">

            <div class="col-md-6 text-justify containAboutUs p-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
            <div class="col-md-6 p-0">
                <img src="img/test.jpg" class="img-fluid">
            </div>
        </div>
    </div>


    </div>


</section>


<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">

                <h3 class="text-center title"><?php echo $lang['trust'] ?></h3>
                <hr class="hr">

                <p class=" text-justify p-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            </div>
            <div class="col-md-6">


                <h3 class="text-center title"><?php echo $lang['expertise'] ?></h3>
                <hr class="hr">

                <p class=" text-justify p-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            </div>
        </div>
    </div>

</section>


<section class="services" id="services">
    <div class="container pb-5">
        <h3 class="text-center title2"><?php echo $lang['our_services'] ?></h3>
        <hr class="hr">

        <div class="row pt-3">


            <div class="col-md-3">
                <img src="img/test.jpg" class="img-fluid">
                <div class="containService text-center">

                    <i class="fas fa-plane fa-2x icon" aria-hidden="true"></i>
                    <h5 class="pt-2"><?php echo $lang['travels'] ?></h5>
                    <p>Lorem ipsum ...</p>
                </div>

            </div>


            <div class="col-md-3">
                <img src="img/test.jpg" class="img-fluid">
                <div class="containService text-center">

                    <i class="fas fa-plane fa-2x icon" aria-hidden="true"></i>
                    <h5 class="pt-2"><?php echo $lang['travels'] ?></h5>
                    <p>Lorem ipsum ...</p>

                </div>

            </div>


            <div class="col-md-3">
                <img src="img/test.jpg" class="img-fluid">
                <div class="containService text-center">

                    <i class="fas fa-plane fa-2x icon" aria-hidden="true"></i>
                    <h5 class="pt-2"><?php echo $lang['travels'] ?></h5>
                    <p>Lorem ipsum ...</p>

                </div>

            </div>

            <div class="col-md-3">
                <img src="img/test.jpg" class="img-fluid">
                <div class="containService text-center">

                    <i class="fas fa-plane fa-2x icon" aria-hidden="true"></i>
                    <h5 class="pt-2"><?php echo $lang['travels'] ?></h5>
                    <p>Lorem ipsum ...</p>

                </div>

            </div>

        </div>


    </div>
</section>

<section class="contactUs" id="contact">

    <div class="container-fluid text-center">

        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 p-0">

                <div class="overlayContactUs">
                    <h3 class="text-center title2 "><?php echo $lang['contact_us'] ?></h3>
                    <hr class="hr">


                    <div class="pt-4">
                        <img class="logo" src="img/majordhome.png" title="logo" alt="Logo Majord'home">
                        <h5>Tel : 00.00.00.00.00</h5>
                        <h5><?php echo $lang['email_address'] ?> : Bob@hotmail.fr</h5>
                    </div>


                </div>

            </div>
        </div>

    </div>
</section>

<footer>

    <p class="text-center pt-4">Copyright © Majord'home 2020 - <?php echo date("Y"); ?></p>

</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>
