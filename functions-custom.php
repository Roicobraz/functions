<?php
/* 
 Fonctions développé sous Wordpress 6.3.1
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
	ACF et ACF Pro
*/

/* Admin Wordpress {*/
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

/*------------------------------------------*/
/*	Longueur maximum des extraits (en mots)	*/
/*------------------------------------------*/
	function my_excerpt_length(){ return 15; } add_filter('excerpt_length', 'my_excerpt_length');

/*--------------------------------------------------------------*/
/*	Mets en brouillon tout les articles ayant leur date dépassé	*/
/*--------------------------------------------------------------*/
	function cstm_pubdraft($args)
	{
		// version: 21/09/2023
		$date_begin	= $args['date_begin'];
		$date_end	= $args['date_end'];
		$content	= $args['content'];
		$draft		= $args['draft'];
		$duree_event= $args['one_day'];
		
		// Date d'aujourd'hui
		$date_today = date("m/d/Y");
		$date_today = strtotime($date_today);
		
		// Date du début de l'évenement
		$datebefore = strtotime($date_begin);
		$date = date_i18n("j F", $datebefore);

		// Date de fin de l'évènement
		$dateafter = strtotime($date_end);
		$date_f = date_i18n("j F", $dateafter);

		// Calcul des dates
		$publish = $datebefore <= $date_today && $date_today <= $dateafter;

		if($publish || $duree_event):
		{
			return $content;
		}
		else:
		{	
			$post = array( 'ID' => get_the_id(), 'post_status' => 'draft' );
			wp_update_post($post);
		}
		endif;	
	}

/*------------------------------------------------------------------*/
/*	Mets dans une catégorie la publication une fois sa date dépassé	*/
/*------------------------------------------------------------------*/
	function cstm_pubterm($args)
	{
		// version: 21/09/2023
		$date_begin	= $args['date_begin'];
		$date_end	= $args['date_end'];
		$duree_event= $args['one_day'];
		$idpost		= $args['id'];
		$termname	= $args['termname'];
		$taxonomy	= $args['taxonomy'];
		
		
		// Date d'aujourd'hui
		$date_today = date("m/d/Y");
		$date_today = strtotime($date_today);
		
		// Date du début de l'évenement
		$datebefore = strtotime($date_begin);
		$date = date_i18n("j F", $datebefore);

		// Date de fin de l'évènement
		$dateafter = strtotime($date_end);
		$date_f = date_i18n("j F", $dateafter);

		// Calcul des dates
		$publish = $datebefore <= $date_today && $date_today <= $dateafter;
		
		$id = term_exists( $termname, $taxonomy );
		if ( $id ):
		{
		
		}
		else:
		{
			wp_insert_term( $termname, $taxonomy );
		}
		endif;

		

		$term_cpt	= get_term_by('name', $termname, $taxonomy);
		$term_id	= $term_cpt->term_id;
		
		if(!term_exists($term_id, $taxonomy)):
		{
			
		}
		endif;
		
		if(!($publish || $duree_event)):
		{
			wp_set_post_terms( $idpost, $term_id, $taxonomy, true );
		}
		endif;
	}

/*----------------------------------------------*/
/*		ajout de style pour le backoffice		*/
/*----------------------------------------------*/
/* Le CSS est appelé en tant que feuille de style */
	function admin_css() 
	{		
//		version : 25/09/2023
		$admin_handle = 'admin_css';
		$admin_stylesheet = get_template_directory_uri() . '/css/stylad.css';
		wp_enqueue_style($admin_handle, $admin_stylesheet);
    }
	add_action('admin_print_styles', 'admin_css', 11);

/* Le CSS est appelé via du JS */
	function admin_css() 
	{
//		version : 25/09/2023
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( '/css/stylad.css' );
    }
	add_action( 'admin_init', 'admin_css' );
/*}*/


/* Autre Fonction {*/
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
		// version: 19/09/2023 ACF
		
		// Date d'aujourd'hui
		$date_today = date("m/d/Y");
		$date_today = strtotime($date_today);
		// Date du début de l'évenement
		$date_closing = get_field('closing-date' , 'option');
		$datebefore = strtotime($date_closing);
		$newclose = date_i18n("j F", $datebefore);
		
		// Date de fin de l'évènement
		$date_opening = get_field('opening-date' , 'option');
		$dateafter = strtotime($date_opening);	
		$newopen = date_i18n("j F", $dateafter);
		
		// Calcul des dates
		$event = $datebefore <= $date_today && $date_today <= $dateafter;
		$beforeevent = $date_today_7 <= $date_today && $date_today <= $datebefore;
				
		if ( $beforeevent || $event):
		{
			return($event);
			return($beforeevent);
		}
		endif;
	}

