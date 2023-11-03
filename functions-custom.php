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

/* Dépendance Bootstrap {
/*----------------------------------------------*/
/*					Carousel					*/
/*----------------------------------------------*/
	function bs_carousel($args)
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

/*----------------------------------------------*/
/*					Accordéon					*/
/*----------------------------------------------*/
	function bs_accordeon($args)
	{
		//	version: 03/11/2023 Bt
		// Valeurs {
		if(empty($args['id'])):
		{
			$id = rand();
		}
		else:
		{
			$title	= $args['id'];
		}
		endif;

		if(empty($args['title'])):
		{
			$title = '...';
		}
		else:
		{
			$title	= $args['title'];
		}
		endif;

		if(empty($args['content'])):
		{
			$content = '...';
		}
		else:
		{
			$content= $args['content'];
		}
		endif;
		//}

		$code_html = '
		<div id="'.$id.'" class="acf-accordeon">
			<div class="accordion" id="accordion_'.$id.'">
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading_'.$id.'">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_'.$id.'" aria-expanded="true" aria-controls="collapse'.$id.'">
							'.$title.'
						</button>
					</h2>
					<div id="collapse_'.$id.'" class="accordion-collapse collapse" aria-labelledby="heading_'.$id.'" data-bs-parent="#accordion_'.$id.'">
						<div class="accordion-body">
							'.$content.'
						</div>
					</div>
				</div>
			</div><!-- accordeon -->';

		return($code_html);
	}

/*------------------------------------------*/
/*					Card					*/
/*------------------------------------------*/
	function bs_card($title = '', $image = '', $description, $link = '#', $button = '',$test = '')
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
	function bs_scrollspy_start($nav_id = "navbar-example3")
	{
		//	version: 12/09/2023 Bt
		$code_html = 'data-bs-spy="scroll" data-bs-target="#'.$nav_id.'" data-bs-smooth-scroll="true" data-bs-root-margin="0px 0px -50%" class="scrollspy-example-2" tabindex="0"';
		
		echo($code_html);
	}

	function bs_scrollspy($nav_menu)
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

/*------------------------------------------*/
/*					Input					*/
/*------------------------------------------*/
function in_range($min = 0, $max = 20, $id1 = 'min')
{ 
	// version : 03/11/2023
	$code_html = '
	<div class="range row">
		<div class="range-slider">
			<span class="range-selected"></span>
		</div>
		<div class="range-input col">
			<input type="range" min="'.$min.'" max="'.$max.'" step="0.01" value='.$min.' oninput="document.getElementById(`'.$id1.'`).value = this.value">
		</div>
		<div class="range-price col">
			<label for="min">Min</label>
			<input type="number" class="form-control" id="'.$id1.'" name="min" min="'.$min.'" value="'.$min.'" step="0.01">
		</div>
	</div>
	<style>
		.range-slider
		{
			height: 5px;
			position: relative;
			background-color: #e1e9f6;
			border-radius: 2px;
			width: 15rem;
			margin: auto;
		}

		.range-selected 
		{
			height: 100%;
			left: 0%;
			right: 0%;
			position: absolute;
			border-radius: 5px;
			background-color: #343a40;
		}

		.range-input
		{
			position: relative;
			margin: auto;
		}

		.range-input input 
		{
			position: absolute;
			width: 15rem;
			height: 5px;
			top: -2.5px;
			left: -15rem;
			background: none;
			pointer-events: none;
			-webkit-appearance: none;
			-moz-appearance: none;
			
		}

		.range-input input::-webkit-slider-thumb 
		{
			height: 20px;
			width: 20px;
			border-radius: 50%;
			border: 3px solid #343a40;
			background-color: #fff;
			pointer-events: auto;
			-webkit-appearance: none;
		}

		.range-input input::-moz-range-thumb 
		{
			height: 15px;
			width: 6px;
			border-radius: 20%;
			border: 2px solid #343a40;
			background-color: #d1d2d8;
			pointer-events: auto;
			-moz-appearance: none;
			cursor: ew-resize;
		}
		
		.range-input input::-moz-range-thumb:active
		{
			background-color: #a0d9ed;
		}

		.range-price 
		{
			width: 100%;
			display: flex;
			align-items: center;
			margin: 1rem 0rem;
		}

		.range-price label 
		{
			margin-right: 5px;
		}

		.range-price input 
		{
			width: 5rem;
			padding: 5px;
		}

		.range-price input:first-of-type 
		{
			margin-right: 15px;
		}
	</style>
<!-- Intervalle minmum entre les 2 points -->
	<script>
		let rangeMin = 0.01;
		const range = document.querySelector(".range-selected");
		const rangeInput = document.querySelectorAll(".range-input input");
		const rangePrice = document.querySelectorAll(".range-price input");

		rangeInput.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minRange = rangeInput[0].value;
				let maxRange = rangeInput[1].value;
				if (maxRange - minRange < rangeMin) {
					if (e.target.className === "min") {
						rangeInput[0].value = maxRange - rangeMin;
					} else {
						rangeInput[1].value = minRange + rangeMin;
					}
				} else {
					range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
					range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
				}
			});
		});

		rangePrice.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minPrice = rangePrice[0].value;
				let maxPrice = rangePrice[1].value;
				if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
					if (e.target.className === "min") {
						rangeInput[0].value = minPrice;
						range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
					} else {
						rangeInput[1].value = maxPrice;
						range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
					}
				}
			});
		});
	</script>
	';
	return($code_html);
}

