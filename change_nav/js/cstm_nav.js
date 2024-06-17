export default class change_onscroll {
// Propriétés
	#block_1;
	#block_1_id;	
	#sousblock1;
	#sousblock1_id;
	#sousblock1_class;
	#sousblock1_bg_step1;
	#sousblock1_bg_step2;
	
	
	#block_2;
	#block_2_class;	
	#block_2_step1;
	#block_2_step2;
	
	#block_breakpoint;
	#block_breakpoint_id;
	#breakpoint;

// Méthodes 
	/**
	* Setter du sous block 1
	* public setSousblock1(string) : void
	*/
	#setSousblock1(str)
	{
		this.sousblock1 = str;
	}
	
	/**
	* Getter du sous block 1
	* private getSousblock1(void) : string
	*/
	#getSousblock1()
	{
		return(this.sousblock1);
	}
	
	/**
	* Setter de la class du sous block 1
	* public setSousblock1_class(string) : void
	*/
	#setSousblock1_class(str)
	{
		this.sousblock1_class = str;
	}
	
	/**
	* Getter de la class du sous block
	* private getSousblock1_class(void) : string
	*/
	#getSousblock1_class()
	{
		return(this.sousblock1_class);
	}	
		
	/**
	* Setter de l'étape 2 du background du sous block 1
	* public setSousblock_bg_step2(string) : void
	*/
	setSousblock_bg_step2(str)
	{
		this.sousblock1_bg_step2 = str;
	}
	
	/**
	* Setter de l'étape 1 du background du sous block 1
	* public setSousblock_bg_step1(string) : void
	*/
	setSousblock_bg_step1(str)
	{
		this.sousblock1_bg_step1 = str;
	}
	
	/**
	* Setter de l'id du sous block 1
	* public setSousblock1_id(string) : void
	*/
	setSousblock1_id(str)
	{
		this.sousblock1_id = str;
	}
	
	/** 
	* Setter de l'id du block 1
	* public setBlock_1_id(string) : void
	*/
	setBlock_1_id(str)
	{
		this.block_1_id = str;
	}
	/**
	* Setter de l'id du block_breakpoint
	* public setBlock_breakpoint_id(string) : void
	*/
	setBlock_breakpoint_id(str)
	{
		this.block_breakpoint_id = str;
	}
	
	/**
	* Setter de la class du block 2
	* public setBlock_2_class(string) : void
	*/
	setBlock_2_class(str)
	{
		this.block_2_class = str;
	}
	
	/**
	* Setter de l'étape 1 du display du block 2
	* public setBlock_2_step1(string) : void
	*/
	setBlock_2_step1(str)
	{
		this.block_2_step1 = str;
	}
	
		
	/**
	* Setter de l'étape 2 du display du block 2
	* public setBlock_2_step2(string) : void
	*/
	setBlock_2_step2(str)
	{
		this.block_2_step2 = str;
	}
	
	/**
	* Getter la 1ère étape du background du sous block 1
	* private getSousblock_bg_step2(void) : string
	*/
	#getSousblock_bg_step2()
	{
		return(this.sousblock1_bg_step2);
	}

	/**
	* Getter la 2nde étape du background du sous block 1
	* private getSousblock_bg_step1(void) : string
	*/
	#getSousblock_bg_step1()
	{
		return(this.sousblock1_bg_step1);
	}	
	
	/**
	* Getter du sous block 1
	* private getSousblock1_id(void) : string
	*/
	#getSousblock1_id()
	{
		return(this.sousblock1_id);
	}

	/**
	* Setter du block 1
	* private setBlock_1(string) : void
	*/
	#setBlock_1(str)
	{
		this.block_1 = str;
	}
	
	/**
	* Getter du block 1
	* private getBlock_1(void) : string
	*/
	#getBlock_1()
	{
		return(this.block_1);
	}
	
	/**
	* Getter de l'id block 1
	* private getBlock_1_id(void) : string
	*/
	#getBlock_1_id()
	{
		return(this.block_1_id);
	}
	
	/**
	* Setter du block 2
	* public setBlock_2(string) : void
	*/
	#setBlock_2(str)
	{
		this.block_2 = str;
	}
	
	/**
	* Getter du block 2
	* private getBlock_2(void) : string
	*/
	#getBlock_2()
	{
		return(this.block_2);
	}
	
	/**
	* Getter de la class du 2nd block
	* private getBlock_2_class(void) : string
	*/
	#getBlock_2_class()
	{
		return(this.block_2_class);
	}
	
	/**
	* Getter de l'étape 1 du block 2
	* private getBlock_2_step1(void) : string
	*/
	#getBlock_2_step1()
	{
		return(this.block_2_step1);
	}
	
	/**
	* Getter de l'étape 2 du block 2
	* private getBlock_2_step2(void) : string
	*/
	#getBlock_2_step2()
	{
		return(this.block_2_step2);
	}
	
	/**
	* Setter du block_breakpoint
	* public setBlock_breakpoint(string) : void
	*/
	#setBlock_breakpoint(str)
	{
		this.block_breakpoint = str;
	}
	
	/**
	* Getter du block_breakpoint
	* private getBlock_breakpoint(void) : string
	*/
	#getBlock_breakpoint()
	{
		return(this.block_breakpoint);
	}
	
	/**
	* Getter de l'id du block_breakpoint
	* private getBlock_breakpoint_id(void) : string
	*/
	#getBlock_breakpoint_id()
	{
		return(this.block_breakpoint_id);
	}

	/**
	* Setter du breakpoint
	* private setBreakpoint(string) : void
	*/
	#setBreakpoint(str)
	{
		this.breakpoint = str;
	}
	
	/**
	* Getter du breakpoint
	* private getBreakpoint(void) : string
	*/
	#getBreakpoint()
	{
		return(this.breakpoint);
	}
	
	/**
	* Modifie le style des deux block en fonction du scroll et du breakpoint
	* private event_onresize(void) : void
	*/
	#event_onscroll ()
	{
		if(window.scrollY > this.#getBreakpoint())
		{
			this.#getBlock_2().style.display = this.#getBlock_2_step2();
			this.#getBlock_1().style.background = this.#getSousblock_bg_step2();
		}
		else
		{
			this.#getBlock_2().style.display = this.#getBlock_2_step1();
			this.#getBlock_1().style.background = this.#getSousblock_bg_step1();
		}
	}
	
	/**
	* Mets à jour au changement de taille de la fenêtre la valeur désignant le bas du block qui sert de délimiteur pour pour l'action
	* private event_onresize(void) : void
	*/
	#event_onresize () 
	{
		this.#setBreakpoint(this.#getBlock_breakpoint().offsetTop + this.#getBlock_breakpoint().offsetHeight);
	}
	
  	/**
	* set des propriété et des events
	* public nav_change_onscroll(void) : void
	*/
	nav_change_onscroll()
	{
		this.#setBlock_1(document.getElementById(this.#getBlock_1_id()));
		this.#setSousblock1(document.getElementById(this.#getSousblock1_id()));
		this.#setSousblock1_class(this.#getSousblock1().attributes.class.value);

		this.#setBlock_breakpoint(document.getElementById(this.#getBlock_breakpoint_id()));
		this.#setBreakpoint(this.#getBlock_breakpoint().offsetTop + this.#getBlock_breakpoint().offsetHeight);
		this.#setBlock_2(document.getElementsByClassName(this.#getBlock_2_class())[0]);

		this.#getBlock_2().style.display = this.#getBlock_2_step1();
		this.#getBlock_1().style.background = this.#getSousblock_bg_step1();

		window.addEventListener('scroll', () => {this.#event_onscroll()});
		window.addEventListener('resize', () => {this.#event_onresize()});
	}
}