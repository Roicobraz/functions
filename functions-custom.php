<?php
/*--------------------------------------------------*/
/*		Avoir le lien d'une page via son titre		*/
/*--------------------------------------------------*/
	function cstm_get_permalink($title, $classname = "", $target = 0, $posts_per_page = 1, $post_type = "page")
	{
		//	version : 12/09/2023
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
				$site_info .= '<a class="'.$classname.'" '.$blank.' href="'.get_permalink().'">'.get_the_title().'</a>';
			}
			endwhile;
		}
		endif;
		echo($site_info);
	}


/*----------------------------------------------*/
/*					Avoir un âge				*/
/*----------------------------------------------*/
	function cstm_age($date_created = 0 ){	 
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


	function cstm_decompte($date_created, $format = "" ){	 
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
	function cstm_count($count, $id, $classname="animated_counter"){		
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

	function cstm_carousel($repeater, $id = "carouselExample", $buttons, $multi){
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

	function cstm_card($title = '', $image = '', $description, $link = '#', $button = '',$test = ''){
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
	function cstm_scrollspy_start($nav_id = "navbar-example3"){
		$code_html = 'data-bs-spy="scroll" data-bs-target="#'.$nav_id.'" data-bs-smooth-scroll="true" data-bs-root-margin="0px 0px -50%" class="scrollspy-example-2" tabindex="0"';
		
		echo($code_html);
	}

	function cstm_scrollspy($nav_menu){
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
	function my_login_logo() { 

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
	add_action( 'login_enqueue_scripts', 'my_login_logo' );


 

?>

