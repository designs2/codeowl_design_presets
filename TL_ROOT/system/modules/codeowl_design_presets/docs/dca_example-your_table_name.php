<?php
/** 
 * Extension for Contao Open Source CMS
 *
 * Copyright (C) 2015 Monique Hahnefeld
 *
 * @package codeowl_design_presets
 * @author  Monique Hahnefeld <info@monique-hahnefeld.de>
 * @link    http://codeowl.org
 * @license LGPLv3
 *
 * `-,-´
 *	( )  codeowl.org
 *************************/

// `-,-´ Here is an example how you can implement the wizard
$co_grid = Config::get('co_grid_wizard_palette');
$default = '{title_legend},name,headline,type;';
$expert  ='{template_legend:hide},navigationTpl,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// `-,-´ Set the selector
array_insert($GLOBALS['TL_DCA']['your_table_name']['palettes']['__selector__'] ,1,array('ftc_preset_add_custom'));//'top_bar',
 
// `-,-´ Set the subpalette
$GLOBALS['TL_DCA']['your_table_name']['subpalettes']['ftc_preset_add_custom'] = 'ftc_preset_custom';

// `-,-´ Set the palettes
$palettes = $GLOBALS['TL_DCA']['your_table_name']['palettes'];
foreach ($palettes as $p => $str) {
	 $pallete_co = str_replace("{title_legend}",$co_grid."{title_legend}",$str);
	 $GLOBALS['TL_DCA']['your_table_name']['palettes'][$p]=$pallete_co;
}

// `-,-´ Insert the dafault dca fields. You can also insert your own fields. Look into the docs.
if ($wizardFields===NULL) {
	$wizardFields = new \Codeowl\DCA;
	$wizardFields->insert_wizard_fields('your_table_name'); 
}


?>