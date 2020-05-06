<?php
require('header.php');


if (isset($_POST['pwd']) && isset($_POST['pwd2'])) {
	
	$queryPrepared = $connect->prepare('SELECT mdp FROM personne WHERE mail = :email');
	$queryPrepared->execute([':email' => $_SESSION['user']['mail']]);
	$pwd = $queryPrepared->fetch();


	if (password_verify($_POST['pwd'],$pwd['mdp'])) {
		
		if ($_POST['pwd2'] == $_POST['pwd3']) {
	
			$pwdHash = password_hash($_POST['pwd2'],PASSWORD_DEFAULT);

			$queryPrepared = $connect->prepare('UPDATE personne SET mdp = :pwd WHERE mail = :mail');
			$queryPrepared->execute([":pwd" => $pwdHash, ":mail" => $_SESSION['user']['mail'] ]);


			$_SESSION['updateSuccess'] = 'Mot de passe modifié !';

		}else{

			$_SESSION['errorPwd'] = "La confirmation de votre mot de passe ne correspond pas à votre mot de passe.";
		}

	}else{

		$_SESSION['errorPwd'] = "Erreur ancien mot de passe";
	}
}
?>

<section>
	

	 <?php 

      if(!empty($_SESSION["updateSuccess"])){
            echo "<div class='alert alert-success'>";
              
                echo "<li>".$_SESSION['updateSuccess'];
                  
                    echo "</div>";
            unset($_SESSION["updateSuccess"]);
            }

        if(!empty($_SESSION["errorPwd"])){
            echo "<div class='alert alert-danger'>";
              
                echo "<li>".$_SESSION['errorPwd'];
                  
                    echo "</div>";
            unset($_SESSION["errorPwd"]);
            }

   ?>

	 <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5">Mon compte</h1>
        <hr class="hr">
    </div>



<div class="container borderSubscription">

	<button class="btn btn-danger mt-0 mb-3" data-toggle='modal' data-target='#password'>Changer de mot de passe</button>


	<div id="password" class="modal fade" role="dialog">
  				<div class="modal-dialog">

  
   					 <div class="modal-content">
					      <div class="modal-header">
					      	 <h4 class="modal-title">Nouveau mot de passe</h4>
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					      </div>

					      <form method="POST" action="myAccount.php">
					      <div class="modal-body">
			

                            <div class="form-group">
                                <label>Ancien mot de passe *</label>
                                <input type="password" placeholder="******" name="pwd" class="form-control" required="required"> 
                            </div>

                            <div class="form-group">
                                <label>Nouveau mot de passe *</label>
                               	<input type="password" class="form-control" name="pwd2" required="required">
                            </div>
                          

                            <div class="form-group">
                                <label>Confirmation de votre nouveau mot de passe *</label>
                               	<input type="password" class="form-control" name="pwd3" required="required">
                            </div>
                          
                        
					      </div>
					      <div class="modal-footer">
					      	<button type="button" class="btn btn-danger" data-dismiss="modal">Ignorer <i class="fas fa-trash"></i></button>
       						<button id="update" type="submit" class="btn btn-primary" >Changer <i class="fas fa-paper-plane"></i></button>
					      </div>

					        </form>
					    </div>

					  </div>
					</div>



	<form method="POST" action="updateAccount.php" >
    <div class="row">

     	<div class="col-md-6">
           
	        <div class="form-group">
	            <label for="">Nom *</label>
	            <input name="lastName" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['nom'] ?>" required="required">
	        </div>
	    </div>

       <div class="col-md-6">
           
	        <div class="form-group">
	            <label for="firstName">Prénom *</label>
	            <input name="firstName" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['prenom'] ?>" required="required">
	        </div>
	    </div>

	    <div class="col-md-12">
           
	        <div class="form-group">
	            <label for="">Email *</label>
	            <input name="email" type="email" id="" class="form-control" value="<?php echo $_SESSION['user']['mail'] ?>" required="required">
	        </div>
	    </div>

	    <div class="col-md-6">
           
	        <div class="form-group">
	            <label for="">Date de naissance *</label>
	            <input name="date" type="date" id="" class="form-control" value="<?php echo $_SESSION['user']['dateNaissance'] ?>" required="required">
	        </div>
	    </div>

	     <div class="col-md-6">
           
	        <div class="form-group">
	            <label for="">Téléphone *</label>
	            <input name="phone" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['telephone'] ?>"required="required">
	        </div>
	    </div>

	     <div class="col-md-12">
           
	        <div class="form-group">
	            <label for="">Adresse *</label>
	            <input name="address" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['adresse'] ?>" required="required">
	        </div>
	    </div>


	    <div class="col-md-6">
           
	        <div class="form-group">
	            <label for="">Ville *</label>
	            <input name="city" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['ville'] ?>" required="required">
	        </div>
	    </div>

	     <div class="col-md-6">
           
	        <div class="form-group">
	            <label for="">Code postal *</label>
	            <input name="code" type="text" id="" class="form-control" value="<?php echo $_SESSION['user']['codePostal'] ?>" required="required">
	        </div>
	    </div>

        
    </div>
            
      	<input type="submit" class="btn btn-success area" value="Modifier mon compte">


      </form>

</div>



</section>






































<?php
require "../footer.php";
?>