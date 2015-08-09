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

// `-,-´ Table tl_co_presets
$GLOBALS['TL_DCA']['tl_co_presets'] = array
(
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'Vwidth'            => 640,
		'Vheight'            => 480,
		'onversion_callback' => array(  
			array('Codeowl\ControlPresets', 'onversion_callback')
		),
		'ondelete_callback' => array(  
			array('Codeowl\ControlPresets', 'ondelete_callback')
		),
	
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	'list' => array
	(
		'sorting' => array
		(
			'mode'                  => 1,
			'fields'                => array('name'),
			'flag'                  => 1,
		),
		'label' => array
		(
		    'fields'                  => array('id','name','description'),
		    'format'                  => '%s | %s : %s',
		    'label_callback'          => array('Codeowl\ControlPresets', 'getNiceBackendView')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'				
			),
			// 'toggle' => array
			// (
			// 	'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['toggle'],
			// 	'icon'                => 'visible.gif',
			// 	'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"'				
			// ),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_co_presets']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	'palettes' => array
	(
		'default'                     => '{type_legend},name,preview,description;{use_legend},show_in_sections,use_as_default_for;'.Config::get('co_grid_palette')
	),
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',	
			'eval'                    => array('maxlength'=>64,'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['description'],
			'exclude'                 => true,
			'inputType'               => 'textarea',	
			'eval'                    => array('tl_class'=>'clr long'),
			'sql'                     => "varchar(2000) NOT NULL default ''"
		),	
		'preview' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['preview'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "binary(16) NULL",
			'load_callback' => array
			(
				array('tl_co_presets', 'setSingleSrcFlags')
			),
			'save_callback' => array
			(
				array('tl_co_presets', 'storeFileMetaInformation')
			)
		),						
		'float_ftc' => array
				(
					'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['float'],
					'exclude'                 => true,
					 'sorting' 				  => true,
					'filter'                  => true,
					'inputType'               => 'select',
					'options'				  => array('-','left','right'),
					'reference'               => &$GLOBALS['TL_LANG']['tl_co_presets']['options'],
					'eval'                    => array('helpwizard'=>false, 'chosen'=>false, 'tl_class'=>'w50 clr'),
					'sql'                     => "varchar(255) NOT NULL default '-'"
				),
		'align' => array
		   		(
		   			'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['align'],
		   			'default'                 => '-',
		   			'exclude'                 => true,
		   			 'sorting' 				  => true,
		   			'filter'                  => true,
		   			'inputType'               => 'select',
		   			'options_callback'        => array('tl_co_presets', 'getAlignOpitons'),
		   			'reference'               => &$GLOBALS['TL_LANG']['tl_co_presets']['options'],
		   			'eval'                    => array('multiple'=>true,'helpwizard'=>false, 'chosen'=>false,  'tl_class'=>'w50 m12" style="height:auto'),
		   			'sql'                     => "varchar(2000) NOT NULL default '-'"
		   		),
	   	'custom' => array
	   	(
	   		'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['custom'],
	   		'exclude'                 => true,
	   		'inputType'               => 'text',	
	   		'eval'                    => array('maxlength'=>255,'tl_class'=>'w50'),
	   		'sql'                     => "varchar(255) NOT NULL default ''"
	   	),		   			 
	   'show_in_sections' => array
	   				(
	   					'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections'],
	   					'exclude'                 => true,
	   					'inputType'               => 'checkbox',
	   					'options'				  => array('layout','module','article','content','form_field'),
	   					'reference'               => &$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options'],
	   					'eval'                    => array('multiple'=>true,'tl_class'=>'w50 m12" style="height:auto'),
	   					'sql'                     => "varchar(255) NULL"
	   				),
	   'use_as_default_for' => array
	   					(
	   						'label'                   => &$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for'],
	   						'exclude'                 => true,
	   						'inputType'               => 'checkbox',
	   						'options'				  => array('module','article','content','form_field'),
	   						'reference'               => &$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for_options'],
	   						'eval'                    => array('multiple'=>true,'tl_class'=>'w50 m12" style="height:auto'),
	   						'sql'                     => "varchar(255) NULL"
	   					)	
		)
);

