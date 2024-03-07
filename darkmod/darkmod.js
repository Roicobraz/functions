// JavaScript Document
/*!
 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
 * Copyright 2011-2024 The Bootstrap Authors
 * Licensed under the Creative Commons Attribution 3.0 Unported License.
 */

/**
* Variables modifiables
**/
	const id_js = 'darkmod-js';
	const darkmod_css_path = '/inc/darkmod/darkmod.css';

	/**
	* mod par défaut 
	**/
//	var lightmanual = false;	
//	var darkmanual = false;
/**--------------------------------------------------------**/


	const getStoredTheme = () => localStorage.getItem('theme');
	const setStoredTheme = theme => localStorage.setItem('theme', theme);
	const switcher = document.getElementById("toggleswitch");

	function geturi()
	{
		let link = document.getElementById(id_js).src;
		link = link.split('/js/');
		link = link[0];		
		return(link);
	}

	function getCookie(name) 
	{
		var dc = document.cookie;
		var prefix = name + "=";
		var begin = dc.indexOf("; " + prefix);
		if (begin == -1) {
			begin = dc.indexOf(prefix);
			if (begin != 0) return null;
		}
		else
		{
			begin += 2;
			var end = document.cookie.indexOf(";", begin);
			if (end == -1) {
			end = dc.length;
			}
		}
		// because unescape has been deprecated, replaced with decodeURI
		//return unescape(dc.substring(begin + prefix.length, end));
		return decodeURI(dc.substring(begin + prefix.length, end));
	} 

	function setDarkcss(filelink)
	{
		link = document.createElement('link');
		link.rel = 'stylesheet';
		link.id = 'darkmod';
		filelink = filelink.replace('/inc/darkmod/darkmod.js?ver=1.0.0', darkmod_css_path)
		link.href = filelink;
		document.head.appendChild(link);
	}
	
	function removeDarkcss()
	{

		linkremove = document.querySelector(`link[id~="darkmod"]`);
		if (linkremove)
		linkremove.remove();
	}

	/**
	* Retourne le thème actuel au chargement de la page
	**/
	const getPreferredTheme = () => {
		const storedTheme = getStoredTheme()
		if (storedTheme) {
			return storedTheme
		}

    	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  	}

	/**
	* Attribut au body un data-attribute
	**/
	const setTheme = theme => {
		if (theme === 'auto') {
			document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
		} else {
			document.documentElement.setAttribute('data-bs-theme', theme)
		}
	}

	/**
	* Modifie les images en fonction du thème
	**/
	const setimages = theme => {
		// Activation du changement des images ayant une version darkmod 
		let pictures = document.querySelectorAll(".img_dk");
		
		pictures.forEach((figure) => {
			let picture = figure.getElementsByTagName('img')[0];			
			var link = '';
			var extension = '';
			var not_exist = 0;
			// Récupère le format de l'image initial 		
			let formats = ['svg', 'png', 'jpeg', 'gif', "webp"]
			formats.forEach((format) => {
				if (picture.src.includes(format))
				{	
					extension = '.'+format;
					link = picture.src.split(extension);
				}
			});

			if ((getPreferredTheme()=='dark' && !theme) || theme == 'dark')
			{	
				var image = link[0].concat('','_dk'+extension);

				var url = image;
				var request = new XMLHttpRequest();
				request.open("GET", url, true);
				request.send();
				status = request.status;
				if (request.status != 200) //if(statusText == OK)
				{
					not_exist = 1;
				}
			}
			else if ((getPreferredTheme()=='light' || not_exist == 1) || theme == 'light')
			{
				if (link[0].includes('_dk'))
				{
					var link = link[0].split('_dk');
					var image = link[0].concat('', extension);
				}
				else
				{
					var image = link[0].concat('', extension);
				}
			}
			picture.src = image;
		})
	}
	
	/**
	* Fonctionnalité du bouton
	**/
	const switchertheme = (link, bool) => {
		const switcher = document.getElementById("toggleswitch");
		if(bool)
		{
			document.getElementById("switcher").style.display="none";
		}
			
		if(switcher.checked)
		{
			document.cookie = 'dk_switcher_value=1; expires="+date+"; Secure; SameSite=None";';			
			setTheme('dark');
			setimages('dark');
			setDarkcss(geturi());
		}
		else
		{
			document.cookie = 'dk_switcher_value=0; expires="+date+"; Secure; SameSite=None";';			
			setTheme('light');
			setimages('light');
			removeDarkcss();
		}
	}
	
	/**
	* Attribut au body un data-attribute équivalent au thème du navigateur au chargement
	**/
	if (document.body.contains(switcher))
	{
		if(getCookie('dk_switcher_value')==1)
		{
			switcher.checked=1;
		}
		else
		{
			switcher.checked=0;
		}

		if(switcher.checked == true)
		{
			mod = 'dark';
			setDarkcss(geturi());
		}
		else
		{
			mod = 'light';
		}
	}
	else if (getCookie("dk_switcher_value") && getCookie('dk_switcher_value')==1)
	{
		mod = 'dark';
		setDarkcss(geturi());
	}
	else
	{
		mod = 'light';
		removeDarkcss();
	}
	setTheme(mod);
	setimages(mod);

	/**
	* Initialisation des paramètres d'un switcher?
	**/
//	const showActiveTheme = (theme, focus = false) => {
//		const themeSwitcher = document.querySelector('#bd-theme')
//		console.log(themeSwitcher);
//
//		if (!themeSwitcher) {
//			return
//		}
//
//		const themeSwitcherText = document.querySelector('#bd-theme-text')		
//		console.log(themeSwitcherText);
//
//		const activeThemeIcon = document.querySelector('.theme-icon-active use')
//		console.log(activeThemeIcon);
//
//		const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
//		console.log(btnToActive);
//
//		const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')
//		console.log(svgOfActiveBtn);
//
//
//		document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
//			element.classList.remove('active')
//			element.setAttribute('aria-pressed', 'false')
//		})
//
//		btnToActive.classList.add('active')
//		btnToActive.setAttribute('aria-pressed', 'true')
//		activeThemeIcon.setAttribute('href', svgOfActiveBtn)
//		const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
//		themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)
//
//		if (focus) {
//			themeSwitcher.focus()
//		}
//	}
	
	/**
	* Change le thème de la page en fonction du thème du navigateur
	**/
	window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
		const storedTheme = getStoredTheme()
		if (storedTheme !== 'light' && storedTheme !== 'dark') {
			setTheme(getPreferredTheme());
			setimages();
		}
	})

	window.addEventListener('DOMContentLoaded', () => {
//		showActiveTheme(getPreferredTheme())

		document.querySelectorAll('[data-bs-theme-value]')
		.forEach(toggle => {
			toggle.addEventListener('click', () => {
				const theme = toggle.getAttribute('data-bs-theme-value')
				setStoredTheme(theme)
				setTheme(theme);
//				showActiveTheme(theme, true)
			})
		})
	})