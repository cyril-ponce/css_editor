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


/*
 * @copyright  Cyril Ponce 2008-2010
 * @author     Cyril Ponce <cyril@contao.fr>
 * @license    LGPL
*/

/**
 * Table tl_style_sheet
 */
array_insert($GLOBALS['TL_DCA']['tl_style_sheet']['list']['operations'], 1 , array
		(
		'source' => array
		(
				'label'               => &$GLOBALS['TL_LANG']['tl_files']['source'],
				'href'                => 'key=csseditor',
				'icon'                => 'editor.gif',
				'button_callback'     => array('tl_style_sheet_custom', 'editSource')
		)
));


/**
 * Class tl_style_sheet_custom
 */
class tl_style_sheet_custom extends Backend
{

	/**
	 * Update style sheet
	 * @param object
	 */

	public function editSource($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');
		$this->loadLanguageFile('tl_files');

		if (!$this->User->isAdmin && !in_array('f5', $this->User->fop))
		{
			return '';
		}

		$strCssFile = $row['name'].'.css';

		if (!in_array('css', trimsplit(',', $GLOBALS['TL_CONFIG']['editableFiles'])))
		{
			return $this->generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
		}

		$title = $GLOBALS['TL_LANG']['tl_files']['editor'][0];
		return '<a href="'.$this->addToUrl($href.'&id='.$row['id'].'&pid='.$row['pid'].'&file='.$strCssFile).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

}

?>