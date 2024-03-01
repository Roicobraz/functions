<?php 

class model {
//propriété
	private $bdd;
//méthode
	protected function executerRequete($sql, $params = null) 
	{
		if ($params == null)
		{
			$resultat = $this->getBdd()->query($sql); // exécution directe
		}
		else 
		{
			$resultat = $this->getBdd()->prepare($sql);  // requête préparée
			$resultat->execute($params);
		}
		return $resultat;
	}
	
	private function getBdd() 
	{
        if ($this->bdd == null) 
		{
            // Création de la connexion
            $this->bdd = new PDO('mysql:host='.$GLOBALS['settings']['database']['host'].'; dbname='.$GLOBALS['settings']['database']['dbname'].'; charset=utf8',             $GLOBALS['settings']['database']['user'], $GLOBALS['settings']['database']['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return $this->bdd;
    }
}