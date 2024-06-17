/**
* Importation de la classe change_onscroll
*/
import change_onscroll from "./cstm_nav.js";

/**
* Instanciation de l'objet change_onscroll
*/
let change_nav = new change_onscroll;

change_nav.setBlock_1_id("site-navigation");
change_nav.setSousblock1_id("navbarSupportedContent");

change_nav.setSousblock_bg_step1("transparent");
change_nav.setSousblock_bg_step2("rgba(255, 255, 255, 0.7)");

change_nav.setBlock_2_class("logo");
/**
* attribut des 2 étapes (avant / après le breakpoint) du display
*/
change_nav.setBlock_2_step1("none");
change_nav.setBlock_2_step2("inline-block");

change_nav.setBlock_breakpoint_id("carouselExampleCaptions");

change_nav.nav_change_onscroll();