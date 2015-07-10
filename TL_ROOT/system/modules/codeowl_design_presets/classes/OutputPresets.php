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


class OutputPresets
{
    
  // `-,-´ get the raw output string from the config fields
  public function getCssClassesAsString($preset,$add_custom,$custom_preset){
     
       $co_grid     = array();
       $GridArr = explode(',',str_replace(','.\Config::get('co_grid_field_dca_skip'),'',\Config::get('co_grid_classes')));
       if ($add_custom=='1') {$preset = $custom_preset;}
       $preset  = (!is_array($preset))?unserialize($preset):$preset;
       
       foreach ($GridArr as $v) {
         if (isset($preset[$v])&&$preset[$v]!=='-') {
            $co_grid[$v] = $v.\Config::get('co_grid_glue').$preset[$v];
         }
       }
       $co_grid['columns']    = (count($co_grid) == 0)?'':'columns';
       $co_grid['float_ftc']  = ($preset['float_ftc'] !== '-')?$preset['float_ftc']:'';
       $co_grid['align']      = ($preset['align'] !== NULL)?$this->splitArr($preset['align']):'';
       $co_grid['custom']     = ($preset['custom'] !== NULL)?$preset['custom']:'';
      
       $co_grid_classes = trim(implode(' ',$co_grid));
       unset( $preset);
       return $co_grid_classes;
     
  } 

  // `-,-´ helper filters the "-" an give a string back
  public function splitArr($arr){
     
         $str = '';
         $arr = (!is_array($arr))?unserialize($arr):$arr;
         if ($arr == '' || !is_array($arr)) {
            return;
         }
         foreach ($arr as $class) {
            if ($class == '' || $class == '-') {
              return;
            }
            $str .= ' '.$class;
         }
         return $str;
  }
          
}
?>
