<?php 
/** 
 * Extension for Contao Open Source CMS
 *
 * Copyright (C) 2015 Monique Hahnefeld
 *
 * @package codeowl_grid_control
 * @author  Monique Hahnefeld <info@monique-hahnefeld.de>
 * @link    http://codeowl.org
 * @license LGPLv3
 *
 * `-,-´
 *	( )  codeowl.org
 *************************/

namespace Codeowl;

class DCA
{

	// `-,-´ Add fields to dca
	public function insert_wizard_fields($table=NULL) 
	{
		if ($table===NULL) {
			$table = \Input::get('table');
		}

		$fieldsSize=count($GLOBALS['TL_DCA'][$table]['fields'])-1;
		array_insert($GLOBALS['TL_DCA'][$table]['fields'], $fieldsSize, array
		(
			'ftc_preset_id' => array
					(
						'label'                   => &$GLOBALS['TL_LANG']['MSC']['ftc_preset_id'],
						'default'                 => '-',
						'exclude'                 => true,
						'sorting' 				  => true,
						'filter'                  => true,
						'inputType'               => 'PresetsSelectWizard',
						//'inputType'               => 'select',
						'options_callback'        => array('PresetsModel', 'getPresets'),
						'load_callback'			  => array(array('PresetsModel', 'getSelectedPreset')),
						'save_callback'		  => array(array('PresetsModel', 'getSelectedPreset')),
						'eval'                    => array('helpwizard'=>false, 'chosen'=>true, 'submitOnChange'=>true, 'tl_class'=>'long clr m12'),
						'sql'                     => "varchar(255) NOT NULL default '-'",
						'combined'				  => 'ftc_preset_full'
					),
			'ftc_preset_full' => array
					(
						'label'                   => &$GLOBALS['TL_LANG']['MSC']['ftc_preset_full'],
						'exclude'                 => true,
						'inputType'               => 'hidden',
						'eval'                    => array('hideInput'=>true, 'doNotShow' =>true),
						'sql'                     => "text NULL"
					),
			'ftc_preset_custom' => array
					(
						'label'                   => &$GLOBALS['TL_LANG']['MSC']['ftc_preset_custom'],
						'exclude'                 => true,
						'inputType'               => 'PresetsCustomWizard',
						'eval'                    => array
						(
						    'tl_class'          => 'clr',
						    'doNotShow' =>true   
						),    
						
						'sql'                     => "text NULL"
					),
			'ftc_preset_add_custom' => array
						(
						'label'                   => &$GLOBALS['TL_LANG']['MSC']['ftc_preset_add_custom'],
						'exclude'                 => true,
						'inputType'               => 'checkbox',
						'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
						'sql'                     => "char(1) NOT NULL default ''"
						)
			));


	}
	
}
?>
