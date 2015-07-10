<?php
//update save config vars. You can use this config for the Contao CMS Core Grid

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
$GLOBALS['TL_CONFIG']['co_grid_glue']  		 		= '';
$GLOBALS['TL_CONFIG']['co_grid_breakpoints'] 	 	= 'grid'; //small,medium,large,xlarge,xxlarge
$GLOBALS['TL_CONFIG']['co_grid_classes'] 		 	= $GLOBALS['TL_CONFIG']['co_grid_breakpoints'] .',float_ftc,align,pull,push,offset'; //ftc
$GLOBALS['TL_CONFIG']['co_grid_palette'] 			= '{breakpoint_legend},'.$GLOBALS['TL_CONFIG']['co_grid_breakpoints'] .';{classes_legend},float_ftc,align,pull,push,offset,custom;';
$GLOBALS['TL_CONFIG']['co_grid_preset_default'] 	= array(
											          	// 'small' 	=> '-' ,
											          	// 'medium' 	=> '-' ,
											          	// 'large' 	=> '-' ,
											          	// 'xlarge' 	=> '-' ,
											          	// 'xxlarge'	=> '-' ,
														'grid' 		=> '-' , 
											          	'pull' 		=> '-' , 
											          	'push' 		=> '-' ,
											          	'offset' 	=> '-' ,
											          	'custom' 	=> ''  ,
											          	'align' 	=> 'a:1:{i:0;s:1:"-";}', 
											          	'float_ftc' => '-' 
											          	);
$GLOBALS['TL_CONFIG']['co_grid_field_dca_skip'] 	= 'float_ftc,align';