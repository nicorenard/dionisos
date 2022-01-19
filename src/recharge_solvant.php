<html>
<head>
	<title> Page d'administration - Maintenance</title>
</head>
<body>
	<h1>Page d'administration des Maintenances Machines</h1>

<!---Choisir dans un formulaire préremplit le solvant et lui remettre le container aux max ou pas--->
<script>
function vider()
{
	document.getElementById("volume").value = "";
	return false;
};
</script>
<h2>Formulaire de recharge de solvant :</h2>

	<form method="post" action="recharge_solvant.php" name="formulaire" onreset="return vider()" >
		<select id="recharge" name="choix_sol">
		<option value="0">Choisir le solvant</option>
		<?php
		$bdd = mysqli_connect('localhost','root','', 'dionisos');
		$requete = "SELECT nom, id_solvant FROM solvant";
		$reponse = mysqli_query($bdd,$requete);		
		while($row= mysqli_fetch_array($reponse)) {
			echo "<option value='".$row["id_solvant"]."'>".$row["nom"]."</option>";
		}					
		?>
		</select>
		<br>
		Entrez le volume à recharger : <input type="text" name="volume" value="Volume"/> <br/>
		<input type="submit" name="submit" value="Enregistrer">
		<input type="reset" name="cancel" id="reset" value="Effacer"/>
<!---insertion dans la base---->
<?php  
if(isset($_POST['submit'])){
	$solvant = $_POST['choix_sol'];
	$volume = $_POST['volume'];
	$date = date("y-m-d");
	$sql = "UPDATE container, solvant SET container.volume_cont_encours = container.volume_cont_encours + '$volume', container.date_remplissage = CURRENT_DATE WHERE container.id_container = solvant.id_solvant AND solvant.id_solvant = $solvant"; 
	if (mysqli_query($bdd, $sql)) {
		echo "La recharge du container a été prise en compte.";
		} else {
		echo "Erreur l'update à échoué: " . mysqli_error($bdd);
		}
}
?>
</form>

	<h2>Maintenance : Etat des Machines</h2>
<?php
$sql = 'SELECT * FROM machine';
$req = mysqli_query($bdd,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
echo "<table border='1' cellpadding='0' style='text-align:center;'>";
echo "<tr><th>NOM</th>";
echo "<th>NUMERO DE SERIE</th>";
echo "<th>COLONNES TOTALE MACHINE</th>";
echo "<th>COLONNES INACTIVES</th>";
echo "<th>COLONNES ACTIVES</th>";
echo "</tr>";
while($data1 = mysqli_fetch_array($req)){
echo "<tr><td>".$data1[1]."</td>";
echo "<td>".$data1[2]."</thd>";
echo "<td>".$data1[3]."</td>";
echo "<td>".$data1[4]."</td>";
echo "<td>".$data1[5]."</td>";
echo "</tr>";
}			
echo "</table>";		
mysqli_free_result ($req);  
?>

	<h2>Maintenance : Etat des colonnes et Containers ACTIFS</h2>
<!---affichage des colonnes et containers de chaque machine + niveau solvant consommé/purifié--->
	<?php
$sql = 'SELECT M.nom, S.nom, C.date_remplissage, C.volume_cont_encours, Co.nom, Co.mise_en_service ,Co.volume_col_encours FROM container C, solvant S, colonne Co, machine M WHERE C.id_container=S.id_container AND Co.id_colonne = S.id_colonne AND M.id_machine = C.id_machine ORDER BY C.id_machine, S.nom';
$req = mysqli_query($bdd,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
echo "<table border='1' cellpadding='0' style='text-align:center;'>";
echo "<tr><th>MACHINE</th>";
echo "<th></th>";
echo "<th>SOLVANT</th>";
echo "<th>DATE REMPLISSAGE CONTAINER</th>";
echo "<th> VOLUME RESTANT</th>";
echo "<th></th>";
echo "<th>NOM COLONNE</th>";
echo "<th>MISE EN SERVICE</th>";
echo "<th>VOLUME PURIFIE</th>";
echo "</tr>";
while($data1 = mysqli_fetch_array($req)){
echo "<tr><td>".$data1[0]."</td>";
echo "<td></td>";
echo "<td>".$data1[1]."</thd>";
echo "<td>".$data1[2]."</td>";
echo "<td>".$data1[3]."</td>";
echo "<td></td>";
echo "<td>".$data1[4]."</td>";
echo "<td>".$data1[5]."</td>";
echo "<td>".$data1[6]."</td>";
echo "</tr>";
}			
echo "</table>";		
mysqli_free_result ($req);  
mysqli_close ($bdd);  
  ?>
<button><a href="/dionisos/index.php">Retour</button>
</body>
</html>	