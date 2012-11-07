<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   CssEditor
 * @author	Cyril Ponce <cyril@contao.fr>
 * @license   LGPL
 * @copyright Cyril Ponce 2008-2012
 */


/**
 * Namespace
 */
namespace Contao;

/**
 * Class CssEditor
 *
 * @copyright Cyril Ponce 2008-2012
 * @author    Cyril Ponce <cyril@contao.fr>
 * @package   CssEditor
 */
class CssEditor extends \StyleSheets
{

	/**
	 * Save input
	 * @var boolean
	 */
	protected $blnSave = true;

	public function __construct()
	{
		$GLOBALS['TL_CSS'][] = 'system/modules/css_editor/assets/csseditor.css';
		
		// Include the CodeMirror scripts
		$GLOBALS['TL_CSS'][] = 'assets/codemirror/'.CODEMIRROR.'/codemirror.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'assets/codemirror/'.CODEMIRROR.'/codemirror.js';
		
		// Include the CodeMirror UI scripts
		$GLOBALS['TL_CSS'][] = 'system/modules/css_editor/assets/codemirror-ui.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/css_editor/assets/codemirror-ui.js';

		parent::__construct();
	}

	/**
	 *  View css source
	 */
	public function ViewSource(DataContainer $dc)
	{
		/*$objStyleSheet = $this->Database->prepare("SELECT id, name, cc, media, mediaQuery, vars, (SELECT tstamp FROM `tl_style` s WHERE s.pid=? ORDER BY tstamp ASC LIMIT 1) AS tstamp FROM `tl_style_sheet` ss WHERE ss.id=?")*/
		$objStyleSheet = $this->Database->prepare("SELECT id, pid, name, cc, media, mediaQuery, vars, (SELECT tstamp FROM `tl_style` s WHERE s.pid=? ORDER BY tstamp ASC LIMIT 1) AS tstamp FROM `tl_style_sheet` ss WHERE ss.id=?")
				->execute($dc->id, $dc->id);

		$objTheme = $this->Database->prepare("SELECT vars FROM `tl_theme` as t WHERE t.id=?")
				->execute($objStyleSheet->pid);

		if ($objStyleSheet->numRows < 1)
		{
			return;
		}

		/**
		 * Template
		 */
		$this->Template = new BackendTemplate('be_cssedit');
		$this->Template->href = $this->getReferer(ENCODE_AMPERSANDS);
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
		$this->Template->action = ampersand($this->Environment->request, true);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
		$this->Template->headline = sprintf($GLOBALS['TL_LANG']['tl_style_sheet']['edit'][1], $dc->id);
		$this->Template->message = "";

		// Template header
		$this->Template->cssid = $dc->id;
		$this->loadLanguageFile('tl_style');
		$this->Template->editHeader = specialchars($GLOBALS['TL_LANG']['tl_style']['editheader'][1]);
		$this->Template->editHeaderUrl = $this->Environment->base . preg_replace('/&(amp;)?(key)=[^&]*/', '&act=edit', $this->Environment->request);
		$this->Template->lblname = $GLOBALS['TL_LANG']['tl_style_sheet']['name'][0];
		$this->Template->lbltypes = $GLOBALS['TL_LANG']['tl_style_sheet']['media'][0];
		$this->Template->lblrevision = $GLOBALS['TL_LANG']['tl_style_sheet']['tstamp'][0];
		$this->Template->lblgvars = $GLOBALS['TL_LANG']['tl_style_sheet']['sheetvars'];
		$this->Template->lbltvars = $GLOBALS['TL_LANG']['tl_style_sheet']['themevars'];
		$this->Template->lblcc = $GLOBALS['TL_LANG']['tl_style_sheet']['cc'][0];
		$this->Template->lblmediaQuery = $GLOBALS['TL_LANG']['tl_style_sheet']['mediaQuery'][0];
		$this->Template->name = $objStyleSheet->name;
		$this->Template->types = implode(',', deserialize($objStyleSheet->media));
		$this->Template->revision = ($objStyleSheet->tstamp != null) ? date($GLOBALS['TL_CONFIG']['dateFormat'] . ' ' . $GLOBALS['TL_CONFIG']['timeFormat'], $objStyleSheet->tstamp) : '-';

		//$tmpVars = '';
		$tmp_tVars = '';

		if(count(deserialize($objTheme->vars)) > 0)
		{
			$tmp_tVars .= '<table class="tblVars">';
			$i = 0;
			foreach(deserialize($objTheme->vars) as $var)
			{
			$i++;
			($i % 2 == 0) ? $class = 'even' : $class = 'odd';
				$tmp_tVars .= '<tr class= "' . $class . '"><td>' . $var['key'] . '</td><td>:</td><td><em>' . $var['value'] . '</em></td></tr>';
			}
			$tmp_tVars .= '</table>';
		}

		if(count(deserialize($objStyleSheet->vars)) > 0)
		{
			//$tmpVars = '<table class="tblVars">';
			$tmp_gVars .= '<table class="tblVars">';
			$i = 0;
			foreach(deserialize($objStyleSheet->vars) as $var)
			{
				$i++;
				($i % 2 == 0) ? $class = 'even' : $class = 'odd';
				//$tmpVars .= '<tr class= "' . $class . '"><td>' . $var['key'] . '</td><td>:</td><td><em>' . $var['value'] . '</em></td></tr>';
				$tmp_gVars .= '<tr class= "' . $class . '"><td>' . $var['key'] . '</td><td>:</td><td><em>' . $var['value'] . '</em></td></tr>';
			}
			//$tmpVars .= '</table>';
			$tmp_gVars .= '</table>';
		}
		//$this->Template->vars = $tmpVars;
		$this->Template->tVars = $tmp_tVars;
		$this->Template->gVars = $tmp_gVars;

		$this->Template->cc = $objStyleSheet->cc;
		$this->Template->mediaQuery = $objStyleSheet->mediaQuery;

		// Template footer
		$this->Template->submit = $GLOBALS['TL_LANG']['MSC']['save'];
		$this->Template->submitClose = $GLOBALS['TL_LANG']['MSC']['saveNclose'];
		$this->Template->language = $GLOBALS['TL_LANGUAGE'];

		$objDefinitions = $this->Database->prepare("SELECT * FROM tl_style WHERE pid=? AND invisible!=1 ORDER BY sorting")
		//$objDefinitions = $this->Database->prepare("SELECT * FROM tl_style WHERE pid=? ORDER BY sorting")
				->execute($dc->id);

		$csscontent = '';
		$tmpCategory = '';
		while ($objDefinitions->next())
		{
			$row = $objDefinitions->row();


			if ($row['category'] != '' && ($row['category'] != $tmpCategory))
			{
				$csscontent .= "\n/** " . $row['category'] . " **/";
				$tmpCategory = $row['category'];
			}

			$csscontent .= strip_tags($this->compileDefinition($row));
		}

		// Update css when form  is posted
		if ($this->Input->post('FORM_SUBMIT') == 'tl_cssedit' && $this->blnSave)
		{
			$this->prepareDefinitions($objStyleSheet, $this->getCssContentWidget()->value);
			// Write style sheet
			$this->writeStyleSheet($objStyleSheet->row());

			if ($this->Input->post('saveNclose'))
			{
				// Redirect
				setcookie('BE_PAGE_OFFSET', 0, 0, '/');
				if ($this->Input->get('key') == 'csseditor')
				{
					$this->redirect($this->getReferer(ENCODE_AMPERSANDS));
				}
				else
				{
					$this->redirect($this->Environment->request);
				}
			}
		}

		$this->Template->csscontent = $this->getCssContentWidget($csscontent);
		$this->Template->contentId = $this->getCssContentWidget()->id;
		$this->Template->startHighlight = ($GLOBALS['TL_CONFIG']['css_editor_startHighlight']) ? 'true' : 'false';
		$this->Template->useRTEditor = $GLOBALS['TL_CONFIG']['css_editor_useRTEditor'];
		$this->Template->startHeight = $GLOBALS['TL_CONFIG']['css_editor_startHeight'];

		// Template output
		return $this->Template->parse();
	}

