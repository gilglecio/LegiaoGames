<?php 
$id_do_poste = $_GET['post'];
$usuario_atual = $_GET['user'];
$pagina = $_GET['page'];
$start = ($pagina-1)*5;
include('model.php');
$pega_comentarios = mysql_query("SELECT * FROM `tb_coments` WHERE `comentPostId` = '$id_do_poste' ORDER BY `comentData` DESC LIMIT $start,5") or die(mysql_error());
$contar_comentarios = mysql_num_rows($pega_comentarios);

if($contar_comentarios <= 0){
	echo '<ul><li id="semComent">Nenhum coment&aacute;rio neste poste, ';
	if(isset($_SESSION['MM_Username'])){
		echo 'seja o primeiro '.$userNome.'!</li>';
	}else{
		echo 'fa&ccedil;a seu cadastro/login e seja o primeiro!</li></ul>';
	}
}else{
	echo '<ul>';
	while($respega_comentarios=mysql_fetch_array($pega_comentarios)){
		$autor_do_comentario = $respega_comentarios['comentAutor'];
		
		$pega_autor_pelo_comentario = mysql_query("SELECT * FROM `tb_users` WHERE `userId` = '$autor_do_comentario'");
		while($res_autor_coment = mysql_fetch_array($pega_autor_pelo_comentario)){	
			echo '<li>';
			echo '<img src="'.$urlBase.'/thumb.php?src='.$urlBase.'/upload/user/'.$res_autor_coment['userFoto'].'&h=40&w=40&zc=1" width="40" height="40"/>';
			echo '<span class="lista_coment_info"><strong>'.htmlentities(utf8_decode($res_autor_coment['userNome'])).'</strong> disse em <strong>'.date('d/m/y à\s H:i',strtotime($respega_comentarios['comentData'])).'h</strong> ';
			if($res_autor_coment['userEmail'] == $usuario_atual){
				echo '| <a onclick="return confirm(\'Tem certeza que deseja remover este comentário?\')" href="'.$urlBase.'/php/removerComentario.php?coment='.$respega_comentarios['comentId'].'">Remover</a>';
			}
			echo '</span>';
			echo '<p>'.$respega_comentarios['comentario'].'</p>';
			echo '</li>';
		}
	}
	echo '</ul>';
}

