<?php if(isset($_GET['coment'])){
	include('model.php');
	$comentId = (int)$_GET['coment'];
	$delComent = mysql_query("DELETE FROM `tb_coments` WHERE `comentId` = '$comentId'") or die('Sistema indisponível: '.mysql_error());
	header('Location: '.$_SERVER['HTTP_REFERER'].'#comentarios');
	//echo '<script>history.back();
}