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

use Codeowl\OutputPresets as Output;

class PresetsSelectWizard extends \Widget
{

	// `-,-´ Submit user input
	protected $blnSubmitInput = true;

	// `-,-´ Template used in Widget
	protected $strTemplate = 'be_select_wizard';

	// `-,-´ Template to extend the default template used in Widget
	protected $strSelectTemplate = 'be_dropdown_wizard';

	// `-,-´ Set the template from the setting in the config.php
	private function setTemplate() {
		$this->strSelectTemplate = 'be_'.\Config::get('co_presets_be_view').'_wizard';
	}
	
	// `-,-´ Add specific attributes
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'mandatory':
				if ($varValue)
				{
					$this->arrAttributes['required'] = 'required';
				}
				else
				{
					unset($this->arrAttributes['required']);
				}
				parent::__set($strKey, $varValue);
				break;

			case 'options':
				$this->arrOptions = deserialize($varValue);
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	// `-,-´ Validate options
	public function validate()
	{
		$varValue = $this->getPost($this->strName);

		if (!empty($varValue) && !$this->isValidOption($varValue))
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalid'], (is_array($varValue) ? implode(', ', $varValue) : $varValue)));
		}

		parent::validate();
	}

	// `-,-´ Get Contao default select as string
	public function getDefaultSelect() {
		$arrOptions = array();
		$strClass = 'co_select_container tl_select';

		if (empty($this->arrOptions))
		{
			$this->arrOptions = array(array('value'=>'', 'label'=>'-'));
		}

		foreach ($this->arrOptions as $strKey=>$arrOption)
		{
			if (isset($arrOption['value']))
			{
				$arrOptions[] = sprintf('<option value="%s"%s>%s</option>',
										 specialchars($arrOption['value']),
										 $this->isSelected($arrOption),
										 $arrOption['label']);
			}
		}

		return sprintf('<select name="%s" id="ctrl_%s" class="%s%s"%s onfocus="Backend.getScrollOffset()">%s</select>%s',
						$this->strName,
						$this->strId,
						$strClass,
						(($this->strClass != '') ? ' ' . $this->strClass : ''),
						$this->getAttributes(),
						implode('', $arrOptions),
						$this->wizard);
	}

	// `-,-´ Get the path from uuid in the previe field
	public function getImagePath($uuid) {

		if ($uuid == '')
		{
			return '';
		}
		$objFile = \FilesModel::findByUuid($uuid);

		if (NULL===$objFile) {
			return '';
		}
		
		if (!is_file(TL_ROOT . '/' . $objFile->path))
		{
			return '';
		}
		return $objFile->path;
	}

	// `-,-´ Get final css classes from the preset object
	public function getCssClassesAsString($objPreset){
		 
		$arrPresetVars = array(); 
        $GridArr = explode(',',str_replace(','.\Config::get('co_grid_field_dca_skip'),'',\Config::get('co_grid_classes')));
       
		foreach ($GridArr as $v) {
             $arrPresetVars[$v] 	= $objPreset->$v;
		}
		$arrPresetVars['float_ftc']  = $objPreset->float_ftc;
		$arrPresetVars['align']      = $objPreset->align;
		$arrPresetVars['custom']     = $objPreset->custom;
      
	    $Output = new Output;
	    return $Output->getCssClassesAsString($arrPresetVars,'',array());
	}

	// `-,-´ Get final css classes from the default preset
	public function getDefaultPresetClass(){
		$Presets 	= New PresetsModel;
		$arrPreset 	= $Presets->getDefaultPreset();
		$Output 	= new Output;
	    return $Output->getCssClassesAsString($arrPreset,'',array());

	}

	// `-,-´ Get Contao default select as string
	public function getWizardAsString() {	
		
		$tpl 				= new \BackendTemplate($this->strSelectTemplate);
		$Presets 			= New PresetsModel;
		$arrPresets 		= $Presets->getPresetsForWizard();
		$arrPresetsFinal 	= array();
		$defaultWidth 		= \Config::get('co_presets_be_view_image_width');
		$defaultHeight 		= \Config::get('co_presets_be_view_image_height');

		foreach ($arrPresets as $id => $objPreset) {

			$arrPresetsFinal[$id]['id']					=	$id;
			$arrPresetsFinal[$id]['image']				=	array();
			$arrPresetsFinal[$id]['image']['path']		=	$this->getImagePath($objPreset->preview);
			$arrPresetsFinal[$id]['image']['width']		=	$defaultWidth;
			$arrPresetsFinal[$id]['image']['height']	=	$defaultHeight;
			$arrPresetsFinal[$id]['name']				=	$objPreset->name;
			$arrPresetsFinal[$id]['description']		=	$objPreset->description;
			$arrPresetsFinal[$id]['class']				=	$this->getCssClassesAsString($objPreset);
	
		}
				
		$tpl->arrPresets 			= $arrPresetsFinal;
		$tpl->activePreset 			= $this->varValue;
		$tpl->selectFieldName 		= $this->strName;
		$tpl->selectFieldId			= $this->strId;
		$tpl->defaultPresetClass 	= $this->getDefaultPresetClass();
		
		$WizardStr = $tpl->parse();
		return $WizardStr;
	}
	
	// `-,-´ Returns widget as string
	public function generate(){
		
		$WizardStr = '';
		$this->setTemplate();
		if ($this->strSelectTemplate !== 'be_select_wizard') {
			$GLOBALS['TL_CSS'][] = TL_PATH.'/system/modules/codeowl_design_presets/assets/be_style.css';
			$WizardStr = $this->getWizardAsString();
		}

		return $this->getDefaultSelect().$WizardStr;			
	}
	
}