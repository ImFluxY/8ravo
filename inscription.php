<?php
require_once('common.php');
require_once('./templates/begin.php');

if (isset($_SESSION['user'])) {
	error("Veuillez vous déconnecter avant de vous réinscrire.", "inscription.php");
}

if (isset($_POST['valider'])) {

	$allParamsPresent = isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['birthDate']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['cgu']);

	$prenom = $_POST['firstname'];
	$nom = $_POST['lastname'];
	$mail = $_POST['email'];
	$dateNaissance = $_POST['birthDate'];
	$mdp1 = $_POST['password1'];
	$mdp2 = $_POST['password2'];
	$cgu = $_POST['cgu'];

	if ($prenom === "" || $nom === "" || $mail === "" || $mdp1 === "" || $mdp2 === "" || $cgu === "") {
		error("Tous les champs doivent être remplis.", "inscription.php");
	}

	if ($mdp1 != $mdp2) {
		error("Les deux mots de passe ne sont pas identiques.", "inscription.php");
	}

	$mdplenght = mb_strlen($_POST['password1']);
	if ($mdplenght < 6) {
		error("Le mot de passe doit contenir au moins 6 caractères.", "inscription.php");
	}

	try {
		$cnx = new Base(BASE, USERNAME, PASSWORD);
		$lignes = $cnx->query('select * from users where email=?', array($mail));

		if (count($lignes) > 0) {
			error("Cette adresse mail est déjà utilisée.", "inscription.php");
		}

		$cnx->insert(
			"insert into users values (?,?,?,?,?,?,?,?,?,?) ",
			array(null, $prenom, $nom, $mail, $dateNaissance, sha1($mdp1), 0, 0, "./img/avatars/avatar_default.jpg",null)
		);
		$user = UserViewer::auth($mail, $mdp1);
		$_SESSION['user'] = $user;

		/// Envoi d'un mail pour avertir de l'incription
        $msg  =
            '
			<html>
				<div style="margin: 18px auto; display: flex; flex-direction: column; justify-content: center;">
					<img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/logo_mail_auto.png")).'" alt="logo 8ravo" style="width: 100px; margin: 20px auto;">
					<img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/illustration_8ravo.png")).'" alt="Illustration Bravo ordinateur et utilisateurs" style="width: 200px; margin: 25px auto;">
					<h1 style="font-size: 35px; color: #FF7F00; font-weight: bold; justify-self: center; margin: 20px auto">Bienvenue sur 8ravo, ' .$prenom.' !</h1>
					<p style="font-size: 20px; margin: 20px auto 0 auto; justify-self: center;">Vous venez juste de créer un compte sur 8ravo !</p>
					<p style="font-weight: 700; font-size: 20px; margin: 15px auto; justify-self: center;">Mais qu’est-ce que 8ravo ?</p>
					<p style="font-size: 20px; margin-top: 25px; margin: 0 auto; justify-self: center;">8ravo est un site d’apprentissage sur des sujets divers et variés, en seulement 8 étapes !</p>
					<p style="font-size: 20px; margin: 0 auto 25px auto; justify-self: center;">Vous pouvez découvrir des modules avec du texte, des vidéos, des audios et des quiz.</p>
					<a style="margin: 50px auto; text-align: center; padding: 10px 15px; background-color: #FF7F00; color: white; font-size: 20px; text-decoration: none; display: inline-block; justify-self: center;Z" href="https://la-projets.univ-lemans.fr/~mmi2pj03/index.php">Rejoindre le site</a>
				</div>
				<footer style="margin-top: 50px;">
					<p style="text-align: center; font-size: 16px; color: #D4D4D4">Ceci est un message automatique, merci de ne pas y répondre.</p>
				</footer>
			</html>
        ';

		$mail_8ravo = "projets-mmi@univ-lemans.fr";

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: 8ravo <' . $mail_8ravo . '>' . "\r\n";

        // use wordwrap() if lines are longer than 70 characters
        //$msg = wordwrap($msg, 70);
        // send email
        mail($mail, "Bienvenue sur 8ravo !", $msg, implode("\r\n", $headers));

		success("", "./index.php");
		header("Location: ./connexion.php");
	} catch (PDOException $e) {
		error("Un problème est survenu lors de votre inscription : " . $e->getMessage() . " " . $e->getTraceAsString(), 'inscription.php');
	}

	$db = null;
} else {
}

?>
	<link rel="stylesheet" href="./css/contact.css" type="text/css" />
	<link rel="stylesheet" href="./css/inscription.css" type="text/css" />
	<title> "Inscription - 8ravo"</title>
</head>

<body>
	<?php require_once('./templates/menu.php'); ?>
	<main>
		<section id="inscription" class="sectionInscription">
			<div class="divForm">
				<h2 class="title">Inscription</h2>
				<form action="" id="formulaire" class="contactForm" method="post">
					<div class="row firstRow">
						<div class="col">
							<label for="firstname">Prénom</label>
							<input class="inputContact" name="firstname" id="firstname" required type="text">
						</div>
						<div class="col">
							<label for="lastname">Nom</label>
							<input class="inputContact" name="lastname" id="lastname" required type="text">
						</div>
					</div>

					<div class="row">
						<div class="col">
							<label for="email">E-mail</label>
							<input class="inputContact" name="email" id="email" required type="email">
						</div>
						<div class="col">
							<label for="birthDate">Date de naissance</label>
							<input class="inputContact" name="birthDate" id="birthDate" required type="date">
						</div>
					</div>

					<div class="row">
						<div class="col">
							<label for="password1">Mot de passe</label>
							<input class="inputContact" type="password" id="password1" required name="password1" placeholder="Minimum 6 caractères">
						</div>
						<div class="col">
							<label for="password2">Confirmer le mot de passe</label>
							<input class="inputContact" type="password" id="password2" required name="password2">
						</div>
					</div>
					<div class="divCgu">
						<input class="cguCheckbox" type="checkbox" required name="cgu" id="cgu">
						<label class="cgu" for="cgu">J'accepte les <a class="lienCgu" href="./templates/mentions_legales.html">conditions
								générales d'utilisation</a></label>
					</div>

					<p class="dejaInscrit">Déjà inscrit? <a class="boldLink" href="connexion.php">Se
							connecter</a></p>
					<input class="btnInscription" type="submit" id="valider" name="valider" value="→ S'inscrire" />
					

					<?php
					require_once('./php/divErreur.php');
					?>
				</form>
			</div>
		</section>
	</main>
	<?php require_once('./templates/end.php'); ?>