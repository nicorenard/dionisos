<?php
$user='root';
$pass='';
$host='localhost';

$cmd='C:\wamp64\bin\mariadb\mariadb10.4.22\bin\mysqldump --user='.$user.' --password='.$pass .' --host='.$host .' dionisos > C:\wamp64\www\dionisos\DB_save\database_backup_'.date('G_a_m_d_y').'.sql';
//var_dump($cmd);exit;
exec($cmd, $output, $return);

if ($return != 0) { //0 is ok
    die('Error: ' . implode("\r\n", $output));
}

echo "Sauvegarde effectuée, appuyez sur retour.";

?>
<br>
 <button><a href="/dionisos/index.php">Retour</button>