function in_double_range($min = 0, $max = 20, $id1 = 'min', $id2 = 'max')
{ 
	// version : 03/11/2023
	$code_html = '
	<div class="range row">
		<div class="range-slider">
			<span class="range-selected"></span>
		</div>
		<div class="range-input col">
			<input type="range" min="'.$min.'" max="'.$max.'" step="0.01" value='.$min.' oninput="document.getElementById(`'.$id1.'`).value = this.value">
			<input type="range" min="'.$min.'" max="'.$max.'" step="0.01" value='.$max.'
			oninput="document.getElementById(`'.$id2.'`).value = this.value">
		</div>
		<div class="range-price col">
			<label for="min">Min</label>
			<input type="number" class="form-control" id="'.$id1.'" name="min" min="'.$min.'" value="'.$min.'" step="0.01">
			<label for="max">Max</label>
			<input type="number" class="form-control" id="'.$id2.'" name="max" max="'.$max.'" value="'.$max.'" step="0.01">
		</div>
	</div>
	<style>
		.range-slider
		{
			height: 5px;
			position: relative;
			background-color: #e1e9f6;
			border-radius: 2px;
			width: 15rem;
			margin: auto;
		}

		.range-selected 
		{
			height: 100%;
			left: 0%;
			right: 0%;
			position: absolute;
			border-radius: 5px;
			background-color: #343a40;
		}

		.range-input
		{
			position: relative;
			margin: auto;
		}

		.range-input input 
		{
			position: absolute;
			width: 15rem;
			height: 5px;
			top: -2.5px;
			left: -15rem;
			background: none;
			pointer-events: none;
			-webkit-appearance: none;
			-moz-appearance: none;
			
		}

		.range-input input::-webkit-slider-thumb 
		{
			height: 20px;
			width: 20px;
			border-radius: 50%;
			border: 3px solid #343a40;
			background-color: #fff;
			pointer-events: auto;
			-webkit-appearance: none;
		}

		.range-input input::-moz-range-thumb 
		{
			height: 15px;
			width: 6px;
			border-radius: 20%;
			border: 2px solid #343a40;
			background-color: #d1d2d8;
			pointer-events: auto;
			-moz-appearance: none;
			cursor: ew-resize;
		}
		
		.range-input input::-moz-range-thumb:active
		{
			background-color: #a0d9ed;
		}

		.range-price 
		{
			width: 100%;
			display: flex;
			align-items: center;
			margin: 1rem 0rem;
		}

		.range-price label 
		{
			margin-right: 5px;
		}

		.range-price input 
		{
			width: 5rem;
			padding: 5px;
		}

		.range-price input:first-of-type 
		{
			margin-right: 15px;
		}
	</style>
<!-- Intervalle minmum entre les 2 points -->
	<script>
		let rangeMin = 0.01;
		const range = document.querySelector(".range-selected");
		const rangeInput = document.querySelectorAll(".range-input input");
		const rangePrice = document.querySelectorAll(".range-price input");

		rangeInput.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minRange = rangeInput[0].value;
				let maxRange = rangeInput[1].value;
				if (maxRange - minRange < rangeMin) {
					if (e.target.className === "min") {
						rangeInput[0].value = maxRange - rangeMin;
					} else {
						rangeInput[1].value = minRange + rangeMin;
					}
				} else {
					range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
					range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
				}
			});
		});

		rangePrice.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minPrice = rangePrice[0].value;
				let maxPrice = rangePrice[1].value;
				if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
					if (e.target.className === "min") {
						rangeInput[0].value = minPrice;
						range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
					} else {
						rangeInput[1].value = maxPrice;
						range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
					}
				}
			});
		});
	</script>
	';
	return($code_html);
}

