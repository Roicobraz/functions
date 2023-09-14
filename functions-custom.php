<?php
/* 
 Fonctions développé pour Wordpress 6.3.1
 Chaque fonction à pour nomenclature 
 => function nom(paramètre)
 	{ 
		// version: date dépendance (+ autre dépendance)
		[...]
	}
 dépendances : 
 	Bootstrap == Bt
	Jquery == Jq
	Fancybox == Fb
*/

/*--------------------------------------------------*/
/*		Avoir le lien d'une page via son titre		*/
/*--------------------------------------------------*/
	function cstm_get_permalink($title, $classname = "", $content = '', $target = 0, $posts_per_page = 1, $post_type = "page")
	{
		//	version : 13/09/2023
		if(is_int($title)):
		{
			$query = new WP_Query(array('post_type' => $post_type,'posts_per_page' => $posts_per_page,'p'  => $title));
		}
		elseif(is_string($title)):
		{
			$query = new WP_Query(array('post_type' => $post_type,'posts_per_page' => $posts_per_page,'s'  => $title));
		}
		endif;
		
		if ($target == 1):
		{
			$blank = 'target="_blank"';
		}
		else:
		{
			$blank = '';
		}
		endif;
		
		
		$site_info = '';
		if ( $query ) :
		{
			while ( $query->have_posts() ):
			{
				$query->the_post();
				if(empty($content)):
				{
					$content = get_the_title();
				}
				endif;
				$site_info .= '<a class="'.$classname.'" '.$blank.' href="'.get_permalink().'">'.$content.'</a>';
			}
			endwhile;
		}
		endif;
		echo($site_info);
	}


/*----------------------------------------------*/
/*					Avoir un âge				*/
/*----------------------------------------------*/
	function cstm_age($date_created = 0 )
	{	
		//	version : 12/09/2023
		$create = explode( '/', $date_created );
		$date = array(date("d"),
					  date("m"),
					  date("Y"));
		
		$ancient=$date[2] - $create[2];

		if ($date[1] == $create[1]) 
		{
			if ($date[0] < $create[0] ) 
			{
				$ancient = $ancient - 1;
			}
		}
		else if ($date[1] < $create[1]) 
		{
			$ancient = $ancient - 1;
		}

		if($ancient == 0):
		{
			$ancient = '<1';
		}
		endif;
		echo($ancient);
	}


/*--------------------------------------------------*/
/*		Compare une date avec la date actuelle		*/
/*--------------------------------------------------*/
	function cstm_compare_date($date_opening)
	{
		// version: 12/09/2023
		$close = explode( '/', $date_closing );
		$newclose = date_i18n("j F", strtotime($date_closing));
		
		$open = explode( '/', $date_opening );
		$newopen = date_i18n("j F", strtotime($date_opening));

		// Date actuelle
		$date = array(date("m"), date("d"), date("Y"));
		
		$bool = 0;

		// Check if the actual date is under the re-opening {
		// Date in english format 
		if( $date[2] > $close[2] ):
		{
			$bool = true;
		}
		elseif( $date[2] == $close[2] ):
		{
			if( $date[0] > $close[0] ):
			{
				$bool = true;
			}
			elseif( $date[0] == $close[0] ):
			{
				if( $date[1] >= $close[1] ):
				{
					$bool = true;
				}
				endif;
			}
			endif;
		}
		endif;
		
		$begin = $bool;
		$bool = 0;

		if( $date[2] < $open[2] ):
		{
			$bool = true;
		}
		elseif( $date[2] == $open[2] ):
		{
			if( $date[0] < $open[0] ):
			{
				$bool = true;
			}
			elseif( $date[0] == $open[0] ):
			{
				if( $date[1] <= $open[1] ):
				{
					$bool = true;
				}
				endif;
			}
			endif;
		}
		endif;
		
		$ending = $bool;
		return($begin); 
		return($ending);
	}


