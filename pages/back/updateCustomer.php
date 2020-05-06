<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3)) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();


$id = $_SESSION['id'];
unset($_SESSION["id"]);





if(count($_POST) == 9
    && !empty($_POST['firstName'])
    && !empty($_POST['lastName'])
    && !empty($_POST['email'])
    && !empty($_POST['date'])
    && !empty($_POST['phone'])
    && !empty($_POST['address'])
    && !empty($_POST['city'])
    && !empty($_POST['code'])
    && !empty($_POST['pwd'])
    && ($_POST['pwd'] == 'no' || $_POST['pwd'] == 'yes')
){


    $email = trim($_POST['email']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phone = trim($_POST['phone']);
    $code = trim($_POST['code']);
    $birthday = trim($_POST['date']);
    $pwdSelect = trim($_POST['pwd']);

    $address = $_POST['address'];
    $city = $_POST['city'];

    $errors = [];




    if(!preg_match('/^[a-zA-Z0-9_éçèàôùîï]+$/', $lastName)) {
        $errors['lastName'] = "Le nom que vous avez indiqué n'est pas valide.";
    }

    if(!preg_match('/^[a-zA-Z0-9_éçèàôùîï]+$/', $firstName)) {
        $errors['firstName'] = "Le prénom que vous avez indiqué n'est pas valide.";
    }

    if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email que vous avez indiqué n'est pas valide.";
    } else {


        $req = $connect->prepare("SELECT id FROM personne WHERE mail = :mail");
        $req->execute([":mail" => $email]);

        if (!empty($req->fetchAll())) {

            $errors['email']= "Email déjà existant";
        }
    }



    if(strlen($phone) != 10
        || !preg_match('/^[0-9_]+$/', $phone)) {
        $errors['phone'] = "Le numéro de téléphone que vous avez indiqué n'est pas valide.";
    } else {
        $req = $connect->prepare('SELECT id FROM personne WHERE telephone = :tel');
        $req->execute([":tel"=>$phone]);

        if (!empty($req->fetchAll())) {

            $errors['phone'] = "Ce numéro de téléphone est déjà utilisé.";
        }
    }


    if(strlen($code) != 5 || !preg_match('/^[0-9_]+$/', $code)) {
        $errors['code'] = "Le code postal que vous avez indiqué n'est pas valide.";
    }

    //Date de naissance entre 18ans et 120ans
    if (!preg_match("#\d{4}-\d{2}-\d{2}#", $birthday)){
        $errors[] = " Votre date de naissance doit être au format YYYY-MM-DD";
    }else{

        //Je dois mettre dans des variables le mois le jour et l'année
        $birthdayExploded = explode("-", $birthday);

        //Time correspond au nombre de secondes depuis 1 Jan 1970
        //
        //
        $secondeLife = time() - strtotime($birthday);
        $yearLife = $secondeLife/3600/24/365.242;

        if( !checkdate($birthdayExploded[1], $birthdayExploded[2], $birthdayExploded[0])  ){
            $errors[] = "Votre date de naissance n'existe pas";
        }else if ($yearLife<18 || $yearLife>120) {
            $errors[] = " Vous être trop jeunes ou trop vieux";
        }
    }


    function pwdGenerator($numberCaracteres, $string = 'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789*!?%&@#')
    {
        $numberLetters = strlen($string) - 1;
        $generation = '';
        for($i=0; $i < $numberCaracteres; $i++)
        {
            $pos = mt_rand(0, $numberLetters);
            $caractere = $string[$pos];
            $generation .= $caractere;
        }
        return $generation;
    }


    if(empty($errors)) {
        $confirm[] = "Le client a bien été modifié";
        $_SESSION["confirmFormAuth"] = $confirm;




        if ($pwdSelect == 'no') {

            $req = $connect->prepare("UPDATE personne set prenom =:prenom, nom =:nom, mail =:mail, dateNaissance =:dateNaissance, adresse =:adresse, ville =:ville, codePostal =:codePostal, telephone =:telephone WHERE idPersonne =:id;");
            $req->execute([':nom' => $lastName,
                ':prenom' => $firstName,
                ':mail' => $email,
                ':dateNaissance' => $birthday,
                ':adresse' => $address,
                ':ville' => $city,
                ':codePostal' => $code,
                ':telephone' => $phone,
                ':id' => $id
            ]);

        }else if ($pwdSelect == 'yes') {

            $pwd = pwdGenerator(15);

            $header="MIME-Version: 1.0\r\n";
            $header.='From: "Contact Majordhome"<contact@majordhome.fr>'."\n";
            $header.='Content-Type:text/html; charset="uft-8"'."\n";
            $header.='Content-Transfer-Encoding: 8bit';

            $message="
            <html>
                <body>
                  <h3>Modification du compte de ".$firstName." ".$lastName."</h3>
                  <p>Votre nouveau mot de passe est: </p><strong>".$pwd."</strong>
                </body>
            </html>
           ";

            mail($email, "Bienvenue", $message, $header);

            $pwd = hash("sha256", $pwd);


            $req = $connect->prepare("UPDATE personne set prenom =:prenom, nom =:nom, mail =:mail, dateNaissance =:dateNaissance, adresse =:adresse, ville =:ville, codePostal =:codePostal, telephone =:telephone, mdp =:mdp WHERE idPersonne =:id;");
            $req->execute([':nom' => $lastName,
                ':prenom' => $firstName,
                ':mail' => $email,
                ':dateNaissance' => $birthday,
                ':adresse' => $address,
                ':ville' => $city,
                ':codePostal' => $code,
                ':telephone' => $phone,
                ':id' => $id,
                ':mdp'=> $pwd
            ]);
        }



        header("Location: customer.php");
    }

    if (!empty($errors)){
        $_SESSION["errorsFormAuth"] = $errors;
        unset($_POST["pwd"]);
        unset($_POST["pwdConfirm"]);
        $_SESSION["dataFormAuth"] = $_POST;
        header("Location: modificationCustomer.php?id=$id");
    }
}else{
    $Hack[] = "Tentative de hack detectée";
    $_SESSION["hackFormAuth"] = $Hack;
    unset($_POST["pwd"]);
    unset($_POST["pwdConfirm"]);
    $_SESSION["dataFormAuth"] = $_POST;
    header("Location: modificationCustomer.php?id=$id");
}