function in_checkbox($values, $filter)
{
	// version : 03/11/2023
	$code_html ='<fieldset class="checkbox">';
	
	foreach( $values as $value_term ):
	{
		$code_html .= '
		<div class="elements">
			 <input type="checkbox" id="'.$value_term.'" name="'.$filter.'" value="'.$value_term.'">
			<label for="'.$value_term.'">'.$value_term.'</label>
		</div>';
	}
	endforeach;
	
	$code_html .= '
		</fieldset>
		
		<style>
			.checkbox
			{
				display: grid;
				grid-template-columns: repeat(5, 1fr);
				grid-auto-rows: minmax(0.5rem, auto);
			}
			
			.elements
			{
				background-color: rgba(255, 255, 255, 0.8);
				border: 1px solid rgba(0, 0, 0, 0.8);
				padding: 5px;
			}
		</style>
	';
	return($code_html);
}

function in_dropdown($values, $filter)
{
	// version : 03/11/2023
	$code_html = '
		<select id="'.$filter.'" name="'.$filter.'">
			<option value="">-- Par défaut --</option>';
	
	foreach( $values as $value_term ):
	{
		$code_html .= '
			<option value="'.$value_term.'">'.$value_term.'</option>';
	}		
	endforeach;
	
	$code_html .= '
		</select>
		
		<style>
			select
			{
				border: #d1d2d8 1px solid;
				background: #d1d2d8;
				border-radius: 7px;
				color: #0a0c18;
				padding: 0.5rem;
				height: fit-content;
  				margin: auto;
			}
		</style>
	';

	return($code_html);
}

function in_radio($values, $filter )
{
	// version : 03/11/2023
	$code_html = '<fieldset>';
	
	foreach( $values as $value_term ):
	{
		$code_html .= '
		<div>
			<input type="radio" id="'.$value_term.'" name="'.$filter.'" value="'.$value_term.'" />
			<label for="'.$value_term.'">'.$value_term.'</label>
		</div>';
	}
	endforeach;
	$code_html .= '</fieldset>';
	
	return($code_html);
}

/*}*/

