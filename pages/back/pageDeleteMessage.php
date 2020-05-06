<?php 

require('headerBack.php');

//updateMsgAutomatic();

?>

<section class="container pt-4">

 
<div class="title text-center pt-1 pb-3">
	<h1>Centre de messagerie</h1>
	<hr class="hr">
	
</div>

	<div class="row block">
		<aside class="col-md-3">

			<div class="headerAside">
				
					<h6 class="h6"><?php echo $_SESSION['user']['nom']; ?></h6>
			<p class="p"><?php echo $_SESSION['user']['mail']; ?></p>
			</div>

			<div class="p-4">
			<button class="btn btn-primary btn-block" data-toggle='modal' data-target='#message'>Nouveau message <i class="far fa-1x fa-envelope"></i></button>
			</div>

			<div id="message" class="modal fade" role="dialog">
  				<div class="modal-dialog">

  
   					 <div class="modal-content">
					      <div class="modal-header">
					      	 <h4 class="modal-title">Nouveau message <i class="far fa-1x fa-envelope"></i></h4>
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					      </div>


					      <form method="POST" action="createMessage.php">
					      <div class="modal-body">
					      	
					      	<div class="form-group">
                                <label>Destinataire *</label>
                                <input type="email" placeholder="" name="to" class="form-control" required="required"> 
                            </div>

                            <div class="form-group">
                                <label>Titre *</label>
                                <input type="text" placeholder="" name="title" class="form-control" required="required"> 
                            </div>

                            <div class="form-group">
                                <label>Message *</label>
                               	<textarea class="form-control" name="message" rows="10" cols="30" required="required"></textarea>
                            </div>
                          
                        
					      </div>
					      <div class="modal-footer">
					      	<button type="button" class="btn btn-danger" data-dismiss="modal">Ignorer <i class="fas fa-trash"></i></button>
       						<button id="update" type="submit" class="btn btn-primary" >Envoyer <i class="fas fa-paper-plane"></i></button>
					      </div>

					        </form>
					    </div>

					  </div>
					</div>


			<ul class="ulMessage">


			
				<a href="messagesBack.php"><li class="liMessage "><i class="fas fa-inbox"></i> Boîte de réception</li></a>
				<a href="sendMessage.php"><li class="liMessage "><i class="fas fa-paper-plane"></i> Messages envoyés</li></a>
				<a href="pageArchiveMessage.php"><li class="liMessage"><i class="fas fa-archive"></i> Messages archivés</li></a>
				<a href="pageDeleteMessage.php"><li class="liMessage bg"><i class="fas fa-trash"></i> Corbeille</li></a>
			</ul>
		</aside>

		<div class="col-md-9 p-0">

			<div class="headInbox">
				
				<h6 class="h6">Messages supprimés</h6>
			</div>


			<div class="p-3">
	
				<div id="tab"></div>
			</div>
			

		</div>
		



	</div>
	

</section>

<script src="../../js/deleteMessage.js"></script>


<?php require "../footer.php"; ?>