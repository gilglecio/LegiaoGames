<?php
include('php/model.php');
$palavra_chave = array();
$sql = mysql_query("SELECT `postTags`, `postVisitas`,`postId` FROM `tb_posts` GROUP BY `postTags` ORDER BY RAND() LIMIT 25");
	if($sql){
	  	while( $linha = mysql_fetch_array($sql) ){
			$palavra_chave[$linha[0]] = $linha[1];
			 	$id_noticia[$linha[0]]    = $linha[2];
		}
	}

	$tamanho_inicial=11;
	$tag_separadora='&nbsp;';
	$max_count = array_sum($palavra_chave);
	$palavras= count($palavra_chave);
	$fator=1;
	$i=1;
	foreach( $palavra_chave as $tag => $peso ){
	$pixel   = round( ($peso * 100)/$max_count ) * $fator;
	$tamanho = $tamanho_inicial + $pixel.'px';
		if( $tamanho > '40px' ){
			$tamanho = '40px';
		}
	if( $palavra_chave[$tag] !== '' ){
		echo "<span style='font-size:".$tamanho.";'>
				  <a href='".$urlBase."/arquivo/".$tag."'>".$tag."</a>
			  </span>".$tag_separadora;
	}
}
			
?>