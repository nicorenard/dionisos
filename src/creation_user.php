<html>
<head>
	<title> Creation de compte</title>
</head>
<body>
	<h1>Création de compte utilisateurs</h1>
	<script>
function vider()
{
	document.getElementById("prenom").value = "";
	document.getElementById("nom").value = "";
	document.getElementById("equipe").value = "";
	return false;
};
</script>
<!---code php - formulaire--->
<h2>Entrez les données de création de compte :</h2>
<form method="post" action="creation_user.php" name="Création de compte utilisateur" onreset="return vider()" >
Entrer un nom : <input type="text" name="nom" value="Nom" required="required"/> <br/>
Entrer un prénom : <input type="text" name="prenom" value="Prénom" required="required"/> <br/>
Entrer une équipe : <input type="text" name="equipe" value="Equipe" required="required"/> <br/>
<input type="submit" name="submit" value="Enregistrer"/>
<input type="reset" name="cancel" id="reset" value="Effacer"/>
</form>
<!---insertion dans la base---->
<?php  
if(isset($_POST['submit'])){
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$equipe = $_POST['equipe'];
	$today = date("y.m.d");
	$bdd = mysqli_connect('localhost','root','');
	mysqli_select_db($bdd, 'dionisos');
	$sql = "INSERT INTO utilisateur VALUES (NULL, '$nom', '$prenom', '$equipe', '$today')";
	mysqli_query ($bdd,$sql) or die ('Erreur SQL ! : '.$sql.'<br />'.mysql_error());
	mysqli_close($bdd);
}
?>
<!--- affichage des comptes users--->
<h2>Comptes utilisateurs enregistrés</h2>
<?php
$bdd = mysqli_connect('localhost','root','', dionisos);
mysqli_select_db($bdd, 'dionisos');
$sql = 'SELECT * FROM utilisateur ORDER BY nom';
$req = mysqli_query($bdd,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
echo "<table border='1' cellpadding='0' style='text-align:center;'>";
echo "<tr><th>NOM</th>";
echo "<th>PRENOM</th>";
echo "<th> EQUIPE</th>";
echo "<th> DATE DE CREATION</th>";
echo "</tr>";
while($data = mysqli_fetch_array($req)){
echo "<tr><td>".$data[1]."</td>";
echo "<td>".$data[2]."</thd>";
echo "<td>".$data[3]."</td>";
echo "<td>".$data[4]."</td>";
echo "</tr>";
}			
echo "</table>";		
mysqli_free_result ($req);  
mysqli_close ($bdd);  
  ?>
<!---affichage des administrateurs--->
<h2>Administrateurs des machines</h2>
<?php
$bdd = mysqli_connect('localhost','root','');
mysqli_select_db($bdd, 'dionisos');
$sql = 'SELECT U.nom, U.prenom, M.nom FROM utilisateur U,responsable R,machine M WHERE U.id_utilisateur= R.id_utilisateur AND R.role_admin="1" ORDER BY M.nom, U.nom, U.prenom';
$req = mysqli_query($bdd,$sql);
echo "<table border='1' cellpadding='0' style='text-align:center;'>";
echo "<tr ><th style='marging: 20px'>NOM</th>";
echo "<th style='marging: 20px'>PRENOM</th>";
echo "<th style='marging: 20px'> MACHINE</th>";
echo "</tr>";
while($data_admin = mysqli_fetch_array($req)){
echo "<tr><td>".$data_admin[0]."</td>";
echo "<td>".$data_admin[1]."</thd>";
echo "<td>".$data_admin[2]."</td></tr>";
}			
echo "</table>";		
mysqli_free_result ($req);  
mysqli_close ($bdd);  
  ?>
  <br>
<button><a href="/dionisos/index.php">Retour</button>
</body>
</html>