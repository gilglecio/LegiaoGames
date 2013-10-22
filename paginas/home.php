<div id="home">
	<?php
	$SQLTestThumb = mysql_query("SELECT `postThumb` FROM `tb_posts` ORDER BY `postData` DESC LIMIT 5,15");
	$acrescentar = 0;
	while($resultThumb = mysql_fetch_array($SQLTestThumb)){
		if(!file_exists('upload/'.$resultThumb[0])){
			$acrescentar++;		
		}
	}
	?>  
    
    <ul id="lista-home">
	<?php $limite = 12 + $acrescentar;
	$SQL = mysql_query("SELECT * FROM `tb_posts` ORDER BY `postData` DESC LIMIT 5,$limite") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
	while($result = mysql_fetch_array($SQL)){
		$postCategoria=$result['postCategoria'];
		$postSlug=$result['postSlug'];
		$postId=$result['postId'];
		$postThumb= $result['postThumb'];
	
	if(file_exists('upload/'.$postThumb)){ ?>
        <li>
        <a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>">
        <img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $result['postThumb']; ?>&h=150&w=200&zc=1" alt="<?php echo $result['postSlug']; ?>" width="200" height="150" border="0" />
        </a>
		
        <h5><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>"><?php echo $result['postTitulo']; ?></a></h5>
        </li>
        <?php } ?>
    <?php } ?>    
    </ul>   
    
    <div id="ultimos-comentarios">
    <span class="descricao">Ultimos coméntarios</span>
        <ul>
			<?php
			$SQLCommnets = mysql_query("SELECT * FROM `tb_coments` ORDER BY `comentario` ASC LIMIT 5");
				$contarComments = mysql_num_rows($SQLCommnets);
				if($contarComments > 0){
					while($resComments=mysql_fetch_array($SQLCommnets)){
						$autorIdComent = $resComments['comentAutor'];
						$postIdComent = $resComments['comentPostId'];
						
						$selTituloPosComent = mysql_query("SELECT `postTitulo`,`postSlug`,`postCategoria` FROM `tb_posts` WHERE `postId` = '$postIdComent'");		
							while($resPostComent=mysql_fetch_array($selTituloPosComent)){
						$selAutorComent = mysql_query("SELECT `userNome`,`userFoto` FROM `tb_users` WHERE `userId` = '$autorIdComent'");
							while($resAutoComent=mysql_fetch_array($selAutorComent)){
			?>
            <li><img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/user/<?php echo $resAutoComent['userFoto']; ?>&h=40&w=40&zc=1" width="40" height="40" alt="<?php echo $resAutoComent['userNome']; ?>" title="<?php echo $resAutoComent['userNome']; ?>" />
            <span><?php echo $resComments['comentario'] ?></span>
            <span><strong>em resposta a</strong> <a href="<?php echo $urlBase; ?>/<?php echo $resPostComent['postCategoria']; ?>/<?php echo $resPostComent['postSlug']; ?>"><?php echo $resPostComent['postTitulo']; ?></a></span></li>
            <?php }}}} ?>
        </ul>
    </div><!--ultimos-comentarios-->
    
</div><!--home-->