/*----------------------------------------------*/
/*	Fait un décompte avec défilement des nombre	*/
/*----------------------------------------------*/
	function cstm_decompte($date_created, $format = "" )
	{
		//	version : 12/09/2023
		$create = explode( '/', $date_created );
		$date = array(date("d"),
					  date("m"),
					  date("Y"));
	
		if( $format == null ):
		{
			$ancient=$date[2] - $create[2];

			if ($date[1] == $create[1]) 
			{
				if ($date[0] < $create[0] ) 
				{
					$ancient = $ancient - 1;
				}
			}
			else if ($date[1] < $create[1]) 
			{
				$ancient = $ancient - 1;
			}

			if($ancient == 0):
			{
				$ancient = '<1';
			}
			endif;
		}
		elseif ($format != null && !($create[2] < $date[2])) :
		{
			if( $create[2] > $date[2] ):
			{
				$year = 365.25 * ( ($create[2]) - $date[2] );
			}
			elseif( $create[2] == $date[2] ):
			{
				$year = 0;
			}
			endif;
		// Formats :
			// Jour
			if($format == "j"):
			{				
				if( $create[0] > $date[0] ):
				{
					$day = $create[0] - $date[0];
				}
				elseif( $create[0] < $date[0] ):
				{
					$day =  $date[0] - $create[0];
				}
				else:
				{
					$day = 0;
				}
				endif;
				
				if( $create[1] > $date[1] ):
				{
					$month = 30.8 * ( $create[1] - $date[1] );
				}
				elseif( $create[1] < $date[1] ):
				{
					$month = 1;
				}
				else:
				{
					$month = 0;
				}
				endif;
		
			}
			// Mois
			elseif($format == "m"):
			{
				$day = 1;
				$month = 2;
				$year = 3;
				
				$ancient = 20 * 12;
			}
			// Mois et Jours			
			elseif($format == "m+j"):
			{
				$day = 1;
				$month = 2;
				$year = 3;
				
				$ancient = 20;
			}
			endif;
			
			
			echo($day);?> <br> <?php
			echo($month);?> <br> <?php
			echo($year);?> <br> <?php

			$ancient = $day + $month + $year;
			echo($ancient);
		}
		endif;		
	}


/*----------------------------------------------*/
/*	Avoir un nombre défilant de 0 à n défini	*/
/*----------------------------------------------*/
	function cstm_count($count, $id, $classname="animated_counter")
	{	
		// version : 12/09/2023	
		?>
		<div id="<?= $id ?>" class="<?php $classname ?>"><?= $count ?></div>
		
		<style>
			#<?= $id ?> 
			{
		  		font: 800 40px system-ui;
			}	
		</style>

		<script>
			function animateValue(obj, start, end, duration) 
			{
				let startTimestamp = null;
				const step = (timestamp) => {
					if (!startTimestamp) startTimestamp = timestamp;
						const progress = Math.min((timestamp - startTimestamp) / duration, 1);
						obj.innerHTML = Math.floor(progress * (end - start) + start);
					if (progress < 1) {
						window.requestAnimationFrame(step);
					}
				};
				window.requestAnimationFrame(step);
			}

			var obj = document.getElementById("<?= $id ?>");
			animateValue(obj, 0, <?php echo $count ?>, 5000);		
		</script>
				
		<?php
	}


