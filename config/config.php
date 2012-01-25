<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/*
 * @copyright  Cyril Ponce 2008-2011
 * @author     Cyril Ponce <cyril@contao.fr>
 * @license    LGPL
*/

$GLOBALS['BE_MOD']['design']['themes']['csseditor'] = array('CssEditor', 'ViewSource');


$GLOBALS['TL_CONFIG']['css_editor_useRTEditor'] = true;
$GLOBALS['TL_CONFIG']['css_editor_startHighlight'] = true;
$GLOBALS['TL_CONFIG']['css_editor_startHeight'] = 400;
/*$GLOBALS['TL_CONFIG']['css_editor_fontSize'] = 12;
$GLOBALS['TL_CONFIG']['css_editor_fontFamily'] = 'monospace';*/

if(@class_exists('Cufon'))
{
	$GLOBALS['TL_HOOKS']['compileDefinition'][] = array('CssHook', 'compileCufonDefinition');
	$GLOBALS['TL_HOOKS']['createDefinition'][] = array('CssHook', 'createCufonDefinition');
}

?>