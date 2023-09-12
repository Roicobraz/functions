// JavaScript Document

const mod = localStorage.getItem('theme');

const getPreferredmod = () => {
	if (mod) 
	{
		return mod
	}

	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

const setmod = function (mod) 
{	
	// Activation du darkmod CSS  
	var x = document.getElementsByTagName("BODY")[0]; 
	x.setAttribute("id",(get_color_scheme()));//<---class CSS pour le darkmod 
	
	
	// Activation du changement des images ayant une version darkmod 

	var picture = document.querySelectorAll(".custom-logo")[0];
	
//	picture.forEach(myFunction);	
//	function myFunction(picture) 
//	{
		var link = '';
		var extension = '';
		var not_exist = 0;
		// Récupère le format de l'image initial 		
		let formats = ['svg', 'png', 'jpeg', 'gif']
		formats.forEach((format) => { 
			if (picture.src.includes(format))
			{	
				extension = '.'+format
				link = picture.src.split(extension);
				return;
			}
		});

		if (get_color_scheme()=='dark')
		{	
			var image = link[0].concat('','-darkmod'+extension);

//			var url = image;
//			var request = new XMLHttpRequest();
//			request.open("GET", url, true);
//			request.send();
//			status = request.status;
//			if (request.status != 200) //if(statusText == OK)
//			{
//				not_exist = 1;
//			}
		}
		if (get_color_scheme()=='light' || not_exist == 1)
		{
			if (link.includes('-darkmod'))
			{
				var link = link[0].split('-darkmod');
				var image = link[0].concat('', extension);
			}
			else
			{
				var image = link[0].concat('', extension);
			}
		}
		picture.src = image;
	}
//}
setmod(getPreferredmod())

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
	if (mod !== 'light' || mod !== 'dark') 
	{
		setmod(getPreferredmod())
	}
})