	protected function prepareDefinitions($objStyleSheet, $strContent)
	{
		// Update style sheet
		$this->Database->prepare("DELETE FROM tl_style WHERE pid=?")
				->execute($objStyleSheet->id);

		$insertId = $objStyleSheet->id;
		$intSorting = 0;
		$strComment = '';
		$strCategory = '';
		$arrChunks = array();

		if (!is_numeric($insertId) || $insertId < 0)
		{
			throw new Exception('Invalid insert ID');
		}

		$strContent = str_replace('/**/', '[__]', $strContent);
		$strContent = preg_replace('/\/\*\*\n( *\*.*\n){2,} *\*\//', '', $strContent); // see #2974
		$arrChunks = preg_split('/\{([^\}]*)\}|\*\//U', $strContent, -1, PREG_SPLIT_DELIM_CAPTURE);

		// Create format definitions
		for ($i = 0; $i < count($arrChunks); $i++)
		{
			$strChunk = trim($arrChunks[$i]);

			if ($strChunk == '')
			{
				continue;
			}

			$strChunk = preg_replace('/[\n\r\t]+/', ' ', $strChunk);

			// Category
			if (strncmp($strChunk, '/**', 3) === 0)
			{
				$strCategory = str_replace(array('/*', '*/', '*', '[__]'), '', $strChunk);
				$strCategory = trim(preg_replace('/\s+/', ' ', $strCategory));
			}

			// Comment
			elseif (strncmp($strChunk, '/*', 2) === 0)
			{
				$strComment = str_replace(array('/*', '*/', '*', '[__]'), '', $strChunk);
				$strComment = trim(preg_replace('/\s+/', ' ', $strComment));
			}

			// Format definition
			else
			{
				$strNext = trim($arrChunks[$i + 1]);
				$strNext = preg_replace('/[\n\r\t]+/', ' ', $strNext);

				$arrDefinition = array
				(
					'pid' => $insertId,
					'category' => $strCategory,
					'comment' => $strComment,
					'sorting' => $intSorting += 128,
					'selector' => $strChunk,
					'attributes' => $strNext
				);

				$this->createDefinition($arrDefinition);

				++$i;
				$strComment = '';
			}
		}

		// Write the style sheet
		$this->updateStyleSheet($objStyleSheet->id);
	}


