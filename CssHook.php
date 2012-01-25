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

/**
 * Class CssHook
 *
 * @copyright  Cyril Ponce 2008-2011
 * @author     Cyril Ponce <cyril@contao.fr>
 * @package    CssEditor
 */
class CssHook extends System
{

    public function compileCufonDefinition($arrRow)
    {
        if ($arrRow['cufon']) {
            foreach($arrRow as $k=>$v)
            {
                switch($k)
                {
                    case 'cufon_font':
                    case 'cufon_fontFamily':
                    case 'cufon_hover':
                        $return .= $v.'|';
                        break;
                }
            }
            return "/*cufon:".rtrim($return,'|')."*/";
        }
    }

    public function createCufonDefinition($strKey, $strValue, $strDefinition, $arrSet)
    {
        if ($strKey == '/*cufon')
        {
            $arrCufon = explode('|',rtrim($strValue,'*/'));
            return array('cufon'=>1,'cufon_font'=>(strlen($arrCufon[0]))? $arrCufon[0] : '','cufon_fontfamily'=>(strlen($arrCufon[1]))? $arrCufon[1] : '','cufon_hover'=>(strlen($arrCufon[2]))? $arrCufon[2] : '');
        }
        return false;
    }

}

?>