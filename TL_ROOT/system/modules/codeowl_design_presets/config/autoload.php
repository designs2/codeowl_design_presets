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


// `-,-´ Register the namespaces
ClassLoader::addNamespaces(array
(
	'Contao',
	'Codeowl',
));

// `-,-´ Register the classes
ClassLoader::addClasses(array
(
	// `-,-´ Wizard
	'Codeowl\PresetsCustomWizard'  => 'system/modules/codeowl_design_presets/widgets/PresetsCustomWizard.php',
	'Codeowl\PresetsSelectWizard'  => 'system/modules/codeowl_design_presets/widgets/PresetsSelectWizard.php',
	// `-,-´ HOOKs
	'Codeowl\OutputPresets'  => 'system/modules/codeowl_design_presets/classes/OutputPresets.php',
	// `-,-´ Models
	'Codeowl\PresetsModel' 	 => 'system/modules/codeowl_design_presets/models/PresetsModel.php',
	// `-,-´ Classes
	'Codeowl\ControlPresets' => 'system/modules/codeowl_design_presets/classes/ControlPresets.php',
	'Codeowl\DCA' 			 => 'system/modules/codeowl_design_presets/classes/DCA.php',
));

// `-,-´ Register the templates
TemplateLoader::addFiles(array
(	
'be_dropdown_wizard'		=>	'system/modules/codeowl_design_presets/templates/backend',
'be_picturebox_wizard'		=>	'system/modules/codeowl_design_presets/templates/backend',
'be_select_wizard'			=>	'system/modules/codeowl_design_presets/templates/backend',
'be_co_presets_list'		=>	'system/modules/codeowl_design_presets/templates/backend'
));
