<html>
	<head>
		<title> Page de Prélèvement de solvants </title>
	</head>
	<body>
	<h1>Prélevement de solvants</h1>	

	<!---code formulaire--->
	<script>
	function vider()
	{
		document.getElementById("volume").value = "";
		return false;
	};
	</script>
	<h2>Formulaire de prélèvement</h2>
	<form method="post" action="prelevement_solvant.php" name="formulaire" onreset="return vider()" >

		<select id="user" name='choix_user'>
		<option value="0">Choisir un utilisateur</option>
		<?php 
		$bdd = mysqli_connect('localhost','root','', 'dionisos');
		$requete1 = "SELECT DISTINCT nom, prenom, id_utilisateur FROM utilisateur  ORDER BY nom, prenom";
		$reponse1 = mysqli_query($bdd,$requete1);
		while($rep1=mysqli_fetch_array($reponse1)) {
			echo "<option value='".$rep1['id_utilisateur']."';>".$rep1['nom']." ".$rep1['prenom']."</option>";
		} 
		?>	
		</select>
		<br>
		<select id="preleve" name="choix_sol">
		<option value="0">Choisir un solvant</option>
		<?php
		$requete = "SELECT nom, id_solvant FROM solvant";
		$reponse2 = mysqli_query($bdd,$requete);		
		while($row= mysqli_fetch_array($reponse2)) {
			echo "<option value='".$row["id_solvant"]."'>".$row["nom"]."</option>";
		}					
		?>
		</select>
		<br>
		Entrez le volume prélevé : <input type="text" name="volume" value="Volume"/> <br/>
		<input type="submit" name="submit" value="Enregistrer">
		<input type="reset" name="cancel" id="reset" value="Effacer"/>
	<!---insertion dans la base--->
	<?php  
	if(isset($_POST['submit']))
	{
		$user = $_POST['choix_user'];
		$solvant = $_POST['choix_sol'];
		$volume = $_POST['volume'];
		$date = date("y-m-d");
		$sql0 = "INSERT INTO date_prelevement VALUES (NULL, '$user', '$solvant', '$date', '$volume')";
		mysqli_query ($bdd,$sql0) or die ('Erreur SQL 0! : '.$sql0.'<br />'.mysql_error());
		$sql1 = "UPDATE container,solvant SET container.volume_cont_encours = container.volume_cont_encours - '$volume' WHERE container.id_container = solvant.id_container AND solvant.id_solvant = $solvant";
		mysqli_query ($bdd,$sql1) or die ('Erreur SQL 1! : '.$sql1.'<br />'.mysql_error());		
		$sql2 = "UPDATE colonne, solvant SET colonne.volume_col_encours = colonne.volume_col_encours + '$volume' WHERE colonne.id_colonne = solvant.id_colonne AND solvant.id_solvant = $solvant ";
		mysqli_query ($bdd,$sql2) or die ('Erreur SQL 2! : '.$sql2.'<br />'.mysql_error());
		echo "Vous avez bien prélevé ".$volume." ml";
	}
	?>
	</form>
	<h3>Affichage du volume restant des containers de solvants </h3>
	<?php
		
		$sql = 'SELECT S.nom, C.date_remplissage, C.volume_cont_encours FROM container C, solvant S WHERE C.id_container=S.id_container ORDER BY S.nom';
		$req = mysqli_query($bdd,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		echo "<table border='1' cellpadding='0' style='text-align:center;'>";
		echo "<tr><th>SOLVANT</th>";
		echo "<th>DATE DERNIER REMPLISSAGE</th>";
		echo "<th> VOLUME RESTANT</th>";
		echo "</tr>";
		while($data = mysqli_fetch_array($req)){
		echo "<tr><td>".$data[0]."</td>";
		echo "<td>".$data[1]."</thd>";
		echo "<td>".$data[2]."</td>";
		echo "</tr>";
		}			
		echo "</table>";		
		mysqli_free_result ($req); 
		mysqli_close($bdd);		
		  
	?>
<button><a href="/dionisos/index.php">Retour</button>
	</body>
</html>	