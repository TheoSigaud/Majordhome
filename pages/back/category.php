<?php require('headerBack.php'); ?>



<section>


<div id="information"></div>


<div class="title text-center pt-5">
	<h1>Gestion des catégories</h1>
	<hr class="hr">
</div>

<div class="container pt-4">
	
	<div class="row">
		
		<div class="col-md-6">
			
			<div class="title pb-4">
				
				<h4>Liste des catégories</h4>
				
			</div>

			<div id="table"></div>

		</div>
		<div class="col-md-6 pt-2">
			

			<div class="form">

			<div class="title pb-3">
		
				<h4>Créer une catégorie</h4>
				
			</div>

			 
   
    

        <div class="form-group">
            <label for="inputEmail">Nom *</label>
            <input name="name" type="text" id="name" class="form-control" placeholder="Voyage" required="required">
        </div>

        <div class="form-group">
            <label for="pwd">Description </label>
            <textarea name="description"  id="description" class="form-control" placeholder="Voyage "></textarea>
        </div>


    <i class="p-2">* Champs obligatoires</i>
   
        <center><button class="btn mt-3 btnCategory btn-block" onclick="createCategory();">Créer une catégorie</button></center>

        </div>
 
    </div>
		</div>

	</div>


</div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
        <!-- <h4 class="modal-title">Modification</h4> -->
        <i class='fas fa-2x fa-edit'></i>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
       <div class="form-group">
       	
       	<label>Nom *</label>
       	<input type="text" id="updateName" class="form-control" required="required" placeholder="Voyage">
       </div>

        <div class="form-group">
       	
       	<label>Description</label>
       	<textarea type="text" id="updateDescription" class="form-control" placeholder="Voyage ..."></textarea>

       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        <button id="update" type="button" class="btn btn-primary" data-dismiss="modal">Modifier</button>
      </div>
    </div>

  </div>
</div>

<div id="modalDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>Etes-vous sûr de vouloir supprimer cette catégorie ?</p>
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button id="btnDelete" class="btn btn-danger" data-dismiss="modal">Supprimer</button>
      </div>
    </div>

  </div>
</div>




</section>


















<script src="../../js/category.js"></script>

<?php
require "../footer.php";
?>