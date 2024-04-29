<?php

namespace add_on\function_cstm;

abstract class checkversion {
	private $version_php;
	private $version_wp;
	
	protected function setVersion_php(string $version) {
		$this->version_php = $version;
	}
	
	protected function setVersion_wp(string $version) {
		$this->version_wp = $version;
	}
	
	protected function getversion_php() {
		if(version_compare(phpversion(), $this->version_php, '<'))
		{
			echo('
			<code>
				Erreur version PHP : <br>
				La version de PHP est trop ancienne pour ces fonctions('.phpversion().').<br>
				La version de PHP requise est '.$this->version_php.'
			</code>');
			return(false);
		}
		elseif(version_compare(phpversion(), $this->version_php, '>'))
		{
			echo('
			<code>
				Erreur version PHP : <br>
				La version de PHP est trop récente pour ces fonctions('.phpversion().').<br>
				La version de PHP requise est '.$this->version_php.'
			</code>');
			return(false);
		}
		else
		{
			return(true);
		}
	}

	public function getversion_wp()
	{
		if(version_compare(get_bloginfo( 'version' ), $this->version_wp, '='))
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}
}