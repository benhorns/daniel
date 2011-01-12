<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Horizontal Format
*
* Exhbition format
* Originally created for SharoneLifschitz.com
* 
* @version 1.1
* @author Vaska 
*/

$DO = new Horizontally;

$exhibit['exhibit'] = $DO->createExhibit();
$exhibit['dyn_css'] = $DO->dynamicCSS();

class Horizontally
{
	// PADDING AND TEXT WIDTH ADJUSTMENTS UP HERE!!!
	var $picture_block_padding_right = 115;
	var $text_width = 450;
	var $text_padding_right = 75;
	var $final_img_container = 0; // do not adjust this one
	
	function createExhibit()
	{
		$OBJ =& get_instance();
		global $rs;
	
		$pages = $OBJ->db->fetchArray("SELECT * 
			FROM ".PX."media, ".PX."objects_prefs 
			WHERE media_ref_id = '$rs[id]' 
			AND obj_ref_type = 'exhibit' 
			AND obj_ref_type = media_obj_type 
			ORDER BY media_order ASC, media_id ASC");

		if (!$pages) return $rs['content'];
	
		$s = ''; $a = ''; $w = 0;
		$this->final_img_container = ($rs['content'] != '') ? ($this->text_padding_right + $this->text_width) : 0;

		foreach ($pages as $go)
		{
			$title = ($go['media_title'] == '') ? '' : "<div class='title'>" . $go['media_title'] . "</div>";
			$title .= ($go['media_caption'] == '') ? '' : "<div class='caption'>" . $go['media_caption'] . "</div>";
		
			$temp_x = $go['media_x'] + $this->picture_block_padding_right;
			$this->final_img_container += ($go['media_x'] + $this->picture_block_padding_right);
		
			$a .= "<div class='picture_holder' style='width: {$temp_x}px;'>\n";
			$a .= "<div class='picture' style='width: {$go[media_x]}px;'>\n";
			$a .= "<img src='" . BASEURL . GIMGS . "/$go[media_file]' width='$go[media_x]' height='$go[media_y]' alt='" . BASEURL . GIMGS . "/$go[media_file]' />\n";
			$a .= "<div class='captioning'>$title</div>\n";
			$a .= "</div>\n";
			$a .= "</div>\n\n";
		}

		$s .= "<div id='img-container'>\n";
		if ($rs['content'] != '') $s .= "<div id='text'>" . $rs['content'] . "</div>\n";
		$s .= $a;
		$s .= "<div class='endtext'><em>Plume</em> was funded through two print sales in the summers of 2009 and 2010. Many people supported me in this work, either by buying prints, blogging the sale, or putting me up while I was on the road. The work could not have been made without the following people, many of which are fellow artists and photographers:
</br></br>
Zachary Allen, Caitlin Arnold, Alis Atwell, Peter Baker, Gabriel Benaim, Aaron Bernstein, Jake Berry, Ramsey Beyer, Toby Blyth, Richard Boutwell, David Bram, Timothy Briner, Sam Brodie, Erin Chrest, Matthew Cox, Chris DiPietro, Geoffrey Ellis, Rachel Fauber, Lucas Fogalia, Alex Foucre-Stimes, Sahadeva Hammari, Paul Harnik, Peter Hoffman, Ben Horns, Matt Johnston, Ari Kermaier, Joe Leavenworth, Cesar Llacuna, Ian Maclellan, Steve Mardenfeld, Kurt Mars, Roger May, Shawn May, Michael McCraw, Jeremy Mlodi, Tucker O' Brien, Cindy Parker, Ryan Paternite, Greg Ruben, David Schalliol, Bryan Schutmaat, Brian and Martina Shea, Patrick Sheehan, Thomas Sibley, Christopher Simpson, Martial Soucaze-Guillous, George Slade, Rafael Soldi, Andrew Spear, Nolen Strals, Mel Trittin, Rick Valicenti, Noah Vaughn, Laurence Vecten, Ben Walton, Elisa Young, Katherine Zeltner, Jin Zhu.
</br></br>
Thank you. </br></br>
<div class='text'><a href='http://www.dsheaphoto.net/index.php?/prints/'>Prints are still available form these sales</a>. All money goes towards exhibition costs and future projects.</div></div>";
		$s .= "<div style='clear: left;'><!-- --></div>";
		$s .= "</div>\n";
		
		return $s;
	}


	function dynamicCSS()
	{
		return "#img-container { width: " . ($this->final_img_container + 450) . "px; padding-right: 75px; text-align: justify;  }
#img-container #text { float: left; width: 600px" . ($this->text_width + $this->text_padding_right) . "px; padding-right: 75px; text-align: justify; }
#img-container #text p { width: 600px; }
#img-container #endtext { float:left; width: 100px; display: block; text-align: justify;  }
#img-container a:link{ color: #000; border-bottom: 1px dotted #666; text-decoration: none; }
#img-container a:active{ color: #000; border-bottom: 1px dotted #666; text-decoration: none; }
#img-container a:visited{ color: #000; border-bottom: 1px dotted #666; text-decoration: none; }
#img-container a:hover{ color: #000; border-bottom: 1px dotted #666; text-decoration: none; }
#img-container .picture_holder { float: left; }
#img-container .picture { /* padding-top: 10px; */ }
#img-container .captioning .title { margin-top: 12px; text-align: right; font-style: italic; }
#img-container .captioning .caption { }";
	}
}