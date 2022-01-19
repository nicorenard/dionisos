<?php
$user='root';
$pass='';
$host='localhost';
$cmd='C:\wamp64\bin\mariadb\mariadb10.4.22\bin\mysql --user='.$user.' --password='.$pass .' --host='.$host .' dionisos < C:\wamp64\www\dionisos\DB_import\database_backup.sql';
//var_dump($cmd);exit;
exec($cmd, $output, $return);
if ($return != 0) { //0 is ok
die('Error: ' . implode("\r\n", $output));
}echo "importation effectuée, appuyez sur retour.";
?>



 <button><a href="/dionisos/index.php">Retour</button>