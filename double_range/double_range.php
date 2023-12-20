<?php 
function in_double_range($args = '')
{ 
	// version : 29/11/2023
	if (empty($args['min']) || empty($args)){ $min = 0; }else{ $min = $args['min']; }
	if (empty($args['max']) || empty($args)){ $max = 20; }else{ $max = $args['max']; }
	if (empty($args['id1']) || empty($args)){ $id1 = 'min'; }else{ $id1 = $args['id1']; }
	if (empty($args['id2']) || empty($args)){ $id2 = 'max'; }else{ $id2 = $args['id2']; }

	
	$code_html = '
	<div class="range">
		<div class="range-price">
			<label for="min">Carats Min</label>
			<input type="number" id="'.$id1.'" class="min form-control"  name="max" min="'.$min.'" max="'.$max.'" value="'.$min.'" step="0.01">
		</div>
		<div class="range-input">
			<input type="range" id="r'.$id1.'" class="min form-range" min="'.$min.'" max="'.$max.'" step="0.01" value="'.$min.'" oninput="rangenumber(r'.$id1.', `'.$id1.'`), rangenumber(r'.$id2.', `'.$id2.'`), breakprice(`'.$id2.'`, `'.$id1.'`)">
		</div>
		
		<div class="range-price ">
			<label for="max">Carats Max</label>
			<input type="number" id="'.$id2.'" class="max form-control"  name="max" min="'.$min.'" max="'.$max.'" value="'.$max.'" step="0.01">
		</div>
		<div class="range-input">
			<input type="range" id="r'.$id2.'" class="form-range" min="'.$min.'" max="'.$max.'" step="0.01" value="'.$max.'" oninput="rangenumber(r'.$id2.', `'.$id2.'`), breakprice(`'.$id2.'`, `'.$id1.'`)">
		</div>		
		<div class="range-slider">
			<span class="range-selected"></span>
		</div>

	</div>
	';
	return($code_html);
}