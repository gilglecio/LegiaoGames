<div id="destaque">
<div id="loadings"><span>Carregando...</span></div>
	<div id="destaque-content">
		<div id="slide-content">
	    	<div id="slide">
	        	<ul>
                	<?php
					$SQLslider = mysql_query("SELECT * FROM `tb_posts` ORDER BY `postData` DESC LIMIT 3") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
						while($resultSlide = mysql_fetch_array($SQLslider)){
						$postCategoria=$resultSlide['postCategoria'];
						$postSlug=$resultSlide['postSlug'];
					?>
	            	<li>
                    <a href="<?php echo $urlBase; ?>/<?php echo $resultSlide['postCategoria']; ?>/<?php echo $resultSlide['postSlug']; ?>">
                    <img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $resultSlide['postThumb']; ?>&h=301&w=400&zc=1" alt="<?php echo $resultSlide['postSlug']; ?>" width="400" height="301" border="0">
                    </a>
                    <div class="slideLegend">
	            	<h2><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>">
                    <?php echo $resultSlide['postTitulo']; ?></a></h2>
	            	</div><!--slideLegend-->
                    </li>
                    <?php } ?>
	            </ul>
	        	
	        </div><!--slide-->
              
            <img src="<?php echo $urlBase; ?>/images/sombra-slide.png" width="416" height="25" alt="" id="sombra-slide"  />
	    </div><!--slide content-->
          <div id="imagem"><img src="<?php echo $urlBase; ?>/images/naruto.png" width="310" alt="" /></div>
        <div id="novidades">
        	<div id="novidade-bloco1">
            <?php
			$SQLBlocoUm = mysql_query("SELECT * FROM `tb_posts` ORDER BY `postData` DESC LIMIT 3,1") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
				while($resultBlocoUm = mysql_fetch_array($SQLBlocoUm)){
				$postCategoria=$resultBlocoUm['postCategoria'];
				$postSlug=$resultBlocoUm['postSlug'];
			?>
            	<a href="<?php echo $urlBase; ?>/<?php echo $resultBlocoUm['postCategoria']; ?>/<?php echo $resultBlocoUm['postSlug']; ?>">
                <img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $resultBlocoUm['postThumb']; ?>&h=165&w=215&zc=1" alt="<?php echo $resultBlocoUm['postSlug']; ?>" width="215" height="165" border="0"></a>
                <h3><a href="#"><?php echo $resultBlocoUm['postTitulo']; ?></a></h3>
            <?php } ?>
            </div><!--novidades bloco 01-->
            
            <div id="novidade-bloco2">
            <?php
			$SQLBlocoDois = mysql_query("SELECT * FROM `tb_posts` ORDER BY `postData` DESC LIMIT 4,1") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
				while($resultBlocoDois = mysql_fetch_array($SQLBlocoDois)){
				$postCategoria=$resultBlocoDois['postCategoria'];
				$postSlug=$resultBlocoDois['postSlug'];
			?>
            	<a href="<?php echo $urlBase; ?>/<?php echo $resultBlocoDois['postCategoria']; ?>/<?php echo $resultBlocoDois['postSlug']; ?>">
                <img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $resultBlocoDois['postThumb']; ?>&h=130&w=173&zc=1" alt="<?php echo $resultBlocoDois['postSlug']; ?>" width="173" height="130" border="0"></a>
                <h4><a href="<?php echo $urlBase; ?>/<?php echo $resultBlocoDois['postCategoria']; ?>/<?php echo $resultBlocoDois['postSlug']; ?>">
                <?php echo $resultBlocoDois['postTitulo']; ?></a></h4>
            <?php } ?>
            </div><!--novidades bloco 02-->
            <img src="<?php echo $urlBase; ?>/images/sombra-slide.png" width="170" height="16" alt="" id="sombra-novidades"  />
        </div><!--novidades-->
         <div id="slide-nav"><div class="paginador-slider"></div></div>
   	</div><!--destaque-content-->
</div><!--destaque-->

<div id="botao-destaque">
	<img src="<?php echo $urlBase; ?>/images/collapseButton.png" alt="" title="Clique para fechar a faixa acima" class="toggleButton">
	<img style="display: none;" src="<?php echo $urlBase; ?>/images/expandButton.png" alt="" class="toggleButton" id="expandButton">
</div><!--botao-destaque-->