/*----------------------------------------------*/
/*					Carousel					*/
/*----------------------------------------------*/
	function cstm_carousel($repeater, $id = "carouselExample", $buttons, $multi)
	{
		//	version: 12/09/2023 Bt
	?>	
	<div class="container text-center my-3">
    <div class="row mx-auto my-auto justify-content-center">
        <div id="<?php echo $id ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
				<?php	
				$counter_slide = 0;	
				while ( have_rows('repeater') ) : the_row();
				{		
					if( !empty(get_sub_field('image')) ):
					//-----------------------------------------------	
						if($counter_slide == 0 ):
						{ 
							$class_indicator = "active";
						}	
						else:
						{
							$class_indicator = '';
						}
						endif;	
					//-----------------------------------------------
						$background = get_sub_field('background');
						$image = get_sub_field('image');
						$titre = get_sub_field('titre');
					//-----------------------------------------------
						?>

					<div class="<?php echo $class_indicator;?> carousel-item">
						<div class="col-md-3">
							<div class="card" style='background: <?php echo $background ?>;'>
								<div class="card-img">
									<img src="<?php echo $image ?>" class="img-fluid">
								</div>
								<div class="card-img-overlay"><?php echo $titre ?></div>
							</div>
						</div>
					</div>
				<?php
					$counter_slide++;
					endif;
					wp_reset_postdata();	   
				}
				endwhile;	
				?>
				
            </div>
			<?php
			if($buttons):
			{
				?>
				<a class="carousel-control-prev bg-transparent w-aut button-l" href="#<?php echo $id ?>" role="button" data-bs-slide="prev">
					<i class="fa-regular fa-circle-arrow-left" aria-hidden="true"></i>
				</a>
				<a class="carousel-control-next bg-transparent w-aut button-r" href="#<?php echo $id ?>" role="button" data-bs-slide="next">
					<i class="fa-regular fa-circle-arrow-right" aria-hidden="true"></i>
				</a>
				<?php
			}
			endif;
            
			?>
        </div>
    </div>
</div>

<?php if($multi):
		{ ?>
			<style>
				@media (max-width: 767px) 
				{
					.carousel-inner .carousel-item > div 
					{
						display: none;
					}
					.carousel-inner .carousel-item > div:first-child 
					{
						display: block;
					}
				}

				.carousel-inner .carousel-item.active, .carousel-inner .carousel-item-next, .carousel-inner .carousel-item-prev 
				{
					display: flex;
				}

				/* medium and up screens */
				@media (min-width: 768px) 
				{
					.carousel-inner .carousel-item-end.active, .carousel-inner .carousel-item-next 
					{
					  transform: translateX(25%);
					}

					.carousel-inner .carousel-item-start.active, .carousel-inner .carousel-item-prev 
					{
						transform: translateX(-25%);
					}
				}

				.carousel-inner .carousel-item-end, .carousel-inner .carousel-item-start 
				{ 
				  transform: translateX(0);
				}
			</style>

			<script>
				let items = document.querySelectorAll('.carousel .carousel-item')

				items.forEach((el) => {
					const minPerSlide = 4
					let next = el.nextElementSibling
					for (var i=1; i<minPerSlide; i++) {
						if (!next) {
							// wrap carousel by using first child
							next = items[0]
						}
						let cloneChild = next.cloneNode(true)
						el.appendChild(cloneChild.children[0])
						next = next.nextElementSibling
					}
				})
			</script>	
		<?php
		}
		endif;
	}


/*------------------------------------------*/
/*					Card					*/
/*------------------------------------------*/
	function cstm_card($title = '', $image = '', $description, $link = '#', $button = '',$test = '')
	{
		//	version: 12/09/2023 Bt
	?>
		<div class="card">
			<div class="card__face card__face--front">
				<img src="<?php echo($image); ?>" class="card-img-top" alt="...">
				<div class="card-body">
					<h6 class="card-title"><?php echo($title); ?></h6>
					<div class="card-text row">
						<p class='description col'><?php echo($description); ?><a href="<?php echo($link); ?>" class="btn"><?php echo $button ?></a></p>
					</div>
				</div>
			</div>
   	 		<div class="card__face card__face--back"><?= $test ?></div>
		</div>
	<?php
	}


