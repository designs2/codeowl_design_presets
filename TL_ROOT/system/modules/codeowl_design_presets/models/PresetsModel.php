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
 *  ( )  codeowl.org
 *************************/

namespace Codeowl;


class PresetsModel extends \Model
{

    protected static $strTable = 'tl_co_presets';
    
    
    public $defaultPreset = false;
    
    public $strTableKey;
    
    // `-,-´ get key for table and/or class arrays
    protected function getKey()
     {    
         if(\Input::get('table')===NULL){
           $this->strTableKey = \Input::get('do');
         
         }else{
           $this->strTableKey = substr(\Input::get('table'), 3, (strlen(\Input::get('table')))-3);

         }
        return $this->strTableKey;  
    }
     
    // `-,-´ get name of method from key 
    public function getStrClass()
     {  
        $key = $this->getKey();
        
         if($key=='form_field') {
          $strClass = 'FormFieldModel';
         }else {
          $strClass = strtoupper(substr($key, 0, 1)).substr($key, 1, (strlen($key)-1)).'Model'; 
         }
         return $strClass;
     } 

     // `-,-´ get fields in backend sections like article, content, .. which use presets
    public function getFieldsDCA($key)
     {  
        $FieldsArr = $GLOBALS['TL_DCA']['tl_'.$key]['fields'];
         return $FieldsArr;
     }

    // `-,-´ get grid value and generate options
    public function getPresets()
     {
    
         $objModel = (PresetsModel::findAll()===NULL)?array():PresetsModel::findAll()->fetchAll();
         $Presets = $objModel;
         $optionsArr = array();
         
         $optionsArr['-'] = '-';
          $i = 1; 
         foreach ($Presets as $preset) {
           if(in_array($this->getKey(),unserialize($preset['show_in_sections']))){
            $optionsArr[$preset['id']]= $preset['name'];
          $i++;
           }
          }

          return $optionsArr;
      
     }
     // `-,-´ get full presets data of allowed presets
    public function getPresetsForWizard()
     {
    
         $objModel = (PresetsModel::findAll()===NULL)?array():PresetsModel::findAll();
         $Presets = $objModel;
         $presetsArr = array();
         
         $presetsArr['-'] = '-';
          $i = 1; 
         foreach ($Presets as $preset) {
           if(in_array($this->getKey(),unserialize($preset->show_in_sections))){
            $presetsArr[$preset->id]= $preset;
          $i++;
           }
          }

          return $presetsArr;
      
     }
     public function isValToSetDefault($val,$dc)
      {   
          //var_dump($field,$dc->$field,$val);
          // exit;
          if ($dc->$field=='-'&&$val == '-') { return true; }
          $objPreset  = PresetsModel::findByID($val);
          if ($objPreset === Null) { return true; }
          return false;
      }
   
     // `-,-´ get align value and generate options
     public function getSelectedPreset($val,$dc)
      {
         $field = $dc->field;
        
          if ($val == ''&&NULL===$dc->$field) {
            $val = '-';
            $dc->__set($field,$val);
          }
        if ($val == ''&&$dc->$field!==''&&NULL!==$dc->$field) { 
            $val = $dc->$field; 
        }
        if (NULL===$dc->$field) {
            $dc->$field = $val;
        }
        if ($val == '') { $val = '-'; }
        $isDefault = $this->isValToSetDefault($val,$dc);
    
        if($isDefault) {
           $Preset      = $this->getDefaultPreset(); 
           $this->setPresets($Preset,$dc->__get('activeRecord')->id,$dc,$val,$isDefault);  
            
        }else{

            $objPreset  = PresetsModel::findByID($val);
            $Preset = $objPreset->row();
            $this->setPresets($Preset,$dc->__get('activeRecord')->id,$dc,$val,$isDefault);      
        }
       
        return $val;
      }
     // `-,-´ get default options
     public function getDefaultPreset()
      {

        $Presets = (PresetsModel::findAll()===NULL)?array():PresetsModel::findAll()->fetchAll();

        foreach ($Presets as $k => $v) {
        if ($Presets[$k]['use_as_default_for'] == '') { continue; }
    
          if (in_array($this->getKey(), unserialize($Presets[$k]['use_as_default_for']))) {
            unset($Presets[$k]['use_as_default_for'],$Presets[$k]['show_in_sections'],$Presets[$k]['tstamp'],$Presets[$k]['name'],$Presets[$k]['description'],$Presets[$k]['preview']);
            $Default              = $Presets[$k];
            $this->defaultPreset  = true; 
            continue;
          }
    
        }
        
        if ($this->defaultPreset === false) {
          $Default = \Config::get('co_grid_preset_default');
        }
        
          return $Default;  
      } 

    
    // `-,-´ set presets
    public function setPresets($Preset,$id,$dc,$val,$isDefault=false)
      { 
          $key              = $this->getKey();
          $DCAArr           = $this->getFieldsDCA($key);
          $strClass         = $this->getStrClass();
          $DoModel          = $strClass::findByID($id);

         
          if ($DoModel === NULL) { return; }
         
          $fieldCombined = $DCAArr[$dc->field]['combined'];
          $field = $dc->field;
          $updateFieldsArr  = array();

          $Preset = (is_array($Preset))?serialize($Preset):$Preset;  
      
          if ($isDefault===false) {
            
                $PresetModel   = PresetsModel::findByID($val);
                if($PresetModel === NULL){ return; }
                else{
                 $Preset        = $PresetModel->row();
                }
                //problems with uuid binary in serialize()
                unset($Preset['preview']);
                $Preset = (is_array($Preset))?serialize($Preset):$Preset;   
           }
          $dc->__get('activeRecord')->__set($fieldCombined,$Preset);   
          $DoModel->$fieldCombined = $Preset;
          $DoModel->save(); 
          return;                
      }

}

?>