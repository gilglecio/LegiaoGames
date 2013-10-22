<?php
function upload($tmp, $name, $nome, $largura, $pasta){
	if(end(explode('.',$name))=='jpg'){
		$img = imagecreatefromjpeg($tmp);
	}elseif(end(explode('.',$name))=='png'){
		$img = imagecreatefrompng($tmp);
	}elseif(end(explode('.',$name))=='gif'){
		$img = imagecreatefromgif($tmp);
	}else{
		return 'Tipo de imagem não aceitável';
		exit;
	}
	$x = imagesx($img);
	$y = imagesy($img);
	$larguraE = ($x+$y) / 2;
	$largura = ($larguraE>$largura) ? $largura : $larguraE;
	$altura = ($largura*$y) / $x;
	if($altura>$largura){ $altura = $largura; $largura = ($altura*$x) / $y;	}
	$nova = imagecreatetruecolor($largura, $altura);
	imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
	imagejpeg($nova, "$pasta/$nome");
    imagedestroy($img);
	imagedestroy($nova);
	return $nome;
}

function slug($string, $slug = false) {
	$string = strtolower($string);
	$ascii['a'] = range(224, 230);
	$ascii['e'] = range(232, 235);
	$ascii['i'] = range(236, 239);
	$ascii['o'] = array_merge(range(242, 246), array(240, 248));
	$ascii['u'] = range(249, 252);
	$ascii['b'] = array(223);
	$ascii['c'] = array(231);
	$ascii['d'] = array(208);
	$ascii['n'] = array(241);
	$ascii['y'] = array(253, 255);
	foreach ($ascii as $key=>$item) {
		$acentos = '';
		foreach ($item AS $codigo) $acentos .= chr($codigo);
		$troca[$key] = '/['.$acentos.']/i';
	}
	$string = preg_replace(array_values($troca), array_keys($troca), $string);
	if ($slug) {
		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
		$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
		$string = trim($string, $slug);
	}
	return $string;
}