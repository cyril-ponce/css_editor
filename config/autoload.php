<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Css_editor
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\CssEditor' => 'system/modules/css_editor/classes/CssEditor.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_cssedit' => 'system/modules/css_editor/templates',
));
