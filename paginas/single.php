<div id="single">
<script type="text/javascript" src="<?php echo $urlBase; ?>/js/shadowbox/shadowbox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $urlBase; ?>/js/shadowbox/shadowbox.css">
<script type="text/javascript">Shadowbox.init({language: 'pt',players:  ['img']});</script>
<?php
$poste = mysql_query("SELECT * FROM `tb_posts` WHERE `postSlug` = '$_ACTION' OR `postSlug` = '$_SUBCONTROLLER'");
while($resPoste=mysql_fetch_array($poste)){
	$postId = $resPoste['postId'];
	$visitas = $resPoste['postVisitas'];
?>
	<h1><?php echo $resPoste['postTitulo']; ?>
    <?php if(isset($_SESSION['usuarioLG_userEmail']) && $_SESSION['usuarioLG_userNivel'] === 'admin'){ 
		echo "| <a href=\"$urlBase/\" onclick=\"popUp(this.href,'nomeJanela','450','450','yes');return false\">Editar</a>";
	}?>
    </h1>
    <?php if(file_exists('upload/'.$resPoste['postThumb'])){ ?>
	<a title="<?php echo $resPoste['postTitulo']; ?>" href="<?php echo $urlBase; ?>/upload/<?php echo $resPoste['postThumb']; ?>" rel="shadowbox">
	<img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $resPoste['postThumb']; ?>&h=100&w=500&zc=1" alt="<?php echo $resPoste['postSlug']; ?>" width="500" height="100" border="0">
    </a>
    <?php } ?>
	<p><?php echo $resPoste['postTexto']; ?></p>
	  
	<?php
	$pegaLinks = mysql_query("SELECT * FROM `tb_linkdownload` WHERE `post` = '$postId'");
	$contarLinks = mysql_num_rows($pegaLinks);
	if($contarLinks > 0){
		$i=1;
		?>
		<div id="posteLinks">
		<span><?php echo $resPoste['postTitulo']; ?> esta disponível em <strong><?php echo $contarLinks; ?> parte<?php if($contarLinks>1){echo 's';} ?></strong>, Bom download!</span>
			<ol>
			<?php 
			while($respegaLinks = mysql_fetch_array($pegaLinks)){
				echo '<li><a target="blank" href="'.$respegaLinks['linkEndereco'].'">';
				if($contarLinks!==1){echo 'parte '.$i;}else{echo 'Download';}
				echo '</a>';
				echo '</li>';
				$i++;
			}
	} 
}
@mysql_query("UPDATE `tb_posts` SET `postVisitas` = postVisitas+1 WHERE postId = '$postId'"); 
?>
			</ol>
        </div><!--posteLinks-->
<script type="text/javascript">
$(function(){
	$("#posta_comentario").click(function(){
		var comentario = $("#comentario").val();
			comentario = $.trim(comentario);
		if(comentario != ''){
			$("#comentario").val('');
			//$("#form_comentarios").hide("slow");
			beforeSend:$("#aguarde").html('<p>Postando, aguarde...</p>');
			var id_do_poste = $("#id_do_poste").val();
			var autor_do_comentario = $("#autor_do_comentario").val();
			$.post("<?php echo $urlBase; ?>/php/comentar.php",{
				comentario: comentario,
				id_do_poste: id_do_poste,
				autor_do_comentario: autor_do_comentario,
				},function(pega_comentario){
				complete:$("#lista_comentarios ul").prepend(pega_comentario);
				$("li#semComent").fadeOut();
				$("#aguarde").fadeOut();
			});
		};
		
	});
});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		function showLoader(){
			$('.search-background').fadeIn(200);	
		}
		
		function hideLoader(){
			$('.search-background').fadeOut(200);	
		}
		
		$("#paging_button li").click(function(){
			showLoader();
			
			$("#paging_button li").css({'background-color' : ''});
			$(this).css({'background-color' : '#900'});
			
			$("#lista_comentarios").load("<?php echo $urlBase; ?>/php/comments.php?user=<?php echo $_SESSION['usuarioLG_userEmail']; ?>&post=<?php echo $postId; ?>&page=" + this.id, hideLoader);
			return false;	
		});
		
		$("#1").css({'background-color' : '#900'});
		showLoader();
		$("#lista_comentarios").load("<?php echo $urlBase; ?>/php/comments.php?user=<?php echo $_SESSION['usuarioLG_userEmail']; ?>&post=<?php echo $postId; ?>&page=1",hideLoader);
	});
</script>

<div id="single_comentarios" style="background:#666;">
<a name="comentarios"></a>
	<?php $rsd = mysql_query("select `comentId` FROM `tb_coments` WHERE `comentPostId` = '$postId'");
				$count = mysql_num_rows($rsd); ?>
	<span class="comentarios"><?php if($count>0){ echo $count.' - ';} ?>coment&aacute;rio<?php if($count>1){ echo 's';} ?></span>
	<hr style="margin-bottom:10px; width:100%;" />
	<div id="paging_button">
    	<ul>
        	<?php
				$per_page = 5;
				$page = ceil($count/$per_page);
				if($count>$per_page){
					for($i=1; $i<=$page; $i++){
						echo "<li id='".$i."'>".$i."</li>";	
					}
				}
			?>
        </ul>
    </div><!--paging_button-->
	<div id="lista_comentarios">
    </div><!--lista comentarios-->
    
    <div class="search-background">
    	<img src="<?php echo $urlBase; ?>/images/loader.gif" />
    </div>
    
	<?php if($userClass->usuarioLogado()){ ?> 
	<div id="aguarde"></div>
	<div id="form_comentarios">
    
	<label>deseja comentar?</label>
	<textarea rows="10" name="comentario" id="comentario"></textarea>
	<input type="hidden" name="id_do_poste" id="id_do_poste" value="<?php echo $postId; ?>" />
	<input type="hidden" name="autor_do_comentario" id="autor_do_comentario" value="<?php $userEmail = $_SESSION['usuarioLG_userEmail'];$pegaIdAutor=mysql_query("SELECT `userId` FROM `tb_users` WHERE `userEmail` = '$userEmail'") or die('erro aki');while($respegaIdAutor=mysql_fetch_array($pegaIdAutor)){echo $respegaIdAutor['userId'];} ?>" />
	<input type="button" id="posta_comentario" class="comentar_btn" value="comentar" />
	</div><!--form comntarios-->
    <?php } ?>
</div><!--single comentarios-->
</div><!--single-->