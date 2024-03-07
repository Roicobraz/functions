<?php
function sc_dk_switcher($atts) 
	{
		$atts = shortcode_atts(
			array(
				'default' => 'light',
				'display' => '',
			),
		$atts, 'dk_switcher' );
				
		if ($atts['default'] == 'light')
		{
			$mod = 0;
		}
		elseif ($atts['default'] == 'dark')
		{  
			$mod = 1;
		} 
				
		$firstvisit = false;
		$firstmodif = false;
		
		if ($atts['display'] == 'always')
		{ 
			$displaymod = 'block';
		} 
		elseif ($atts['display'] == 'firstvisit')
		{
			$firstvisit = true;
			$displaymod = 'block';
		}
		elseif ($atts['display'] == 'firstmodif')
		{
			$firstmodif = true;
			$displaymod = 'block';
		}
		
		$code_html = '
		<style>
			#switcher
			{
				display: '.$displaymod.';
			}
			
			.btn-toggle
			{
				display: flex;
				align-items: center !important;
			}

			.switch 
			{
				position: relative;
				display: inline-block;
				width: 60px;
				height: 34px;
			}

			.switch input 
			{
				opacity: 0;
				width: 0;
				height: 0;
			}

			.slider 
			{
				position: absolute;
				cursor: pointer;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background-color: #ccc;
				-webkit-transition: 0.4s;
				transition: 0.4s;
			}

			.slider:before 
			{
				position: absolute;
				content: /*"\00263C"*/ "\00263E";
				height: 26px;
				width: 26px;
				left: 4px;
				bottom: 4px;
				background-color: white;
				-webkit-transition: 0.4s;
				transition: 0.4s;
			}

			input:checked + .slider 
			{
				background-color: #000;
			}

			input:focus + .slider 
			{
				box-shadow: 0 0 1px #000;
			}

			input:checked + .slider:before 
			{
				-webkit-transform: translateX(26px);
				-ms-transform: translateX(26px);
				transform: translateX(26px);
			}

			/* Rounded sliders */
			.slider.round 
			{
				border-radius: 34px;
			}

			.slider.round:before 
			{
				border-radius: 50%;
			}
		</style>

		<div id="switcher">
			<div id="btn-toggle">
				<h3 class="">Switch color</h3>
				<label class="switch">
					<input id="toggleswitch" type="checkbox" onclick="switchertheme(`'.get_template_directory_uri().'`, '.$firstmodif.')">
					<span class="slider round"></span>
				</label> 
			</div>
		</div>

		<script>
			document.getElementById("toggleswitch").checked = '.$mod.';
			let date = new Date(Date.now() + 3600000);
			date = date.toUTCString();
			';
		
			if ($firstvisit)
			{ 
				$code_html .='	
				var dc = document.cookie;
				var prefix = "dk_switcher_modified" + "=";
				var begin = dc.indexOf("; " + prefix);
				if (begin == -1) {
					begin = dc.indexOf(prefix);
				}
				else
				{
					begin += 2;
					var end = document.cookie.indexOf(";", begin);
					if (end == -1) {
					end = dc.length;
					}
				}
				first = decodeURI(dc.substring(begin + prefix.length, end));
			
				if(first)
				{
					document.getElementById("switcher").style.display="none";
				}
				
				document.cookie = "dk_switcher_modified=1; expires="+date+"; Secure; SameSite=None";
				';
			}
		
		$code_html .='</script>';

		return($code_html);
	}
	add_shortcode ( 'dk_switcher', 'sc_dk_switcher');