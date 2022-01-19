<html>
<head>
	<title> Page d'administration</title>
</head>
<body>
	<h1>Analyse de la consommation</h1>

<!---affichage des consommation du jours--->
<h3>Dernier solvant prélevé</h3>
<?php
	$bdd = mysqli_connect('localhost','root','', 'dionisos');
	$sql = 'SELECT DISTINCT S.nom, U.prenom, U.nom, D.date_heure, D.volume FROM utilisateur U, date_prelevement D, solvant S WHERE S.id_solvant = D.id_solvant AND D.id_utilisateur = U.id_utilisateur ORDER BY D.date_heure = CURRENT_DATE DESC LIMIT 1';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'>NOM</th>";
	echo "<th style='marging: 20px'> PRENOM</th>";
	echo "<th style='marging: 20px'> DATE</th>";
	echo "<th style='marging: 20px'> VOLUME</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</td>";
	echo "<td>".$prelvmt[3]."</td>";
	echo "<td>".$prelvmt[4]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);
?> 
<!---affichage des consommations par jour--->
<?php
	date_default_timezone_set('UTC');
	$date_jour = date("F j, Y");
	echo "<h3>Consommation de la journée du $date_jour </h3>";
	$sql = 'SELECT S.nom, U.prenom, U.nom, D.date_heure, D.volume FROM utilisateur U, date_prelevement D, solvant S WHERE S.id_solvant = D.id_solvant AND D.id_utilisateur = U.id_utilisateur AND D.date_heure = CURRENT_DATE ORDER BY D.date_heure ASC';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'>NOM</th>";
	echo "<th style='marging: 20px'> PRENOM</th>";
	echo "<th style='marging: 20px'> DATE</th>";
	echo "<th style='marging: 20px'> VOLUME</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</td>";
	echo "<td>".$prelvmt[3]."</td>";
	echo "<td>".$prelvmt[4]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);
?> 

<!---affichage des consommations par semaine--->
<?php
	date_default_timezone_set('UTC');
	$date= new DateTime($date_jour);
	$semaine = $date->format("W");
	echo "<h3>Consommation de la semaine $semaine </h3>";
	$sql = 'SELECT S.nom, U.prenom, U.nom, D.date_heure, D.volume FROM utilisateur U, date_prelevement D, solvant S WHERE S.id_solvant = D.id_solvant AND D.id_utilisateur = U.id_utilisateur AND D.date_heure BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -7 DAY) AND CURRENT_DATE ORDER BY D.date_heure DESC ';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'>NOM</th>";
	echo "<th style='marging: 20px'> PRENOM</th>";
	echo "<th style='marging: 20px'> DATE</th>";
	echo "<th style='marging: 20px'> VOLUME</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</td>";
	echo "<td>".$prelvmt[3]."</td>";
	echo "<td>".$prelvmt[4]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);
 
?> 

<!---affichage des consommations par mois--->
<?php
	date_default_timezone_set('UTC');
	$mois = $date->format("M");

	echo "<h3>Consommation du mois de $mois </h3>";
	$sql = 'SELECT S.nom, U.prenom, U.nom, D.date_heure, D.volume FROM utilisateur U, date_prelevement D, solvant S WHERE S.id_solvant = D.id_solvant AND D.id_utilisateur = U.id_utilisateur AND D.date_heure BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -30 DAY) AND CURRENT_DATE ORDER BY D.date_heure DESC ';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'> PRENOM</th>";
	echo "<th style='marging: 20px'> NOM</th>";
	echo "<th style='marging: 20px'> DATE</th>";
	echo "<th style='marging: 20px'> VOLUME</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</td>";
	echo "<td>".$prelvmt[3]."</td>";
	echo "<td>".$prelvmt[4]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);

?> 

<!---affichage des consommation par equipes --->
<h3>Consommation par équipe sur une année</h3>
<?php

	$sql = 'SELECT SUM(DISTINCT D.volume), S.nom, U.equipe FROM date_prelevement D, solvant S, utilisateur U WHERE D.id_solvant=S.id_solvant AND D.id_utilisateur = U.id_utilisateur AND D.date_heure BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -365 DAY) AND CURRENT_DATE GROUP BY U.equipe, S.nom ';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>CONSOMMATION TOTALE</th>";
	echo "<th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'> EQUIPE</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);

?> 
<!---affichage des consommation par utilisateurs--->

<h3>Consommation par utilisateur</h3>
<?php

	$sql = 'SELECT SUM(DISTINCT D.volume), S.nom, U.prenom, U.nom FROM date_prelevement D, solvant S, utilisateur U WHERE D.id_solvant=S.id_solvant AND D.id_utilisateur= U.id_utilisateur AND D.date_heure BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -365 DAY) AND CURRENT_DATE GROUP BY U.prenom, U.nom';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>CONSOMMATION</th>";
	echo "<th style='marging: 20px'>SOLVANT</th>";
	echo "<th style='marging: 20px'>PRENOM</th>";
	echo "<th style='marging: 20px'>NOM</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</thd>";
	echo "<td>".$prelvmt[2]."</thd>";
	echo "<td>".$prelvmt[3]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req);
 
?> 
<!---affichage des consommation totale par solvants --->
<h3>Consommation totale des solvants sur une année</h3>
<?php
	$sql = 'SELECT SUM(D.volume), S.nom FROM date_prelevement D, solvant S WHERE D.id_solvant=S.id_solvant AND D.date_heure BETWEEN DATE_ADD(CURRENT_DATE, INTERVAL -365 DAY) AND CURRENT_DATE GROUP BY S.nom';
	$req = mysqli_query($bdd,$sql)  or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());;
	echo "<table border='1' cellpadding='0' style='text-align:center;'>";
	echo "<tr ><th style='marging: 20px'>CONSOMMATION</th>";
	echo "<th style='marging: 20px'>SOLVANT</th>";
	echo "</tr>";
	while($prelvmt = mysqli_fetch_array($req)){
	echo "<tr><td>".$prelvmt[0]."</td>";
	echo "<td>".$prelvmt[1]."</td></tr>";
}			
	echo "</table>";		
	mysqli_free_result ($req); 
	mysqli_close ($bdd); 
?>
<button><a href="/dionisos/index.php">Retour</button>
</body>
</html>	