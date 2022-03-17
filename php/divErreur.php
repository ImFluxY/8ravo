<!-- div contenant le message d'erreur
     Cette div est cachée par défaut, mais quand  on appelle les fonctions global error ou success -->
<div class="errorMessage" id='erreur' style='display: none'>
	<?php
	if (isset($_SESSION['erreur'])) {
		echo $_SESSION['erreur'];
		unset($_SESSION['erreur']);
		echo "<script type='text/javascript'>divErr=document.getElementById(\"erreur\"); divErr.style.display=\"block\";</script>";
	}

	if (isset($_SESSION['success'])) {
		echo $_SESSION['success'];
		unset($_SESSION['success']);
		echo "<script type='text/javascript'>divErr=document.getElementById(\"erreur\"); divErr.style.display=\"block\";</script>";
	}
	?>
</div>