/* Filtre {
/*---------------- PREGET : product -----------------------------------------*/
function productquery( $query ) {
    //if ( ! is_admin() && $query->is_post_type_archive('product') || ! is_admin() && $query->is_tax('category_product') && $query->is_main_query() ) {}
    if ( $query->is_main_query() && $query->is_post_type_archive('product') || $query->is_main_query() && $query->is_tax('category_product')  ) 
	{
		//$query->set( 'posts_per_page', '1' );
		//$query->set('order','ASC');
		$query->set('order','DESC');
		$query->set('orderby','meta_value_num');
		$query->set('meta_key','carat');
		//$query->set('meta_type','CHAR');
		$query->set('posts_per_page', 24);		

		// Ne pas afficher les evenements passés
		$couleur = get_query_var( 'couleur' );
		if ($couleur != "" ) 
		{
			$query->set( 'meta_query', 
				array(array(
				'key'     => 'couleur',
				'value'   => $couleur,
				'compare' => 'LIKE',
				)
			) 
		   );	
		}
		
		$shape = get_query_var( 'shape' );
		if ($shape != "" ) 
		{
			$query->set( 'tax_query', 
				array(
					'relation' => 'AND',
					array(
						'taxonomy' 	=> 'category_product', 
						'field'		=> 'slug', 
						'terms'		=> 'saphirs-de-couleurs',
					),
					array(
						'taxonomy'	=> 'shape_product',
						'field'		=> 'slug',
						'terms'		=> $shape,
						'compare' 	=> '=',
					)
				) 
		   );	
		}
		
		
		$min = get_query_var( 'min' );
		$max = get_query_var( 'max' );
		if ($min != "" || $max != "" ) 
		{
			$query->set( 'meta_query', 
				array(
					'relation' => 'AND', 
					array(
						'key' => 'carat',
						'value' => $min, 
						'compare'  => '>=',
						'type' => 'DECIMAL(4,2)'
					), 
					array(
						'key' => 'carat', 
						'value' => $max, 
						'compare'  => '<=',
						'type' => 'DECIMAL(4,2)'
					)
				)
			);
		}		
    }
}
add_action( 'pre_get_posts', 'productquery' );

// DECLARATION D'UN PARAMETRE GET -------------------------------------------
add_filter( 'query_vars', function( $query_vars_shape ) {
	$query_vars_shape[] = 'shape';
	return $query_vars_shape;
} );
// --------------------------------------------------------------------------

