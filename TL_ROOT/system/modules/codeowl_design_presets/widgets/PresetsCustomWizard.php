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

namespace Codeowl;

class PresetsCustomWizard extends \Widget
{

	// `-,-´ Submit user input
	protected $blnSubmitInput = true;

	// `-,-´ Template
	protected $strTemplate = 'be_widget';

	// `-,-´ Table
	public $coStrTable = 'tl_co_presets';
	
	// `-,-´ Grid classes
	public $fieldsArr = '';

	// `-,-´ get fields for widget from dca tl_co_presets
	public function getFields($dc_id,$varValue) {
		$this->fieldsArr = \Config::get('co_grid_classes');
		$this->loadDataContainer($this->coStrTable);
		$this->loadLanguageFile($this->coStrTable); 
		// `-,-´ Mediaquery settings
		$fields   = array();

		if($varValue === Null || $varValue == ''){
			$PostFieldsArr = $this->getPostArr();	
		}else{
			$PostFieldsArr = $varValue;
		}
		
		$fieldsStr = '';
		
		foreach(explode(',',$this->fieldsArr) as $field)
		{
			$arrData   = $GLOBALS['TL_DCA'][$this->coStrTable]['fields'][$field];
			$strClass  = $GLOBALS['BE_FFL'][$arrData['inputType']];
			$objWidget = new $strClass($strClass::getAttributesFromDca($arrData,$field,$arrData['default'], '', '',$this));
			$objWidget->value 		 = $PostFieldsArr[$field];
			$objWidget->label 		 = ($objWidget->label == '')?$objWidget->name:$objWidget->label;
			$fields[$field]['label'] = $objWidget->generateLabel();
			$fields[$field]['field'] = $objWidget->generateWithError(true);
			$fieldsStr 				.= "\n".'<div class="'.$arrData['eval']['tl_class'].'">'."\n\t".'<h3>'.$fields[$field]['label'].'</h3>'."\n\t".$fields[$field]['field']."\n".'</div>';

		}

		$submit = ($_GET['table'] === NULL)?'tl_'.$_GET['do']:$_GET['table'];

		if (\Input::post('FORM_SUBMIT') == $submit){
				$this->setCustomPreset($dc_id,serialize($PostFieldsArr));
		}	
		return $fieldsStr;
	}
	
	// `-,-´  set custom preset
	public function setCustomPreset($dc_id,$PostFieldsArr) {

		$ftcPM 		= new PresetsModel;
		$strClass   = $ftcPM->getStrClass();
		$DoModel 	= $strClass::findByID($dc_id);

		if ($DoModel->ftc_preset_add_custom=='1') {
			$arrPreset 					= $PostFieldsArr;
			$DoModel->ftc_preset_custom = $arrPreset;
			$DoModel->save(true);	

		}

	}

	// `-,-´ get Post[]
	public function getPostArr() {
	
		$PostFieldsArr = array();
		
		foreach(explode(',',$this->fieldsArr) as $field){
			$PostFieldsArr[$field] = (\Input::post($field) === NULL) ? '-' : \Input::post($field);
		}
				
		return $PostFieldsArr;
	}

	// `-,-´  Generate the widget and return it as string
	public function generate(){
	
		$dc_id = $this->currentRecord;
		return $this->getFields($dc_id,$this->varValue);
				
	}
	
}
