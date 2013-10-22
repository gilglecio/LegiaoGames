<div id="categoria">
<div id="categoria-content">
<?php
$_SEARCHe = explode('/',$_SEARCH);
$_SEARCH = $_SEARCHe[0];

$_SEARCH = mysql_real_escape_string($_SEARCH);

$_PAGE = $_SEARCHe[2];

$_PAGE = ($_PAGE >= '1') ? $_PAGE : '1';
$maximo = '5';
$inicio = ($_PAGE * $maximo) - $maximo;

$SQL = mysql_query("SELECT * FROM `tb_posts` WHERE `postTitulo` LIKE '%$_SEARCH%' OR `postTexto` LIKE '%$_SEARCH%' LIMIT $inicio,$maximo") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
$resulBusca = mysql_num_rows($SQL);

$sqlResPaginatorPosts = mysql_query("SELECT * FROM `tb_posts` WHERE `postTitulo` LIKE '%$_SEARCH%' OR `postTexto` LIKE '%$_SEARCH%'");
$totalResPaginatorPosts = mysql_num_rows($sqlResPaginatorPosts);

if($resulBusca == 0){
	echo "<script type=\"text/javascript\">$(function(){alerta('Sua busca por <strong style=\"color:#900;\">".$_SEARCH."</strong> não retornou nenhum resultado');});</script>";
}else{
	?>
<span style="font-size:13px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Sua busca por <strong style="color:#900;"><?php echo $_SEARCH; ?></strong> retornou <strong style="color:#900;"><?php echo $totalResPaginatorPosts; ?></strong> resultados</span>
<hr style="margin-bottom:10px;" />
<ul>
    <?php
	while($result = mysql_fetch_array($SQL)){
		$postCategoria=$result['postCategoria'];
		$postSlug=$result['postSlug'];
		$postId=$result['postId'];
		$tituloColor = str_replace($_SEARCH,'<b style="background:#ffffcc; font-weight:normal;">'.$_SEARCH.'</b>',$result['postTitulo']);
		$textoColor = str_replace($_SEARCH,'<b style="background:#ffffcc; font-weight:normal;">'.$_SEARCH.'</b>',$result['postTexto']);
		
	?>
		<li>
		<a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>">
		<img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $result['postThumb']; ?>&h=150&w=200&zc=1" alt="<?php echo $result['postSlug']; ?>" width="200" height="150" border="0">
		</a>
	                
		<h5><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>"><?php echo $tituloColor; ?></a></h5>
		
	    <p><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>"><?php echo $textoColor; ?></a></p>
		
	    <span>por <a href="#"><?php echo $result['postAutor']; ?></a> em <a href="#"><?php echo date('d/m/y',strtotime($result['postData'])); ?></a>, sobre <a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>"><?php echo $result['postCategoria']; ?></a>, <a href="#"><?php echo $result['postVisitas']; ?></a> visualizações
	    <?php 
		//SELECIONAR COMENTARIO DE CADA POSTE
		$SQLCommnets = mysql_query("SELECT * FROM `tb_coments` WHERE `comentPostId` = '$postId'");
		$contarComments = mysql_num_rows($SQLCommnets);
		if($contarComments > 0){		
		  	echo ', <a href="'.$urlBase.'/'.$result['postCategoria'].'/'.$result['postSlug'].'#comentarios">'.$contarComments.'</a> comentários';
		}
		?>
	    </span>
		</li>
	<?php  } ?>
	</ul>
	
	<div id="paginador-postes">
	<?php
	if($totalResPaginatorPosts > $maximo){
		$paginas = ceil($totalResPaginatorPosts/$maximo);
		$links = '3';
		$anterior = $_PAGE-1;
		$proxima = $_PAGE+1;
		$linkPagina = $urlBase.'/?s='.$_SEARCH;
		
		echo '<span>página '.$_PAGE.' de '.$paginas.'</span>';
		
		if($_PAGE >= 6){
			echo "<a title=\"Primeira página\" href=\"$linkPagina\">Primeira</a>";
		}
		
		if($_PAGE > 1){
			echo "<a title=\"página anterior\" href=\"$linkPagina/page/$anterior\"><<</a>";
		}
		
		if($_PAGE>=5){
			echo '<span>...</span>';
		}
		
		for ($i = $_PAGE-$links; $i <= $_PAGE-1; $i++){
			if ($i <= 0){}else{
				if($i === 1){
					echo "<a href=\"$linkPagina\">$i</a>";
				}else{
					echo "<a href=\"$linkPagina/page/$i\">$i</a>";
				}
			}
		}
		echo '<span>'.$_PAGE.'</span>';
		for($i = $_PAGE +1; $i <= $_PAGE+$links; $i++){
			if($i > $paginas){}else{
				echo "<a href=\"$linkPagina/page/$i\">$i</a>";
			}
		}
		
		if($paginas-$links>$_PAGE){
			echo '<span>...</span>';
		}
		
		if($paginas-$links>($_PAGE+1)){
			echo "<a title=\"Ultima página\" href=\"$linkPagina/page/$paginas\">Ultima</a>";
		}
		
		if($_PAGE < $paginas){
			echo "<a title=\"proxima página\" href=\"$linkPagina/page/".$proxima."\">>></a>";
		}
	}
}
?>
</div><!--paginador -postes-->

</div><!--categoria content-->
</div><!--categoria-->