
<?php
include('php/model.php');
$poste = mysql_query("SELECT `postTitulo`,`postId` FROM `tb_posts`");
$postesTotal = mysql_num_rows($poste);
$tagCloud = array();

while($resPostes = mysql_fetch_array($poste)){
	$Atitulo = explode(' ',$resPostes[0]);
	$postId = $resPostes[1];
	$i=0;
	if(strlen($Atitulo[$i])<4){
		unset($Atitulo[$i]);
	}
	$tags = $Atitulo[$i];
	$i++;
	mysql_query("UPDATE `tb_posts` SET `postTags` = '$tags' WHERE `postId` = '$postId'");
}
?>
