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

// `-,-´ BE MOD of presets
array_insert($GLOBALS['BE_MOD']['design'],3,array(
	'tl_co_presets' => array
	    (
     'tables'            => array('tl_co_presets'),
     'icon'           => 'system/modules/codeowl_design_presets/assets/icons/ftc-presets.png')    
	));

// `-,-´ Back end form fields
$GLOBALS['BE_FFL']['PresetsCustomWizard']    = 'PresetsCustomWizard';
$GLOBALS['BE_FFL']['PresetsSelectWizard']    = 'PresetsSelectWizard';

// `-,-´ Model
$GLOBALS['TL_MODELS']['tl_co_presets'] = 'PresetsModel';

// `-,-´ Set config for Zurb's Foundation as default
$GLOBALS['TL_CONFIG']['co_presets_be_view'] 	 				= 'dropdown';//chose between select, dropdown and picturebox
$GLOBALS['TL_CONFIG']['co_presets_be_view_image_width'] 	 	= '80';
$GLOBALS['TL_CONFIG']['co_presets_be_view_image_height'] 	 	= '60';
$GLOBALS['TL_CONFIG']['co_presets_breakpoints'] 	= array(
														'small'		=> '320',
														'medium'	=> '480',
														'large'		=> '768',
														'xlarge'	=> '1024',
														'xxlarge'	=> '999999999',
														);
$GLOBALS['TL_CONFIG']['co_grid_columns_size'] 	 	= '12';
$GLOBALS['TL_CONFIG']['co_grid_prefix']  		 	= 'ftc';
$GLOBALS['TL_CONFIG']['co_grid_breakpoints'] 	 	= 'small,medium,large,xlarge,xxlarge'; //ftc
$GLOBALS['TL_CONFIG']['co_grid_classes'] 		 	= 'small,medium,large,xlarge,xxlarge,float_ftc,align,pull,push,offset'; //ftc
$GLOBALS['TL_CONFIG']['co_grid_palette'] 			= '{breakpoint_legend},small,medium,large,xlarge,xxlarge;{classes_legend},float_ftc,align,pull,push,offset,custom;';
$GLOBALS['TL_CONFIG']['co_grid_wizard_palette']  	= '{ftc_legend},ftc_preset_id,ftc_preset_full,ftc_preset_add_custom;'; 
$GLOBALS['TL_CONFIG']['co_grid_wizard_palette_ext'] = '{ftc_legend},ftc_preset_id,ftc_preset_full,data_attr_ftc,ftc_preset_add_custom;';
$GLOBALS['TL_CONFIG']['co_grid_preset_default'] 	= array(
											          	'small' 	=> '-' ,
											          	'medium' 	=> '-' ,
											          	'large' 	=> '-' ,
											          	'xlarge' 	=> '-' ,
											          	'xxlarge'	=> '-' ,
											          	'pull' 		=> '-' , 
											          	'push' 		=> '-' ,
											          	'offset' 	=> '-' ,
											          	'custom' 	=> ''  ,
											          	'align' 	=> 'a:1:{i:0;s:1:"-";}', 
											          	'float_ftc' => '-' 
											          	);
$GLOBALS['TL_CONFIG']['co_grid_field_dca_default']  = array(
															'default'                 => '-',
															'exclude'                 => true,
															'sorting' 				  => true,
															'filter'                  => true,
															'inputType'               => 'select',
															'options_callback'        => array('tl_co_presets', 'getColOpitons'),
															'eval'                    => array('helpwizard'=>false, 'chosen'=>true,  'tl_class'=>'w50'),
															'sql'                     => "char(8) NOT NULL default '-'"
														);
$GLOBALS['TL_CONFIG']['co_grid_field_dca_skip'] 	= 'float_ftc,align';

if (TL_MODE=='BE'&&Input::get('do')=='tl_co_presets') {
	$GLOBALS['TL_CSS'][] = TL_PATH.'/system/modules/codeowl_design_presets/assets/tl_co_presets.css';

}
  
?>
