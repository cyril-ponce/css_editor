<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   CssEditor 
 * @author    Cyril Ponce <cyril@contao.fr> 
 * @license   LGPL 
 * @copyright Cyril Ponce 2008-2012 
 */


/**
 * Add to palette
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'css_editor_useRTEditor';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{css_editor_legend:hide},css_editor_useRTEditor,css_editor_startHeight';

// Subpalettes
//$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['css_editor_useRTEditor'] = 'css_editor_fontSize,css_editor_fontFamily,css_editor_startHighlight';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['css_editor_useRTEditor'] = 'css_editor_startHighlight';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['css_editor_useRTEditor'] = array(
		'label'		=>	&$GLOBALS['TL_LANG']['tl_settings']['css_editor_useRTEditor'],
		'inputType'	=>	'checkbox',
		'default'	=>	true,
		'eval'		=>	array('submitOnChange'=>true, 'tl_class'=>'m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['css_editor_startHighlight'] = array(
		'label'		=>	&$GLOBALS['TL_LANG']['tl_settings']['css_editor_startHighlight'],
		'inputType'	=>	'checkbox',
		'default'	=>	true,
		'eval'		=>	array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['css_editor_startHeight'] = array(
		'label'		=>	&$GLOBALS['TL_LANG']['tl_settings']['css_editor_startHeight'],
		'inputType'	=>	'text',
		'default'	=>	'400',
		'eval'		=>	array('rgxp'=>'digit', 'maxlength'=>4, 'tl_class'=>'w50')
);

/*
$GLOBALS['TL_DCA']['tl_settings']['fields']['css_editor_fontSize'] = array(
		'label'		=>	&$GLOBALS['TL_LANG']['tl_settings']['css_editor_fontSize'],
		'inputType'	=>	'select',
		'options'   =>  array('8','9','10','11','12','14'),
		'eval'		=>	array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['css_editor_fontFamily'] = array(
		'label'		=>	&$GLOBALS['TL_LANG']['tl_settings']['css_editor_fontFamily'],
		'inputType'	=>	'select',
		'options'   =>  array('Monospace','Verdana','Arial'),
		'eval'		=>	array('tl_class'=>'w50')
);
*/