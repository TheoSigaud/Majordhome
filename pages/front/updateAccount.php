<?php
require('../functions.php');
$connect = connectDb();

session_start();

if(count($_POST) == 8
    && !empty($_POST['firstName'])
    && !empty($_POST['lastName'])
    && !empty($_POST['email'])
    && !empty($_POST['date'])
    && !empty($_POST['phone'])
    && !empty($_POST['address'])
    && !empty($_POST['city'])
    && !empty($_POST['code'])
   
){



        $email = trim($_POST['email']);
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $phone = trim($_POST['phone']);
        $code = trim($_POST['code']);
        $birthday = trim($_POST['date']);

        $address = $_POST['address'];
        $city = $_POST['city'];

        $errors = [];

      

        if(!preg_match('/^[a-zA-Z0-9_éçèàôùîï]+$/', $lastName)) {
            $errors['lastName'] = "Le nom que vous avez indiqué n'est pas valide.";
        }

        if(!preg_match('/^[a-zA-Z0-9_éçèàôùîï]+$/', $firstName)) {
            $errors['firstName'] = "Le prénom que vous avez indiqué n'est pas valide.";
        }


        if ($email != $_SESSION['user']['mail']) {
        	

        if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email que vous avez indiqué n'est pas valide.";
        } else {



            $req = $connect->prepare("SELECT idPersonne FROM personne WHERE mail = :mail");
            $req->execute([":mail" => $email]);
           
            if (!empty($req->fetchAll())) {
                
                $errors['email']= "Email déjà existant";
            }
       }

   }

        if(strlen($phone) != 10
            || !preg_match('/^[0-9_]+$/', $phone)) {
            $errors['phone'] = "Le numéro de téléphone que vous avez indiqué n'est pas valide.";
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


        if(empty($errors)) {
        

            $connect = connectDb();

            $queryPrepared = $connect->prepare("UPDATE personne SET nom = :nom, prenom = :prenom, mail = :mail, dateNaissance = :dateNaissance, telephone = :tel, adresse = :adresse, ville = :ville, codePostal = :codePostal WHERE idPersonne = :id");

            $queryPrepared->execute([

                    ":nom"=>$lastName, 
                    ":prenom"=>$firstName, 
                    ":mail"=>$email, 
                    ":dateNaissance"=>$birthday,
                    ":tel"=>$phone,
                    ":adresse"=>$address,
                    ":ville"=>$city,
                    ":codePostal"=>$code,
                    ":id"=>$_SESSION['user']['idPersonne']
                  

                ]);


            $_SESSION['user']['nom'] = $lastName;
            $_SESSION['user']['prenom'] = $firstName;
            $_SESSION['user']['mail'] = $email;
            $_SESSION['user']['dateNaissance'] = $birthday;
            $_SESSION['user']['telephone'] = $phone;
            $_SESSION['user']['adresse'] = $address;
            $_SESSION['user']['ville'] = $city;
            $_SESSION['user']['codePostal'] = $code;

             $_SESSION["updateSuccess"] = "Votre profil a bien été modifié !";



            header("Location: myAccount.php");
        }

        if (!empty($errors)){
            $_SESSION["errorsFormAuth"] = $errors;
            header("Location: myAccount.php");
        }
}