/*----------------------------------------------*/
/*			Modal de Fermeture Fancybox			*/
/*----------------------------------------------*/
	function cstm_modal_closing()
	{
		// version: 19/09/2023 ACF Fb
	 ?>
		<script type="text/javascript">

<?php  
	if (get_field('display-date', 'option')):
	{
		$closingdescription = get_field('closing-description', 'option');
		$closingimage = get_field('closing-image', 'option');	
		
		if($closingimage):
		{
			$closingimage='<img src="'.$closingimage.'" class="img-fluid">';
		}
		endif;
		
		// Date d'aujourd'hui
		$date_today = date("m/d/Y");
		$date_today = strtotime($date_today);
		
		// Date du début de l'évenement
		$date_closing = get_field('closing-date' , 'option');
		$datebefore = strtotime($date_closing);
		$newclose = date_i18n("j F", $datebefore);

		// Date 7 jours avant l'évènement
		$date_today_7 = strtotime($date_closing.'- 7 days');
		
		if (!empty(get_field('opening-date', 'option'))):
		{
			// Date de fin de l'évènement
			$date_opening = get_field('opening-date' , 'option');
			$dateafter = strtotime($date_opening);	
			$newopen = date_i18n("j F", $dateafter);
		}
		else:
		{
			$newopen = '';
		}
		endif;
		
		// Calcul des dates
		$event = $datebefore <= $date_today && $date_today <= $dateafter;
		$beforeevent = $date_today_7 <= $date_today && $date_today <= $datebefore;
		
		// Texte de la Fancybox
		$code_html = '';
		
		if(get_field('type-closing', 'option')==1):
		{
			$code_html .= get_field('titre', 'option');
		}
		else:
		{
			$code_html .= get_field('entreprise', 'option');
			
			if($beforeevent):{$code_html .= ' sera ';}else:{$code_html .= ' est ';}endif;
			
			if(get_field('type-closing', 'option')==2):{$code_html .= 'en congés ';}elseif(get_field('type-closing', 'option')==3):{$code_html .= 'exceptionnellement fermé ';}endif;
			
			$code_html .= '<strong>' ;
			
			if(!empty(get_field('opening-date', 'option'))):{$code_html .= ' du ';}else:{$code_html .= ' le ';}endif;
			
			$code_html .=  $newclose;
			
			if(!empty(get_field('opening-date', 'option'))):{$code_html .= ' au '.$newopen;}endif;
			
			if(get_field('inclus', 'option') && !empty(get_field('opening-date', 'option'))):{$code_html .= '  inclus';}endif;
		}
		endif;
		
		$code_html .= '</strong></h3><div class="text-center">'.get_field('closing-description', 'option').'</div>';
	 
		if(!empty(get_field('closing-image', 'option'))):
		{
			$code_html .= ("<img src=".get_field('closing-image', 'option').">");
		}
		endif;

		if ( $beforeevent || $event):
		{
			?>
			$( document ).ready(function()
			{
				$.fancybox.open('<div class="message" style="max-width:600px;"><h3 class="text-center" style="font-weight:500"><?php echo($code_html);?></div>');
			});	
		<?php
		}
		endif;
	}
	endif;
	?>
</script>	
	<?php
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
/*}*/


/* Dépendance Bootstrap {
/*----------------------------------------------*/
/*					Carousel					*/
/*----------------------------------------------*/
	function cstm_carousel($args)
	{
		//	version: 25/09/2023 ACF Pro Bt
	
		$repeater		= $args['repeater'];
		$id				= $args['id'];
		$buttons		= $args['buttons'];
		$multi			= $args['multi'];
		$template		= $args['template'];
		$colonage		= $args['colonage'];
		$taxonomie 		= $args['taxonomie'];
		$nombre_de_post = $args['nombre_de_post'];
	/*{*/
		if(!empty($taxonomie)):
		{
			$taxname = "";
			
			foreach ($taxonomie as $taxid):
			{
				$taxname .= get_the_category_by_ID( $taxid ).',';
			}
			endforeach;
			
			if($taxname[-1]==','):
			{
				$taxname = substr_replace($taxname, "",-1);
			}
			endif;
			
			$atts = array(
				'post_type' 	=> 'post',
				'category_name' => $taxname, 
				'orderby' 		=> 'date', 
				'posts_per_page'=> $nombre_de_post
			 );

		} 
		elseif(empty($repeater)):
		{
			echo ('Aucun contenu. Veuillez remplir le champ ACF répéteur Objet.');
			return;
		}
		endif;
	/* Valeur par défault { */
		if(empty($id)):
		{
			$id = 'carouselcustom';
		}
		endif;
		if(empty($buttons)):
		{
			$buttons = false;
		}
		endif;
		if(empty($multi)):
		{
			$multi = false;
		}
		endif;
		if(empty($template)):
		{
			$template = 1;
		}
		endif;	
		if(empty($colonage)):
		{
			$colonage = 12;
		}
		endif;
	/*}*/
	/*}*/

		$othercol = 12 - $colonage;
		
		$counter_slide 	= 0;
		$code_html 		= '
			<div class="container text-center my-3">
				<div class="row mx-auto my-auto justify-content-center">
					<div id="'.$id.'" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner" role="listbox">
					';
			if(!empty($atts)):
			{		
				$query = new WP_Query($atts);
//				print_r($query);
				if ( $query->have_posts() ) : 
				{
					while ( $query->have_posts() ) :
					{
						$query->the_post();
						//-------------------------------------------------
						$image = get_the_post_thumbnail();
						$titre = get_the_title();
						$description = get_the_excerpt();
						//-------------------------------------------------
						if($counter_slide == 0 ):
						{ 
							$class_indicator = "active";
						}	
						else:
						{
							$class_indicator = '';
						}
						endif;	
					/* Content {*/
						$code_html .= '
							<div class="'.$class_indicator.' carousel-item">';
						
						if($template == 2):
						{
							$code_html .= '
								<div class="row card" style="background: '.$background.';">
									<div class="col-'.$colonage.' card-img">
										<img src="'.$image.'" class="img-fluid">
									</div>
									<div class="card-img-overlay col-md" style="color: '.$color.';">'.$titre.'</div>
									'.$description.'
								</div>
							</div>';
						}
						elseif($template == 1):
						{
							$code_html .= '
								<div class="row" style="background: '.$background.';">
									<div class="col-'.$colonage.'">
										<div>
											<img src="'.$image.'" class="img-fluid">
										</div>
									</div>
									<div class="col col-'.$othercol.'" style="color: '.$color.';">
										<h3>'.$titre.'</h3>
										'.$description.'
									</div>
								</div>
						</div>';
						}
						endif;
					/*}*/
						$counter_slide++;
					}
					endwhile;
				}
				endif;
			}
			else:
			{
				while ( have_rows('repeater') ) : 
				the_row();
				{
					if( !empty(get_sub_field('image')) ):
					{
					//-------------------------------------------------
						$image 		= get_sub_field('image');
						$titre 		= get_sub_field('titre');
						$description= get_sub_field('description');
						$background = get_sub_field('background');
						$color 		= get_sub_field('color');
					//-------------------------------------------------
						if($counter_slide == 0 ):
						{ 
							$class_indicator = "active";
						}	
						else:
						{
							$class_indicator = '';
						}
						endif;	
					/* Content {*/
						$code_html .= '
							<div class="'.$class_indicator.' carousel-item">';
						
						if($template == 2):
						{
							$code_html .= '
								<div class="row card" style="background: '.$background.';">
									<div class="col-'.$colonage.' card-img">
										<img src="'.$image.'" class="img-fluid">
									</div>
									<div class="card-img-overlay col-'.$othercol.'" style="color: '.$color.';">'.$titre.'</div>
									'.$description.'
								</div>
							</div>';
						}
						elseif($template == 1):
						{
							$code_html .= '
								<div class="row" style="background: '.$background.';">
									<div class="col-'.$colonage.'">
										<div>
											<img src="'.$image.'" class="img-fluid">
										</div>
									</div>
									<div class="col col-'.$othercol.'" style="color: '.$color.';">
										<h3>'.$titre.'</h3>
										'.$description.'
									</div>
								</div>
						</div>';
						}
						endif;
					/*}*/
						$counter_slide++;
					}
					endif;
					wp_reset_postdata();	   
				}
				endwhile;	
			}
			endif;
		
		$code_html .= '</div>';
		
		if($buttons):
		{
			$code_html .= '
				<a class="carousel-control-prev bg-transparent w-aut button-l" href="#'.$id.'" role="button" data-bs-slide="prev">
					<i class="fa-regular fa-circle-arrow-left" aria-hidden="true"></i>
				</a>
				<a class="carousel-control-next bg-transparent w-aut button-r" href="#'.$id.'" role="button" data-bs-slide="next">
					<i class="fa-regular fa-circle-arrow-right" aria-hidden="true"></i>
				</a>
			';
		}
		endif;
            
		$code_html .= '</div></div></div>';

 		if($multi):
		{ 
			$code_html .='
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
				let items = document.querySelectorAll(".carousel .carousel-item")

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
			';
		}
		endif;
	
		return($code_html);
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
/*}*/