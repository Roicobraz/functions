<?php

/* Dépendance Bootstrap {
/*----------------------------------------------*/
/*					Carousel					*/
/*----------------------------------------------*/
function bs_carousel($args)
	{
		//	version: 05/01/2024 ACF Pro Bt
	
		if(!empty($args['repeater']))		{$repeater 			= $args['repeater'];}
		if(!empty($args['id']))				{$id 				= $args['id'];}
		if(!empty($args['buttons']))		{$buttons			= $args['buttons'];}
		if(!empty($args['multi']))			{$multi 			= $args['multi'];}
		if(!empty($args['template']))		{$template 			= $args['template'];}
		if(!empty($args['colonage']))		{$colonage 			= $args['colonage'];}
		if(!empty($args['taxonomie']))		{$taxonomie 		= $args['taxonomie'];}
		if(!empty($args['nombre_de_post']))	{$nombre_de_post 	= $args['nombre_de_post'];}
		
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
			echo ('<strong>&#9888; Aucun contenu.</strong> Veuillez remplir le champ ACF répéteur Objet.');
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