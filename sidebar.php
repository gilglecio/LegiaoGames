<div id="sidebar-content">
    <span>menu lateral</span>
    <ul>
	<?php
    $selCatMenuLado = mysql_query("SELECT `postCategoria` FROM `tb_posts` GROUP BY `postCategoria` ORDER BY `postCategoria` ASC");
    if(mysql_num_rows($selCatMenuLado) === 0){
        echo '<li><a href="#">categorias</a></li>';
    }else{
        $ArrayCatsLado = array();
		$ArraySubCatsLdo = array();
		
        while($resCatMenuLado=mysql_fetch_array($selCatMenuLado)){
			
            $resCatMenuLadoE = explode('/',$resCatMenuLado['postCategoria']);
			if($resCatMenuLadoE[1]){
				array_push($ArraySubCatsLdo,$resCatMenuLadoE[1]);
			}
            array_push($ArrayCatsLado,$resCatMenuLadoE[0]);
        }
        $ArrayCatsLado = array_values(array_unique($ArrayCatsLado));								
        $numCategoriasLado = count($ArrayCatsLado);
        for($m=0;$m<$numCategoriasLado;$m++){
            echo '<li><a href="'.$urlBase.'/'.$ArrayCatsLado[$m].'">'.ucfirst($ArrayCatsLado[$m]).'</a></li>';
			//echo '<ul>';
				//echo '<li><a href="#">>>'.$ArraySubCatsLdo[$m].'</a></li>';
			//echo '</ul>';
        }
    } 
    ?>
    </ul>
    <span>Atendimento</span>
    <ul><li>
<?php
require 'chat/util/pdo.php';
require 'chat/util/settings.php';

$pdo = PDOConnection::getInstance();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE time > :time AND status = :status');
$stmt->bindValue('time', $lifeTime);
$stmt->bindValue('status', 1);
$stmt->execute();

if($stmt->fetchColumn() == 0){
	print 'Offline';
}else{
	print '<a href="javascript:void(0)" id="atendimento">Online!</a>';
}

?>
</li></ul>
</div><!--sidebar content-->