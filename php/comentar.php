<?php include("model.php");

$id_do_poste = $_POST['id_do_poste'];
$autorId = $_POST['autor_do_comentario'];

$data = date('Y-m-d H:i:s');
$comentario = strip_tags(trim($_POST['comentario']));
$comentario = mysql_real_escape_string($comentario);
if($comentario !== '' && $autorId !== ''){
	$comentar = mysql_query("INSERT INTO `tb_coments` (comentPostId,comentAutor,comentData,comentario) VALUES ('$id_do_poste','$autorId','$data','$comentario')") or die ('<li>Sistema indisponível no momento. Tente mais tarde!</li>');
	$comentarioId = mysql_insert_id();
	if($comentar > 0){
		$sqlAutor=mysql_query("SELECT `userFoto`,`userNome` FROM `tb_users` WHERE `userId` = '$autorId'");
		while($resAutor=mysql_fetch_array($sqlAutor)){
			echo '<li>';
			echo '<img src="'.$urlBase.'/thumb.php?src='.$urlBase.'/upload/user/'.$resAutor['userFoto'].'&h=40&w=40&zc=1" width="40" height="40"/>';
			echo '<span class="lista_coment_info"><strong>'.$resAutor['userNome'].'</strong> disse em <strong>'.date('d/m/y à\s H:i').'h</strong> ';
			echo '| <a onclick="return confirm(\'Tem certeza que deseja remover este comentário?\')" href="'.$urlBase.'/php/removerComentario.php?coment='.$comentarioId.'">Remover</a>';
			echo '</span>';
			echo '<p>'.$comentario.'</p>';
			echo '</li>';
		}
	}else{
		echo '<li>Sistema indisponível no momento. Tente mais tarde!</li>';
	}
}
?>