/*------------------------------------------*/
/*				Scrollspy					*/
/*------------------------------------------*/
	function cstm_scrollspy_start($nav_id = "navbar-example3")
	{
		//	version: 12/09/2023 Bt
		$code_html = 'data-bs-spy="scroll" data-bs-target="#'.$nav_id.'" data-bs-smooth-scroll="true" data-bs-root-margin="0px 0px -50%" class="scrollspy-example-2" tabindex="0"';
		
		echo($code_html);
	}

	function cstm_scrollspy($nav_menu)
	{
		//	version: 12/09/2023 Bt
		$blocks = wp_get_nav_menu_items($nav_menu, $nav_id = "navbar-example3");	?>
		<nav id="<?php echo $nav_id ?>" class="h-100 flex-column align-items-stretch pe-4 border-end">
			<nav class="nav nav-pills flex-column"> <?php
		
		foreach ($blocks as $block)
		{
			$blocklink = $block->post_name; ?>
				<a class="nav-link" href="#<?= $blocklink ?>"><i class="fa-regular fa-circle"></i></a><?php
		}?>
			</nav>
		</nav>
							
		<style>
			.active
			{
				background-color: transparent !important;
			}
			
			.nav-link i
			{
				color: #384e4d;
				background: transparent;
				border-radius: 100%;
			}
			
			.active i
			{
				background: #384e4d;
			}
		</style>
				<?php
	}


/*----------------------------------------------*/
/*		Changer le logo de la page wp-login		*/
/*----------------------------------------------*/
/* À retravailler */
	function cstm_my_login_logo() 
	{ 
		//	version : 12/09/2023
		$mobile_themecolor = get_theme_mod( 'mobile_themecolor' );

	?>
		<?php if (get_theme_mod( 'custom_logo' )){ ?>

		<style type="text/css">

		body.login div#login h1 a { 

		<?php 
				$themes_mod = array(get_theme_mod('custom_logo'),get_theme_mod('custom_logo_icon'),get_theme_mod('custom_logo_text'),);

				/* GESTION DES VERSION LIGHT ------------------------------- */
				if (get_theme_mod('navbarlogo_color') == 'light') 
				{
					foreach($themes_mod as $theme_mod):
					{
						if($theme_mod):
						{
							$custom_logo_parts = pathinfo($theme_mod);
							$custom_logo_light  = $custom_logo_parts['dirname'].'/'.$custom_logo_parts['filename'].'-light.'.$custom_logo_parts['extension'];
							$logo = $custom_logo_light;	
						}
						endif;
					}
					endforeach;
				}
				else
				{
					$logo = $custom_logo;	
				}	


		?>		
		background-image: url(<?php echo $logo;?>);
		background-size: 100% auto; width:auto;}
		.login h1 a { height:200px !important; margin-bottom:0}

		html, body, .wp-dialog { background-color: <?php echo $mobile_themecolor;?> !important;}
		.login form { box-shadow: 0 0 5px 1px rgba(100, 100, 100, 0.3) !important;}
		.login #backtoblog a, .login #nav a { color:#fff !important;}
		</style>
		<?php } ?>

	<?php }
	add_action( 'login_enqueue_scripts', 'cstm_my_login_logo' );

