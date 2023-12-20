// JavaScript Document
function rangenumber(range, number){
	/*
		- Range représente la balise input type range
		- Number entré préalablement entre guillemet représente l'id de l'input  type number sinon on récupère sa valeur
	*/
	document.getElementById(number).value = range.value;
}

function breakprice(max, min){
	let pmax = document.getElementById(max);
	let pmin = document.getElementById(min);
	
	if (Number(pmax.value) < pmin.value)
	{
		pmax.value = Number(pmin.value)+0.1;
	}
	else if ((Number(pmax.value)) == (Number(pmin.max)+0.1))
	{
		pmax.value = Number(pmin.max);
	}
//	console.log(Number(pmin.max)+0.1);
}

// Intervalle minmum entre les 2 points 
const rangeMin = 0.01;
const range = document.querySelector(".range-selected");
const rangeInput = document.querySelectorAll(".range-input input");
const rangePrice = document.querySelectorAll(".range-price input");

rangeInput.forEach((input) => {
	input.addEventListener("input", (e) => {
		const minRange = rangeInput[0].value; /* valeur du 1er range */
		const maxRange = rangeInput[1].value; /* valeur du 2nd range */
		let diff = rangeInput[0].max - rangeInput[0].min;

		if (maxRange - minRange < rangeMin) /* check de l'intervalle entre les 2 points */
		{
			if (e.target.className.includes("min")) /* l'élément ciblé a la classe min */
			{
				rangeInput[0].value = maxRange - rangeMin;
			} 
			else 
			{
				rangeInput[1].value = Number(minRange) + rangeMin;
			}
		}
		else 
		{					
			let coeff_1 = (rangeInput[0].min * 100) / diff;
			let coeff_2 = coeff_1 + 100;
			let left = ((minRange / diff) * 100) - coeff_1 + "%";
			let right =  coeff_2 - ((maxRange / diff) * 100) + "%";	
			
			range.style.left = left;
			range.style.right = right;
		}
	});
});

rangePrice.forEach((input) => {
	input.addEventListener("input", (e) => {
		const minPrice = rangePrice[0].value; /* valeur du 1er number */
		const maxPrice = rangePrice[1].value; /* valeur du 2nd range */
		
		if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
			if (e.target.className.includes("min")) {
				rangeInput[0].value = minPrice;
				range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
			} else {
				rangeInput[1].value = maxPrice;
				range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
			}
		}
		
		if(Number(minPrice) > Number(maxPrice))
	   	{
			rangePrice[1].value = Number(rangePrice[0].value) + rangeMin;
		}
	});
});