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

class ControlPresets extends \Backend
{

	public $defaultPreset    = false;

  public $prefix           = '';

  private $strTemplate   = 'be_co_presets_list';

  protected $strTable      = 'tl_co_presets';

  // `-,-´ onversion callback
	public function onversion_callback($table,$id,$dc) 
	{
		$Preset = 'getFitPreset';
		$this->update($dc,$Preset,'version');
	}

  // `-,-´ ondelete callback
	public function ondelete_callback($dc) 
	{
		$Preset = 'getDefaultPreset';
		$this->update($dc,$Preset,'delete');
	}

  // `-,-´ update callback
	public function update($dc,$getPreset,$type) 
	{
		
		$PresetsArr = array(
                          'show_in_sections'    => $dc->__get('activeRecord')->id,
                          'use_as_default_for'  => '-'
                        );

		foreach ($PresetsArr as $arr=>$val) {

			if($dc->__get('activeRecord')->$arr == ''){ return; }	
			$dc->__get('activeRecord')->$arr = (is_array($dc->__get('activeRecord')->$arr)) ? $dc->__get('activeRecord')->$arr : unserialize($dc->__get('activeRecord')->$arr );	
			
			foreach ($dc->__get('activeRecord')->$arr as $key) {
				 $getPresetF        = ($type == 'version') ? $this->$getPreset($dc->__get('activeRecord')->row()) : $this->$getPreset($key,$dc->__get('activeRecord')->id);
				 if ($key == 'layout'){ continue; }
				 $strClass          = $this->getStrClass($key);
				 $updateFieldsArr   = $this->getFields($key);

		         foreach ($updateFieldsArr as $field) {

	          		$DoModels   = $this->getModels($strClass,$field['id'],$val);
	          		if ($DoModels === NULL) { continue; }
	          		foreach ($DoModels as $DoModel) {
  	          			if ($type == 'delete') {
  	          				$DoModel->$field['id']     = $val;
  	          				$this->defaultPreset       = false; 
  	          			}
    						$DoModel->$field['combined']     = $getPresetF;
    						$DoModel->save();
	          		}
              }
        }
		}

	}
	
	// `-,-´ get Models
	public function getModels($strModel,$Rel,$Val) 
	{	
		$objModels = $strModel::findBy($Rel,$Val);
	 	return $objModels; 
	} 
	
  // `-,-´ get name of method
	public function getStrClass($key)
	 {	
	     if($key=='form_field') {
	     	$strClass = 'FormFieldModel';
	     }else {
	    	$strClass = strtoupper(substr($key, 0, 1)).substr($key, 1, (strlen($key))-1).'Model';	
	     }
	     return $strClass;
	 } 

	 // `-,-´ get default options needed for delete
   public function getDefaultPreset($key,$id)
      {
        $Presets   = (\PresetsModel::findAll() === NULL)?array():\PresetsModel::findAll()->fetchAll();
        $arrCacheP = (!$arrCache)?array(): $arrCacheP;
        if (isset($arrCacheP[$key])) {
        	return $arrCacheP[$key];
        }
        foreach ($Presets as $k => $v) {
        if ($Presets[$k]['use_as_default_for'] == ''){continue;}
          if (in_array($key, unserialize($Presets[$k]['use_as_default_for']))&&$Presets[$k]['id'] !== $id) {
            unset(
              $Presets[$k]['use_as_default_for'],
              $Presets[$k]['show_in_sections'],
              $Presets[$k]['tstamp'],
              $Presets[$k]['name'],
              $Presets[$k]['description'],
              $Presets[$k]['preview']
              );
            $Default 			 = $Presets[$k];
            $this->defaultPreset = true; 
            continue;
          }
    
        }
        
        if ($this->defaultPreset===false) {
          $Default = \Config::get('co_grid_preset_default');
     
        }
        $arrCacheP[$key] = $Default;
        
          return $Default;  
    }  	    

	  // `-,-´ get fit options
    public function getFitPreset($Preset)
    {
      	unset(
      		$Preset['use_as_default_for'],
      		$Preset['show_in_sections'],
      		$Preset['tstamp'],
      		$Preset['name'],
      		$Preset['description'],
      		$Preset['preview']
      		);
      
      	return serialize($Preset);
    }

    // `-,-´ get fields in backend sections like article, content, .. which use presets
    public function getFields($key)
     {  

      $this->prefix = \Config::get('co_grid_prefix');
      if($GLOBALS['TL_DCA']['tl_'.$key] === NULL){
        $this->loadDataContainer('tl_'.$key);
      }
      $FieldsArr 		= $GLOBALS['TL_DCA']['tl_'.$key]['fields'];
      $DiffStr 			= $this->prefix.'_preset_id';

       /*  `-,-´
        *   ( )     ++ pay attention to the name of the combined field $this->prefix.(_preset_full+connected)
        ***[+ SEARCH ALL PRESET FIELD ]**************************************************************/
       
      $PresetFieldsArr  = preg_grep( "/$DiffStr/i", array_keys($FieldsArr));
      $IdFullPairArr    = array();
      $i 				= 0;

      foreach ($PresetFieldsArr as $field) {
        $IdFullPairArr[$i]['id'] 		= $field;
        $IdFullPairArr[$i]['combined']  = $this->prefix.'_preset_full'.substr($field,  strlen($DiffStr), strlen($field)-strlen($DiffStr));
        $i++;
      }
      return $IdFullPairArr;
     }

      // `-,-´ onload_callback
     public function getNiceBackendView($row, $label){
      
      $tpl          = new \BackendTemplate($this->strTemplate);
      $tpl->tags_default  = (Null!==$row['use_as_default_for'])?deserialize($row['use_as_default_for'],true):false;
      $tpl->tags_access   = (Null!==$row['show_in_sections'])?deserialize($row['show_in_sections'],true):false;
    
      $tpl->label         = $label;
      $tpl->name          = $row['name'];
      $tpl->description   = $row['description'];
      $defaultWidth       = \Config::get('co_presets_be_view_image_width');
      $defaultHeight      = \Config::get('co_presets_be_view_image_height');

      $previewImage            = array();
      $SelectWizardClass       = new PresetsSelectWizard;
      $previewImage['path']    = $SelectWizardClass->getImagePath($row['preview']);
      $previewImage['width']   = $defaultWidth;
      $previewImage['height']  = $defaultHeight;
      $tpl->image              = $previewImage;
      $Output                  = new Output;
      $tpl->class              = $Output->getCssClassesAsString($row,'',array());

      return $tpl->parse();
     }

}
?>