foreach (explode(',',Config::get('co_grid_classes')) as $field) {
		if (in_array($field,explode(',',Config::get('co_grid_field_dca_skip')))){continue;}
		$GLOBALS['TL_DCA']['tl_co_presets']['fields'][$field] 			 = Config::get('co_grid_field_dca_default');
		$GLOBALS['TL_DCA']['tl_co_presets']['fields'][$field]['label']   = &$GLOBALS['TL_LANG']['tl_co_presets'][$field];
}

// `-,-´ Hook for the col size
		if (isset($GLOBALS['TL_CO_HOOKS']['colSizeHook']) && is_array($GLOBALS['TL_CO_HOOKS']['colSizeHook']))
		{
			foreach ($GLOBALS['TL_CO_HOOKS']['colSizeHook'] as $callback)
			{
				$this->import($callback[0]);
				$this->$callback[0]->$callback[1]();
			}
		}

$GLOBALS['TL_DCA']['tl_co_presets']['fields']['small']['default'] 	= (string) Config::get('co_grid_columns_size');
$GLOBALS['TL_DCA']['tl_co_presets']['fields']['small']['sql'] 		= "char(8) NOT NULL default '".(string) Config::get('co_grid_columns_size')."'";

$GLOBALS['TL_DCA']['tl_co_presets']['fields']['xxlarge']['default'] = (string) Config::get('co_grid_columns_size');
$GLOBALS['TL_DCA']['tl_co_presets']['fields']['xxlarge']['sql'] 	= "char(8) NOT NULL default '".(string) Config::get('co_grid_columns_size')."'";

// `-,-´ Class tl_co_presets
class tl_co_presets extends Backend
{

	// `-,-´ Import the back end user object
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	// `-,-´ Return the link picker wizard
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}


    // `-,-´ get grid value and generate options
    public function getColOpitons()
    {
	     $GridSize = Config::get('co_grid_columns_size');
	     $optionsArr = array();
	     $optionsArr[0]='-';
	    	  // `-,-´ ftc setting size of columns (default=12) 
	    	  for ($i = 1; $i <= $GridSize; $i++) {
	    	  	$optionsArr[$i] = (string) $i;
	    	  }
	     
	     return $optionsArr;
     	
     }
     
     // `-,-´ get align value and generate options
     public function getAlignOpitons()
     {
     
          $breakpoints   = Config::get('co_grid_breakpoints');
          $optionsArr    = array();
          $optionsArr[0] = '-';
         // `-,-´ ftc uncentered centered
         $i = 1	;  
         foreach (explode(',', $breakpoints) as $bp) {
         		$optionsArr[$i] = ($bp).'-centered';
         		 $i++;
         		$optionsArr[$i] = ($bp).'-uncentered';
         		 $i++;
         }	     
         	  
         return $optionsArr;
          	
      }

    // `-,-´ Pre-fill the "alt" and "caption" fields with the file meta data
	public function storeFileMetaInformation($varValue, DataContainer $dc)
	{
		
		if ($dc->activeRecord->singleSRC == $varValue)
		{
			return $varValue;
		}
		$objFile = FilesModel::findByUuid($varValue);
		if ($objFile !== null)
		{
			$arrMeta = deserialize($objFile->meta);
			if (!empty($arrMeta))
			{
				$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=(SELECT pid FROM " . ($dc->activeRecord->ptable ?: 'tl_article') . " WHERE id=?)")
										  ->execute($dc->activeRecord->pid);
				if ($objPage->numRows)
				{
					$objModel = new PageModel();
					$objModel->setRow($objPage->row());
					$objModel->loadDetails();
					// Convert the language to a locale (see #5678)
					$strLanguage = str_replace('-', '_', $objModel->rootLanguage);
					if (isset($arrMeta[$strLanguage]))
					{
						Input::setPost('alt', $arrMeta[$strLanguage]['title']);
						Input::setPost('caption', $arrMeta[$strLanguage]['caption']);
					}
				}
			}
		}
		return $varValue;
	}

	// `-,-´ Dynamically add flags to the "singleSRC" field
	public function setSingleSrcFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
			switch ($dc->activeRecord->type)
			{
				case 'text':
				case 'hyperlink':
				case 'image':
				case 'accordionSingle':
					$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
					break;
				case 'download':
					$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('allowedDownload');
					break;
			}
		}
		return $varValue;
	}
	
}
	

?>