	/**
	 * Write a style sheet to a file
	 * @param array
	 */
	protected function writeStyleSheet($row)
	{
		if ($row['id'] == '' || $row['name'] == '')
		{
			return;
		}

		$row['name'] = basename($row['name']);

		// Check whether the target file is writeable
		if (file_exists(TL_ROOT . '/assets/css/' . $row['name'] . '.css') && !$this->Files->is_writeable('assets/css/' . $row['name'] . '.css'))
		{
			\Message::addError(sprintf($GLOBALS['TL_LANG']['ERR']['notWriteable'], 'assets/css/' . $row['name'] . '.css'));
			return;
		}

		$vars = array();

		// Get the global theme variables
		$objTheme = $this->Database->prepare("SELECT vars FROM tl_theme WHERE id=?")
								   ->limit(1)
								   ->execute($row['pid']);

		if ($objTheme->vars != '')
		{
			if (is_array(($tmp = deserialize($objTheme->vars))))
			{
				foreach ($tmp as $v)
				{
					$vars[$v['key']] = $v['value'];
				}
			}
		}

		// Merge the global style sheet variables
		if ($row['vars'] != '')
		{
			if (is_array(($tmp = deserialize($row['vars']))))
			{
				foreach ($tmp as $v)
				{
					$vars[$v['key']] = $v['value'];
				}
			}
		}

		// Sort by key length (see #3316)
		uksort($vars, 'length_sort_desc');

		$objFile = new \File('assets/css/' . $row['name'] . '.css');
		$objFile->write('/* Style sheet ' . $row['name'] . " */\n");

		$objDefinitions = $this->Database->prepare("SELECT * FROM tl_style WHERE pid=? AND invisible!=1 ORDER BY sorting")
										 ->executeUncached($row['id']);

		// Append the definition
		while ($objDefinitions->next())
		{
			$objFile->append($this->compileDefinition($objDefinitions->row(), true, $vars, $row), '');
		}

		$objFile->close();
	}

	/**
	 * Return the css content widget as object
	 * @param mixed
	 * @return object
	 */
	private function getCssContentWidget($value=null)
	{
		$this->loadLanguageFile('tl_files');

		$widget = new TextArea();
		$widget->id = 'csscontent';
		$widget->name = 'csscontent';
		$widget->mandatory = true;
		$widget->decodeEntities = true;
		if(!$this->useRTEditor)
		{
		$widget->style = 'height:' . $GLOBALS['TL_CONFIG']['css_editor_startHeight'] . 'px;';
		}
		$widget->value = $value;
		$widget->label = $GLOBALS['TL_LANG']['tl_files']['editor'][0];

		// Validate input
		if ($this->Input->post('FORM_SUBMIT') == 'tl_cssedit')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}


	public function editSource($row, $href, $label, $title, $icon, $attributes) {
		$this->import('BackendUser', 'User');
		$this->loadLanguageFile('tl_files');

		if (!$this->User->isAdmin && !in_array('f5', $this->User->fop)) {
			return '';
		}

		$strCssFile = $row['name'] . '.css';

		if (!in_array('css', trimsplit(',', $GLOBALS['TL_CONFIG']['editableFiles']))) {
			return $this->generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ';
		}

		$title = $GLOBALS['TL_LANG']['tl_files']['editor'][0];
		return '<a href="' . $this->addToUrl($href . '&id=' . $row['id'] . '&pid=' . $row['pid'] . '&file=' . $strCssFile) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
	}
}
