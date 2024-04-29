<?php

namespace add_on\function_cstm\wordpress;


use add_on\function_cstm\checkversion;


class wp_functions extends checkversion {
	private $dependence;
	
	public $title;
	public $classname;
	public $content;
	public $target;
	public $posts_per_page;
	public $post_type;
	
	public function __construct() {
		$this->setVersion_php('8.2.5');
	 	$this->setVersion_wp('6.5.2');
	 	$this->dependence = $this->getversion_php();
	}
	
	public function cstm_get_permalink(array $args)
	{
		//	version : 29/04/2024
		if(!empty($args['title']))
		{ $this->title = $args['title']; }
		else
		{ return('<code>Erreur  : Titre ou id du post manquant.</code>'); }
		
		if(!empty($args['classname']))
		{ $this->classname = $args['classname']; }
		else
		{ $this->classname = ""; }
		
		if(!empty($args['content']))
		{ $this->content = $args['content']; }
		else
		{ $this->content = ''; }
		
		if(!empty($args['target']))
		{ $this->target = $args['target']; }
		else
		{ $this->target = 0; }
		
		if(!empty($args['posts_per_page']))
		{ $this->posts_per_page = $args['posts_per_page']; }
		else
		{ $this->posts_per_page = 1; }
		
		if(!empty($args['post_type']))
		{ $this->post_type = $args['post_type']; }
		else
		{ $this->post_type = "page"; }
		
		if(is_int($this->title)):
		{
			$query = new \WP_Query(array('post_type' => $this->post_type,'posts_per_page' => $this->posts_per_page,'p'  => $this->title));
		}
		elseif(is_string($title)):
		{
			$query = new \WP_Query(array('post_type' => $this->post_type,'posts_per_page' => $this->posts_per_page,'s'  => $this->title));
		}
		endif;
		
		if ($this->target == 1):
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
				if(empty($this->content)):
				{
					$this->content = get_the_title();
				}
				endif;
				$site_info .= '<a class="'.$this->classname.'" '.$blank.' href="'.get_permalink().'">'.$this->content.'</a>';
			}
			endwhile;
		}
		endif;
		return($site_info);
	}
}