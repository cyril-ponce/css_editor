<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * @copyright  Cyril Ponce 2008-2010
 * @author     Cyril Ponce <cyril@contao.fr>
 * @package    CssEditor
 */

/**
 * Add to palette
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'css_editor_useRTEditor';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{css_editor_legend:hide},css_editor_useRTEditor,css_editor_startHeight';

// Subpalettes
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['css_editor_useRTEditor'] = 'css_editor_fontSize,css_editor_fontFamily,css_editor_startHighlight';

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
?>