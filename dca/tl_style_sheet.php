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
 * Table tl_style_sheet
 */
array_insert($GLOBALS['TL_DCA']['tl_style_sheet']['list']['operations'], 1, array
    (
    'source' => array
        (
        'label' => &$GLOBALS['TL_LANG']['tl_files']['source'],
        'href' => 'key=csseditor',
        'icon' => 'editor.gif',
        'button_callback' => array('CssEditor', 'editSource')
    )
));