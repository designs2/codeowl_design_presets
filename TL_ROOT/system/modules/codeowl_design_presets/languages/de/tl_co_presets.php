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

// `-,-´ type_legend,use_legend,breakpoint_legend,classes_legend,
/*
small bis 320
medium ab 320
large ab 480
xlarge ab 768
xxlarge ab 1024
*
*/

$GLOBALS['TL_LANG']['tl_co_presets']['new'][0] = 'Neue Designsvorgabe';
/* legends */
$GLOBALS['TL_LANG']['tl_co_presets']['type_legend'] = 'Basiseinstellungen';
$GLOBALS['TL_LANG']['tl_co_presets']['use_legend'] = 'Standardwerte';
$GLOBALS['TL_LANG']['tl_co_presets']['breakpoint_legend'] = 'Bildschirmbreiten/ Breakpoints';
$GLOBALS['TL_LANG']['tl_co_presets']['classes_legend'] = 'Erweiterte Einstellungen & CSS-Klassen';

$GLOBALS['TL_LANG']['tl_co_presets']['name'][0] = 'Bezeichnung';
$GLOBALS['TL_LANG']['tl_co_presets']['preview'][0] = 'Vorschaubild';
$GLOBALS['TL_LANG']['tl_co_presets']['preview'][1] = 'Das Vorschaubild wird bei der Auswahl und in der Inhaltselemente-Übersicht angezeigt';
$GLOBALS['TL_LANG']['tl_co_presets']['description'][0] = 'Beschreibung';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections'][0] = 'Zur Verfügung stellen:';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options']['layout'] = 'Im Seitenlayout';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options']['module'] = 'Für Module';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options']['article'] = 'Für Artikel';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options']['content'] = 'Für Inhaltselemente';
$GLOBALS['TL_LANG']['tl_co_presets']['show_in_sections_options']['form_field'] = 'Für Formularfelder';

$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for'][0] = 'Als Standard nutzen für';
$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for'][1] = 'Es kann nur eine Standard-Einstellung pro Bereich geben.';
$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for_options']['module'] = 'Für Module';
$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for_options']['article'] = 'Für Artikel';
$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for_options']['content'] = 'Für Inhaltselemente';
$GLOBALS['TL_LANG']['tl_co_presets']['use_as_default_for_options']['form_field'] = 'Für Formularfelder';

$breakpoints = Config::get('co_presets_breakpoints');
$GLOBALS['TL_LANG']['tl_co_presets']['small'][0] = 'Klein - bis '.$breakpoints['small'].' Pixel';
$GLOBALS['TL_LANG']['tl_co_presets']['medium'][0] = 'Medium - ab '.$breakpoints['small'].' Pixel';
$GLOBALS['TL_LANG']['tl_co_presets']['large'][0] = 'Groß - ab '.$breakpoints['medium'].' Pixel';
$GLOBALS['TL_LANG']['tl_co_presets']['xlarge'][0] = 'Extra groß - ab '.$breakpoints['large'].' Pixel';
$GLOBALS['TL_LANG']['tl_co_presets']['xxlarge'][0] = 'Am größten - ab '.$breakpoints['xlarge'].' Pixel';
$GLOBALS['TL_LANG']['tl_co_presets']['float'][0] = 'Ausrichtung des Elementes - Links, Rechts';
$GLOBALS['TL_LANG']['tl_co_presets']['align'][0] = 'Ausrichtung des Elementes - Zentriert';
$GLOBALS['TL_LANG']['tl_co_presets']['offset'][0] = 'Leeraum auf der Linken Seite einfügen';
$GLOBALS['TL_LANG']['tl_co_presets']['push'][0] = 'Reihenfolge ändern - Abstand links'; 
$GLOBALS['TL_LANG']['tl_co_presets']['pull'][0] = 'Reihenfolge ändern - Abstand rechts'; 

$GLOBALS['TL_LANG']['tl_co_presets']['custom'][0] = 'Weitere CSS-Klassen';