function create_filter_color() 
{	
	if ( is_tax('category_product') ) 
	{
		$term = get_queried_object();

		/*			 Get color			 */
		/*{
		// Recup du get COLOR
		$get_couleur = get_query_var( 'couleur' );		

		$args['post_type'] = 'product';
		// Je cible uniquement le terme actuel
		$args['tax_query'] = array(	array('taxonomy' => 'category_product', 'field' => 'slug', 'terms' => $term->slug));

//		 Récupère les information du champ via son slug et l'ID de la page 
		$field = get_field_object('couleur', 2131)['choices'];
		echo'<p id="filter_couleur">filtre de couleur :';
		foreach ($field as $color):
		{
			if ($color != 'Autre'):
			{
				if($get_couleur == $color):
				{
					echo '<a href="?couleur='.$color.'" class="btn btn-dark btn-sm mx-1">'.$color.'</a>';
					break;
				}
				elseif($get_couleur == null):
				{
					$args['meta_query'] = array('key' => 'couleur', 'value' => $color, 'compare'  => 'LIKE');

					$query = new WP_Query($args);
//					print_r($query);

					$count = $query->found_posts;	

					if ($count > 0):
					{
						$term_id = $term->term_id;
						$term_link = get_term_link($term_id);

						echo '<a href="'.$term_link.'?couleur='.$color.'" class="btn btn-dark btn-sm mx-1">'.$color.'</a>';
					}
					endif;
				}
				endif;
			}
			endif;
		}
		endforeach;
		wp_reset_postdata();
	/*}*/
		
		/* 			Get carat			 */
		/*{*/
			$get_carat_min = get_query_var( 'min' );
			$get_carat_max = get_query_var( 'max' );

			if ( !str_contains($_SERVER['REQUEST_URI'], '?min') ):
			{
				$term = get_queried_object(); // page actuelle
				$termslug = $term->slug;
			}
			else:
			{
				$uri = explode( '/', $_SERVER['REQUEST_URI'] );
				$termslug = $uri[3];
			}
			endif;

			// Je cible uniquement le terme actuel
			$args_carat['post_type'] = 'product';
			$args_carat['posts_per_page'] = 999;
			$args_carat['tax_query'] = array(array('taxonomy' => 'category_product', 'field' => 'slug', 'terms' => $termslug));

			$query_carat = new WP_Query($args_carat);
			$carats= array();
			if ( $query_carat ) :
			{
				while ( $query_carat->have_posts() ) :
				{
					$query_carat->the_post();
					$crt = get_field_object('carat', get_the_id())['value'];

					if( !in_array($crt, $carats) ):
					{
						array_push($carats, $crt);
					}
					endif;
				}
				endwhile; 
			}
			endif;	
//			print_r($carats);
						
			// Valeurs minimale et maximale des inputs
			$min = min($carats);
			$max = max($carats);

			$args_carat['meta_query'] = array(
				'relation' => 'AND', 
				array(
					'key' => 'carat',
					'value' => $min, 
					'compare'  => '>=',
					'type' => 'DECIMAL(4,2)'
				), 
				array(
					'key' => 'carat', 
					'value' => $max, 
					'compare'  => '<=',
					'type' => 'DECIMAL(4,2)'
				)
			);

			$query_carat = new WP_Query($args_carat);
//			print_r($query_carat);
			wp_reset_postdata();
		/*}*/
		
		/*			Get shape			 */
		/*{*/
			$args_shape['post_type'] = 'product';
			$args_shape['posts_per_page'] = 999;
			$args_shape['tax_query'] = 
				array(
					array(
						'taxonomy' 	=> 'category_product', 
						'field'		=> 'slug', 
						'terms'		=> $term
					));
		
			$query_shape = new WP_Query($args_shape);
		
			if( $query_shape->have_posts() ):
			{
				$shapes = array();
				while( $query_shape->have_posts() ):
				{
					$query_shape->the_post();	
					$shape_term = get_the_terms( get_the_ID(), 'shape_product' );
					$shape_term = $shape_term[0];
					$shape_term = $shape_term->name;

					if(!in_array($shape_term, $shapes)):
					{ 
						array_push($shapes, $shape_term);
					}
					endif;
				}
				endwhile;
				wp_reset_postdata();
			}
			endif;
		
			$args_shape['tax_query'] = 
					array(
						'relation' => 'AND',
						array(
							'taxonomy' 	=> 'category_product', 
							'field'		=> 'slug', 
						),
						array(
							'taxonomy'	=> 'shape_product',
							'field'		=> 'slug',
							'terms'		=> $shape_term,
							'compare' 	=> 'LIKE',
						)
				);
			$query_shape = new WP_Query($args_shape);
		/*}*/
		
		$code_html = '		
			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Recherches avancées +
						</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapsed show" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<form method="get" action="">
							<div class="input_button">
								<div class="input_filter">
									<span class="in_title">Carats&nbsp;:&nbsp;</span>
									'.in_double_range($min, $max).'	
								</div>	
								<div class="input_filter">
									<span class="in_title">Forme&nbsp;:&nbsp;</span>
									'.in_dropdown($shapes).'						
								</div>
							</div>
							<div class="input_button">
								<div class="in_btn">
									<input class="btn btn-sm" type="submit">
								</div>
							';
						// Bouton pour desactiver le filtre GET actif
						if ( /*$get_couleur != "" ||*/ $get_carat_min != "" || $get_carat_max != "" ):
						{
						$code_html .= '
								<div class="in_btn">
									<a href="./" class="btn btn-dark btn-sm">X supprimer les filtres</a>
								</div>';
						}
						endif;
		$code_html .= '		</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<style>
			.input_button
			{
				display: flex;
  				flex-wrap: wrap;
				margin-bottom: 0.5rem;
			}
			
			.input_filter
			{
				display: flex;
			}

			.in_title, .range
			{
				margin: auto;
			}
			
			.in_btn
			{
				display: flex;
				padding: 0 0.5rem;
			}
			
			.in_btn input, .in_btn input:hover
			{
				background: #a0d9ed;
			}
		</style>
		';
		
		echo($code_html);
	}
}
add_action('wh_hook_before_container_loop', 'create_filter_color');
/*}*/