/*----------------------------------------------*/
/*			Modal de Fermeture Fancybox			*/
/*----------------------------------------------*/
	function cstm_modal_closing()
	{
		// version: 12/09/2023 Fb + cstm_compare_date()
	 ?>
		<script type="text/javascript">
	<?php 
		if (get_field('display-date', 'option')):
		{
		$date_closing = get_field('closing-date' , 'option');
		$close = explode( '/', $date_closing );
		$newclose = date_i18n("j F", strtotime(get_field('closing-date' , 'option')));

		// Date actuelle
		$date = array(date("m"), date("d"), date("Y"));
		$bool_opening = false;
		$bool_closing = false;
		$before = false;
		$after = false;

		$test ="";

		if (!empty(get_field('opening-date', 'option'))):
		{
			$date_opening = get_field('opening-date' , 'option');
			$open = explode( '/', $date_opening );
			$newopen = date_i18n("j F", strtotime(get_field('opening-date' , 'option')));

	// Check if the actual date is under the re-opening {
			// Date in english format 
			cstm_compare_date($close);
			if( $date[2] > $close[2] ):
			{
				$bool_closing = true;
			}
			elseif( $date[2] == $close[2] ):
			{
				if( $date[0] > $close[0] ):
				{
					$bool_closing = true;
				}
				elseif( $date[0] == $close[0] ):
				{
					if( $date[1] >= $close[1] ):
					{
						$bool_closing = true;
					}
					endif;
				}
				endif;
			}
			endif;

			if( $date[2] < $open[2] ):
			{
				$bool_opening = true;
			}
			elseif( $date[2] == $open[2] ):
			{
				if( $date[0] < $open[0] ):
				{
					$bool_opening = true;
				}
				elseif( $date[0] == $open[0] ):
				{
					if( $date[1] <= $open[1] ):
					{
						$bool_opening = true;
					}
					endif;
				}
				endif;
			}
			endif;
	/*}*/

	// Check if the actual date is above the closing {
			if($close[1] - 7 <= 0):
			{
				$week = 30 + ($close[1] - 7);
				$month = $close[0] - 1;

				if( $month <= 0 ):
				{
					$year = $close[2] - 1;
					$month = 12;
				}
				else:
				{
					$year = $close[2];
				}
				endif;
			}
			else:
			{
				$week = $close[1] - 7;
				$month = $close[0];
				$year = $close[2];
			}
			endif;
	/*}*/

	// Check if the actual date is between closing and (closing - 7) {
			if( $date[2] > $year ):
			{
				$before = true;
			}
			elseif( $date[2] == $year ):
			{
				if( $date[0] > $month ):
				{
					$before = true;
				}
				elseif( $date[0] == $month ):
				{
					if( $date[1] >= $week ):
					{
						$before = true;
					}
					endif;
				}
				endif;
			}
			endif;

			if( $date[2] < $close[2] ):
			{
				$after = true;
			}
			elseif( $date[2] == $close[2] ):
			{
				if( $date[0] < $close[0] ):
				{
					$after = true;
				}
				elseif( $date[0] == $close[0] ):
				{
					if( $date[1] <= $close[1] ):
					{
						$after = true;
					}
					endif;
				}
				endif;
			}
			endif; 
	/*}*/
		}
		else:
		{
			$newopen = '';
		}
		endif;

		if ( ($bool_opening && $bool_closing) || ($before && $after)):
			{
				$closingdescription = get_field('closing-description', 'option');
				$closingimage = get_field('closing-image', 'option');	
				if($closingimage):
				{
					$closingimage='<img src="'.$closingimage.'" class="img-fluid">';
				}
				endif;
				?>
				$( document ).ready(function()
				{
					$.fancybox.open('<div class="message" style="max-width:600px;"><h3 class="text-center" style="font-weight:500"><?php if(get_field('type-closing', 'option')==1):{echo (the_field('titre', 'option'));}else:{echo (the_field('entreprise', 'option'));if($after):{echo(' sera ');}else:{echo(' est ');}endif;if(get_field('type-closing', 'option')==2):{echo'en congés ';}elseif(get_field('type-closing', 'option')==3):{echo'exceptionnellement fermé ';}endif;?><strong><?php if(!empty(get_field('opening-date', 'option'))):{?> du <?php }else:{?> le <?php }endif;echo $newclose;if(!empty(get_field('opening-date', 'option'))):{?> au <?php echo $newopen;}endif; if(get_field('inclus', 'option')):{ echo('  inclus');}endif;}endif;?></strong></h3><div class="text-center"><?php echo get_field('closing-description', 'option') ?></div><?php if(!empty(get_field('closing-image', 'option'))):{echo("<img src=".get_field('closing-image', 'option').">");}endif;?></div>');
				});	

	<?php 	}
			endif;
		}
		endif;?>
		</script>	
	<?php
	}

