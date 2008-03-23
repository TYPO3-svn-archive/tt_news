<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Rupert Germann <rg@rgdata.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   99: class tx_ttnews_module1 extends t3lib_SCbase
 *  112:     function init()
 *  133:     function initGPvars()
 *  145:     function menuConfig()
 *  165:     function main()
 *  228:     function moduleContent()
 *  267:     function ajaxExpandCollapse($params, &$ajaxObj)
 *  285:     function ajaxLoadList($params, &$ajaxObj)
 *  296:     function displayNewsList()
 *  332:     function initSubCategories()
 *  348:     function getTreeObj()
 *
 *              SECTION: Internal helper functions
 *  400:     function getNothingFoundMsg()
 *  412:     function getListHeaderMsg()
 *  439:     function renderCheckBoxes()
 *  465:     function getHeaderButtons()
 *  558:     function printContent()
 *
 *
 *  569: class tx_ttnews_recordlist extends tx_cms_layout
 *
 *              SECTION: Generic listing of items
 *  589:     function makeOrdinaryList($table, $id, $fList, $icon=0, $addWhere='')
 *  678:     function makeQueryArray($table, $id, $addWhere="",$fieldList='*')
 *
 *
 *  743: class tx_ttnewscatmanager_treeView extends tx_ttnews_categorytree
 *  755:     function wrapIcon($icon,&$row)
 *  773:     function wrapTitle($title,$v)
 *  804:     function makeControl($table,$row)
 *  868:     function issueCommand($params,$rUrl='')
 *
 * TOTAL FUNCTIONS: 21
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


	// DEFAULT initialization of a module [BEGIN]
unset($MCONF);
require('conf.php');
require($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');

$GLOBALS['LANG']->includeLLFile('EXT:tt_news/mod1/locallang.xml');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
$GLOBALS['BE_USER']->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]

require_once(PATH_t3lib.'class.t3lib_recordlist.php');
require_once(PATH_typo3.'class.db_list.inc');


require_once(t3lib_extMgm::extPath('tt_news').'lib/class.tx_ttnews_div.php');
require_once(t3lib_extMgm::extPath('tt_news').'lib/class.tx_ttnews_categorytree.php');

require_once(t3lib_extMgm::extPath('cms').'layout/class.tx_cms_layout.php');

/**
 * Module 'News Admin' for the 'tt_news' extension.
 *
 *
 * $Id$
 *
 * @author	Rupert Germann <rg@rgdata.de>
 * @package	TYPO3
 * @subpackage	tt_news
 */
class tx_ttnews_module1 extends t3lib_SCbase {
	var $pageinfo;
	var $treeObj;
	var $markers = array();
	var $docHeaderButtons = array();
	var $selectedCategories;
	var $limit = 20;

	/**
	 * Initializes the Module
	 *
	 * @return	void
	 */
	function init()	{
		parent::init();
		$this->confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);
		$this->script = 'index.php?id='.$this->id;
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$this->CALC_PERMS = $GLOBALS['BE_USER']->calcPerms($this->pageinfo);
		$this->EDIT_CONTENT = ($this->CALC_PERMS&16) ? 1 : 0;

/**
 * TODO
 * store the id in BEuser uc
 */

		$this->divObj = t3lib_div::makeInstance('tx_ttnews_div');

		$this->initGPvars();

	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function initGPvars() {
		$this->pointer = t3lib_div::intInRange(t3lib_div::_GP('pointer'),0,100000);
		$this->category = intval(t3lib_div::_GP('category'));

		$this->useSubCategories = TRUE;
		
	}

	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig()	{
		$this->MOD_MENU = array (
			'function' => array (
				'1' => $GLOBALS['LANG']->getLL('function1'),
//				'2' => $GLOBALS['LANG']->getLL('function2'),
// 				'3' => $LANG->getLL('function3'),
			),
			'showEditIcons' => 0,
			'expandAll' => 0,
			'useSubCategories' => 0
		);
		parent::menuConfig();
	}

	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return	[type]		...
	 */
	function main()	{
		global $LANG;


		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->backPath = $GLOBALS['BACK_PATH'];
		$this->doc->setModuleTemplate('mod_ttnews_admin.html');
		$this->doc->docType = 'xhtml_trans';
//		$this->doc->form='<form action="" method="POST">';

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user

		$access = is_array($this->pageinfo) ? 1 : 0;

		if (($this->id && $access))	{
				// JavaScript
			$this->doc->JScode = $this->doc->wrapScriptTags('
				script_ended = 0;
				function jumpToUrl(URL)	{	//
					window.location.href = URL;
				}
			'.$this->doc->redirectUrls());

			$this->doc->postCode=$this->doc->wrapScriptTags('
					script_ended = 1;
				');
			$this->doc->inDocStylesArray['tt_news_mod1'] = '
				#ttnewsadmin-tree { float:left; width:230px; border-right: 1px solid #bbb; }
				#ttnewsadmin-list {  padding: 0 10px 0 240px; }
				#togglesubcats { background:#ddd; padding: 2px; cursor: pointer; font-style:italic; }
				#newssubcats { background:#f8f9fa; padding: 2px; border:1px solid #ddd; }
				#resetcatselection { float:right; font-style:italic; }
			';

			// Render content:
			$this->moduleContent();
		} else {
				// If no access or if ID == zero
			$this->treeContent = $this->getNothingFoundMsg();
		}

		$this->docHeaderButtons = $this->getHeaderButtons();
		$this->markers['FUNC_MENU'] = ''/*t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])*/;
		$this->markers['TREE'] = $this->treeContent;
		$this->markers['LIST'] = $this->listContent;
		$this->markers['CSH'] = $this->docHeaderButtons['csh'];

		// put it all together
		$this->content = $this->doc->startPage($LANG->getLL('title'));
		$this->content.= $this->doc->moduleBody($this->pageinfo, $this->docHeaderButtons, $this->markers);
		$this->content.= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);

	}


	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				$this->table = 'tt_news_cat';
				if ($this->confArr['useStoragePid']) {
					$catRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid','tt_news_cat','pid='.$this->id.' AND deleted=0');
					if (empty($catRows)) {
						$content = $this->getNothingFoundMsg();
					}
				}
				if (!$content) {
					$content = $this->renderCheckBoxes();
					$this->getTreeObj();
					$content .= '<div id="ttnews-cat-tree">'.$this->treeObj->getBrowsableTree().'</div>';

					$this->doc->JScodeLibArray['txttnewsM1'] = '
						<script src="'.$GLOBALS['BACK_PATH'].t3lib_extMgm::extRelPath('tt_news').'js/tt_news_mod1.js" type="text/javascript"></script>
						';

					$this->doc->getDragDropCode('tt_news_cat');
					$this->doc->getContextMenuCode();
					$this->doc->postCode=$this->doc->wrapScriptTags('
							txttnewsM1js.registerDragDropHandlers();
					');

					$this->listContent = $this->doc->section($GLOBALS['LANG']->getLL('function1'),$this->displayNewsList(),0,1).$this->doc->sectionEnd();
				}
				$this->treeContent = $this->doc->section($GLOBALS['LANG']->getLL('function2'),$content,0,1).$this->doc->sectionEnd();
			break;
		}
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$$params: ...
	 * @param	[type]		$ajaxObj: ...
	 * @return	[type]		...
	 */
	function ajaxExpandCollapse($params, &$ajaxObj) {
		$this->init();
		$this->getTreeObj();
		$tree = $this->treeObj->getBrowsableTree();
		if (!$this->treeObj->ajaxStatus) {
			$ajaxObj->setError($tree);
		} else	{
			$ajaxObj->addContent('tree', $tree);
		}
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$$params: ...
	 * @param	[type]		$ajaxObj: ...
	 * @return	[type]		...
	 */
	function ajaxLoadList($params, &$ajaxObj) {
		$this->processAjaxRequestConstruct();
		$this->init();
		$list = $this->displayNewsList();
		$ajaxObj->addContent('ttnewslist', $list);
	}

	
	function processAjaxRequestConstruct() {
		require_once(PATH_typo3.'template.php');

		global $SOBE;

			// Create a new anonymous object:
		$SOBE = new stdClass();
			// Create an instance of the document template object
		$SOBE->doc = t3lib_div::makeInstance('template');
		$SOBE->doc->backPath = $GLOBALS['BACK_PATH'];
		$SOBE->doc->docType = 'xhtml_trans';
		
	}	
	
	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function displayNewsList()	{
		global $LANG,$BACK_PATH;

		$content = '';
		$this->initSubCategories();

		$table = 'tt_news';
		$dblist = t3lib_div::makeInstance('tx_ttnews_recordlist');
		$dblist->backPath = $BACK_PATH;
		$dblist->script = $this->script;
		$dblist->doEdit = $this->EDIT_CONTENT;
		$dblist->ext_CALC_PERMS = $this->CALC_PERMS;
		$dblist->agePrefixes = $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.minutesHoursDaysYears');
		$dblist->id = $this->id;
		$dblist->itemsLimitSingleTable = $this->limit;
		$dblist->selectedCategories = $this->selectedCategories;
		$dblist->category = $this->category;
		$dblist->returnUrl = t3lib_extMgm::extRelPath('tt_news').'mod1/'.$this->script;
		
		
		$dblist->start($this->id,$table,$this->pointer,$this->search_field,$this->search_levels,$this->showLimit);

		$externalTables[$table][0]['fList'] = 'uid,title,datetime,archivedate,tstamp,category;author';
		$externalTables[$table][0]['icon'] = TRUE;
		
		$dblist->externalTables = $externalTables;

		$dblist->no_noWrap = TRUE;
		
		$dblist->generateList();

		$content .= $this->getListHeaderMsg();
		$content .= $dblist->HTMLcode;

		return '<div id="ttnewslist">'.$content.'</div>';
	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function initSubCategories() {
		if ($this->useSubCategories && $this->category) {
			$subcats = $this->divObj->getSubCategories($this->category);
			$this->selectedCategories = t3lib_div::uniqueList($this->category.($subcats?','.$subcats:''));
		} else {
			$this->selectedCategories = $this->category;
		}
	}



	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getTreeObj() {
		if ($this->confArr['useStoragePid']) {
			$SPaddWhere = ' AND tt_news_cat.pid=' . $this->id;
		}
		$treeOrderBy = $this->confArr['treeOrderBy']?$this->confArr['treeOrderBy']:'uid';

		if (!is_object($this->treeObj)) {
			$this->treeObj = t3lib_div::makeInstance('tx_ttnewscatmanager_treeView');
		}

		$this->treeObj->table = 'tt_news_cat';
		$this->treeObj->init($SPaddWhere,$treeOrderBy);
		$this->treeObj->parentField = 'parent_category';
		$this->treeObj->thisScript = $this->script;
		$this->treeObj->returnUrl = t3lib_extMgm::extRelPath('tt_news').'mod1/'.$this->script;
		$this->treeObj->fieldArray = array('uid','title','description','hidden','starttime','endtime','fe_group'); // those fields will be filled to the array $this->treeObj->tree
		$this->treeObj->calcPerms = $this->CALC_PERMS;
		$this->treeObj->title = $GLOBALS['LANG']->getLL('treeTitle');
		$this->treeObj->pageID = $this->id;
		$this->treeObj->expandAll = $GLOBALS['SOBE']->MOD_SETTINGS['expandAll'];
		$this->treeObj->expandable = true;
		$this->treeObj->titleLen = 60;
		$this->treeObj->useAjax = true;
		$this->treeObj->showEditIcons = $GLOBALS['BE_USER']->uc['moduleData']['web_txttnewsM1']['showEditIcons'];
		$this->treeObj->category = $this->category;

//		$this->treeObj->allowedCategories = false;

	}












	/*************************************************************************
	 *
	 * 		Internal helper functions
	 *
	 ************************************************************************/


	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getNothingFoundMsg() {
		return '<table border="0" cellpadding="0" cellspacing="3"><tr>
				<td valign="top"><img'.t3lib_iconWorks::skinImg($this->doc->backPath,'gfx/icon_note.gif','width="18" height="16"').' title="" alt="" /></td>
				<td>'.$GLOBALS['LANG']->getLL('nothingfound').'</td>
				</tr></table>';
	}

	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getListHeaderMsg() {
		global $LANG;
		if (!$this->selectedCategories)  {
			$content = $LANG->getLL('showingAll');
		} else {
			$table = 'tt_news_cat';
			$row = t3lib_BEfunc::getRecord($table, $this->category);
			$reset = '<a href="'.$this->script.'" id="resetcatselection">'.$LANG->getLL('resetCatSelection').'</a>';
			$title = '<strong>'.t3lib_BEfunc::getRecordTitle($table,$row).'</strong>';
			$content = '<div id="newscatsmsg">'.$reset.$LANG->getLL('showOnlyCat').$title.'</div>';
			if ($this->useSubCategories && ($subCats = t3lib_div::rmFromList($this->category,$this->selectedCategories))) {
				$scRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid,title',$table,'uid IN ('.$subCats.')');
				$scTitles = array();
				foreach ($scRows as $scRow) {
					$scTitles[] = t3lib_BEfunc::getRecordTitle($table,$scRow);
				}
				$showLbl = $LANG->getLL('showSubcatgories');
				$hideLbl = $LANG->getLL('hideSubcatgories');
				$btnID = 'togglesubcats';
				$elID = 'newssubcats';
				$onclick = htmlspecialchars('if ($(\''.$elID.'\').visible()) {$(\''.$elID.'\').hide();$(\''.$btnID.'\').update('.$LANG->JScharCode($showLbl).');} else {$(\''.$elID.'\').show();$(\''.$btnID.'\').update('.$LANG->JScharCode($hideLbl).');}');
				$content .= '<div id="'.$btnID.'" onclick="'.$onclick.'">'.$showLbl.'</div>';
				$content .= '<div id="'.$elID.'" style="display:none;">'.implode(', ',$scTitles).'</div>';
			}
		}
		return $content;
	}



	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function renderCheckBoxes() {
		$content = t3lib_BEfunc::getFuncCheck(
						$this->id,
						'SET[showEditIcons]',
						$this->MOD_SETTINGS['showEditIcons'],'','',
						'id="checkShowEditIcons"'
					).' <label for="checkShowEditIcons">'.$GLOBALS['LANG']->getLL('showEditIcons',1).'</label><br />';

		$content .= t3lib_BEfunc::getFuncCheck(
						$this->id,
						'SET[expandAll]',
						$this->MOD_SETTINGS['expandAll'],'','',
						'id="checkExpandAll"'
					).' <label for="checkExpandAll">'.$GLOBALS['LANG']->getLL('expandAll',1).'</label><br />';

		return '<div>'.$content.'</div>';
	}




	/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return	array		all available buttons as an assoc. array
	 */
	function getHeaderButtons()	{
		global $LANG;

		$buttons = array(
			'csh' => '',
			'view' => '',
			'edit' => '',
			'record_list' => '',
			'new_record' => '',
			'paste' => '',
			'level_up' => '',
			'reload' => '',
			'shortcut' => '',
			'back' => '',
			'csv' => '',
			'export' => ''
		);

			// Get users permissions for this page record:
		$localCalcPerms = $GLOBALS['BE_USER']->calcPerms($this->pageinfo);
		$backPath = $GLOBALS['BACK_PATH'];

			// CSH
		if (!strlen($this->id))	{
			$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_txttnewsM1', 'list_module_noId', $GLOBALS['BACK_PATH']);
		} elseif(!$this->id) {
			$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_txttnewsM1', 'list_module_root', $GLOBALS['BACK_PATH']);
		} else {
			$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_txttnewsM1', 'list_module', $GLOBALS['BACK_PATH']);
		}

		if (isset($this->id)) {
			if ($GLOBALS['BE_USER']->check('modules','web_list'))	{
				$href = $backPath . 'db_list.php?id=' . $this->pageinfo['uid'] . '&returnUrl=' . rawurlencode(t3lib_div::getIndpEnv('REQUEST_URI'));
				$buttons['record_list'] = '<a href="' . htmlspecialchars($href) . '">' .
						'<img' . t3lib_iconWorks::skinImg($backPath, 'gfx/list.gif', 'width="11" height="11"') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.showList', 1) . '" alt="" />' .
						'</a>';
			}

				// View
			$buttons['view'] = '<a href="#" onclick="' . htmlspecialchars(t3lib_BEfunc::viewOnClick($this->id, $backPath, t3lib_BEfunc::BEgetRootLine($this->id))) . '">' .
							'<img' . t3lib_iconWorks::skinImg($backPath, 'gfx/zoom.gif') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.showPage', 1) . '" alt="" />' .
							'</a>';

				// If edit permissions are set (see class.t3lib_userauthgroup.php)
			if ($localCalcPerms&2 && !empty($this->id))	{
					// Edit
				$params = '&edit[pages][' . $this->pageinfo['uid'] . ']=edit';
				$buttons['edit'] = '<a href="#" onclick="' . htmlspecialchars(t3lib_BEfunc::editOnClick($params, $backPath, -1)) . '">' .
								'<img' . t3lib_iconWorks::skinImg($backPath, 'gfx/edit2.gif') . ' title="' . $LANG->getLL('editPage', 1) . '" alt="" />' .
								'</a>';
			}

//			if ($this->table) {
					// Export
				if (t3lib_extMgm::isLoaded('impexp')) {
					$params = 'mod.php?M=xMOD_tximpexp&tx_impexp[action]=export&tx_impexp[list][]='
								.rawurlencode('tt_news:' . $this->id).'&tx_impexp[list][]='
								.rawurlencode('tt_news_cat:' . $this->id);
					$buttons['export'] = '<a href="' . htmlspecialchars($backPath.$params).'">' .
									'<img' . t3lib_iconWorks::skinImg($backPath, t3lib_extMgm::extRelPath('impexp') . 'export.gif') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:rm.export', 1) . '" alt="" />' .
									'</a>';
				}
//			}

				// Reload
			$buttons['reload'] = '<a href="' . htmlspecialchars(t3lib_div::linkThisScript()) . '">' .
							'<img' . t3lib_iconWorks::skinImg($backPath, 'gfx/refresh_n.gif') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.reload', 1) . '" alt="" />' .
							'</a>';

				// Shortcut
			if ($GLOBALS['BE_USER']->mayMakeShortcut()) {
				$buttons['shortcut'] = $GLOBALS['TBE_TEMPLATE']->makeShortcutIcon('id, imagemode, pointer, table, search_field, search_levels, showLimit, sortField, sortRev', implode(',', array_keys($this->MOD_MENU)), 'web_list');
			}

				// Back
			if ($this->returnUrl) {
				$buttons['back'] = '<a href="' . htmlspecialchars(t3lib_div::linkThisUrl($this->returnUrl, array('id' => $this->id))) . '" class="typo3-goBack">' .
								'<img' . t3lib_iconWorks::skinImg($backPath, 'gfx/goback.gif') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.goBack', 1) . '" alt="" />' .
								'</a>';
			}
		}

		return $buttons;
	}



	/**
	 * Prints out the module HTML
	 *
	 * @return	void
	 */
	function printContent()	{
		echo $this->content;
	}


}

	/**
	 * [Describe function...]
	 *
	 */
class tx_ttnews_recordlist extends tx_cms_layout {



	/**********************************
	 *
	 * Generic listing of items
	 *
	 **********************************/

	/**
	 * Creates a standard list of elements from a table.
	 *
	 * @param	string		Table name
	 * @param	integer		Page id.
	 * @param	string		Comma list of fields to display
	 * @param	boolean		If true, icon is shown
	 * @param	string		Additional WHERE-clauses.
	 * @return	string		HTML table
	 */
	function makeOrdinaryList($table, $id, $fList, $icon=0, $addWhere='')	{
			// Initialize:
		$out = '';
		$queryParts = $this->makeQueryArray($table, $id, $addWhere);
		$this->setTotalItems($queryParts);
		$dbCount = 0;
		$this->eCounter = 0;

			// Make query for records if there were any records found in the count operation:
		if ($this->totalItems)	{
			$result = $GLOBALS['TYPO3_DB']->exec_SELECT_queryArray($queryParts);
			$dbCount = $GLOBALS['TYPO3_DB']->sql_num_rows($result);
		}

			// If records were found, render the list:
		if ($dbCount)	{

				// Set fields
			$this->fieldArray = explode(',','__cmds__,'.$fList);

				// Header line is drawn
			$theData = array();
			$theData = $this->headerFields($this->fieldArray,$table,$theData);
			if ($this->doEdit)	{
				$params = '&edit['.$table.']['.$this->id.']=new'.($this->category?'&defVals['.$table.'][category]='.$this->category:'');
				$onclick = htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl));
				$theData['__cmds__'] = '<a href="#" onclick="'.$onclick.'">'.
					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/new_el.gif').' title="'.$GLOBALS['LANG']->getLL('new',1).'" alt="" />'.
					'</a>';
			}
			$out.= $this->addelement(1,'',$theData,' class="c-headLine"',15);

				// Render Items
			$this->eCounter = $this->firstElementNumber;
			while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)))	{
				t3lib_BEfunc::workspaceOL($table, $row);

				if (is_array($row))	{
					list($flag,$code) = $this->fwd_rwd_nav();
					$out.= $code;
					if ($flag)	{
						$params = '&edit['.$table.']['.$row['uid'].']=edit';
						$Nrow = array();

							// Setting icons/edit links:
						if ($icon)	{
							$Nrow['__cmds__']= $this->getIcon($table,$row);
						}
						if ($this->doEdit)	{
							$Nrow['__cmds__'].= '<a href="#" onclick="'.htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl)).'">'.
											'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/edit2.gif','width="11" height="12"').' title="'.$GLOBALS['LANG']->getLL('edit',1).'" alt="" />'.
											'</a>';
						} else {
							$Nrow['__cmds__'].= $this->noEditIcon();
						}

							// Get values:
						$Nrow = $this->dataFields($this->fieldArray,$table,$row,$Nrow);
						$tdparams = $this->eCounter%2 ? ' class="bgColor4"' : ' class="bgColor4-20"';
						$out.= $this->addelement(1,'',$Nrow,$tdparams);
					}
					$this->eCounter++;
				}
			}

				// Wrap it all in a table:
			$out='

				<!--
					STANDARD LIST OF "'.$table.'"
				-->
				<table border="0" cellpadding="1" cellspacing="2" id="typo3-page-stdlist">
					'.$out.'
				</table>';
		}
		return $out;
	}



	/**
	 * Header fields made for the listing of records
	 *
	 * @param	array		Field names
	 * @param	string		The table name
	 * @param	array		Array to which the headers are added.
	 * @return	array		$out returned after addition of the header fields.
	 * @see makeOrdinaryList()
	 */
	function headerFields($fieldArr,$table,$out=array())	{
		global $TCA;

		t3lib_div::loadTCA($table);

		foreach($fieldArr as $fieldName)	{
			$ll = $GLOBALS['LANG']->sL($TCA[$table]['columns'][$fieldName]['label'],1);
			$out[$fieldName] = '<strong>'.($ll?$this->addSortLink($ll,$fieldName,$table):'&nbsp;').'</strong>';
		}
		
		return $out;
	}

	/**
	 * Creates a sort-by link on the input string ($code).
	 * It will automatically detect if sorting should be ascending or descending depending on $this->sortRev.
	 * Also some fields will not be possible to sort (including if single-table-view is disabled).
	 *
	 * @param	string		The string to link (text)
	 * @param	string		The fieldname represented by the title ($code)
	 * @param	string		Table name
	 * @return	string		Linked $code variable
	 */
	function addSortLink($code,$field,$table)	{

			// Certain circumstances just return string right away (no links):
		if ($field=='_CONTROL_' || $field=='_LOCALIZATION_' || $field=='_CLIPBOARD_' || $field=='_REF_' || $this->disableSingleTableView)	return $code;

			// If "_PATH_" (showing record path) is selected, force sorting by pid field (will at least group the records!)
		if ($field=='_PATH_')	$field=pid;

			//	 Create the sort link:
		$sortUrl = $this->listURL('',-1,'sortField,sortRev,table').'&table='.$table.'&sortField='.$field.'&sortRev='.($this->sortRev || ($this->sortField!=$field)?0:1);
		$sortArrow = ($this->sortField==$field?'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/red'.($this->sortRev?'up':'down').'.gif','width="7" height="4"').' alt="" />':'');

			// Return linked field:
		return '<a href="'.htmlspecialchars($sortUrl).'">'.$code.
				$sortArrow.
				'</a>';
	}
	
	/**
	 * Creates the URL to this script, including all relevant GPvars
	 * Fixed GPvars are id, table, imagemode, returlUrl, search_field, search_levels and showLimit
	 * The GPvars "sortField" and "sortRev" are also included UNLESS they are found in the $exclList variable.
	 *
	 * @param	string		Alternative id value. Enter blank string for the current id ($this->id)
	 * @param	string		Tablename to display. Enter "-1" for the current table.
	 * @param	string		Commalist of fields NOT to include ("sortField" or "sortRev")
	 * @return	string		URL
	 */
	function listURL($altId='',$table=-1,$exclList='')	{
		return $this->script.
			'?id='.(strcmp($altId,'')?$altId:$this->id).
			'&table='.rawurlencode($table==-1?$this->table:$table).
			($this->thumbs?'&imagemode='.$this->thumbs:'').
			($this->returnUrl?'&returnUrl='.rawurlencode($this->returnUrl):'').
			($this->searchString?'&search_field='.rawurlencode($this->searchString):'').
			($this->searchLevels?'&search_levels='.rawurlencode($this->searchLevels):'').
			($this->showLimit?'&showLimit='.rawurlencode($this->showLimit):'').
			($this->firstElementNumber?'&pointer='.rawurlencode($this->firstElementNumber):'').
			((!$exclList || !t3lib_div::inList($exclList,'sortField')) && $this->sortField?'&sortField='.rawurlencode($this->sortField):'').
			((!$exclList || !t3lib_div::inList($exclList,'sortRev')) && $this->sortRev?'&sortRev='.rawurlencode($this->sortRev):'').
			($this->category?'&category='.$this->category:'')
			;
	}	
	
	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$table: ...
	 * @param	[type]		$id: ...
	 * @param	[type]		$addWhere: ...
	 * @param	[type]		$fieldList: ...
	 * @return	[type]		...
	 */
	function makeQueryArray($table, $id, $addWhere="",$fieldList='')	{
		global $TCA;
		if (!$fieldList) {
			$fieldList = $table.'.*';
		}
		
			// Set ORDER BY:
		$orderBy = ($TCA[$table]['ctrl']['sortby']) ? 'ORDER BY '.$TCA[$table]['ctrl']['sortby'] : $TCA[$table]['ctrl']['default_sortby'];
		if ($this->sortField)	{
			if (in_array($this->sortField,$this->makeFieldList($table,1)))	{
				$orderBy = 'ORDER BY '.$this->sortField;
				if ($this->sortRev)	$orderBy.=' DESC';
			}
		}

			// Set LIMIT:
		$limit = $this->iLimit ? ($this->firstElementNumber ? $this->firstElementNumber.',' : '').($this->iLimit+1) : '';

			// Adding search constraints:
		$search = $this->makeSearchString($table);

		if ($this->selectedCategories) {
			$mmTable = 'tt_news_cat_mm';
			$fieldList = 'DISTINCT('.$mmTable.'.uid_local), '.$fieldList;
			
			$leftjoin = ' LEFT JOIN '.$mmTable.' ON '.$table.'.uid='.$mmTable.'.uid_local';
			$catWhere = ' AND '.$mmTable.'.uid_foreign IN ('.$this->selectedCategories.')';
		}
		
		// FIXME only for admins ??
		$this->pidSelect = '1=1';
		
		// FIXME how to deal with multiple languages
		$addWhere .= ' AND '.$table.'.sys_language_uid=0';

		// Compiling query array:
		$queryParts = array(
			'SELECT' => $fieldList,
			'FROM' => $table.$leftjoin,
			'WHERE' => $this->pidSelect.
						t3lib_BEfunc::deleteClause($table).
						t3lib_BEfunc::versioningPlaceholderClause($table).
						' '.$addWhere.
						' '.$search.$catWhere,
			'GROUPBY' => '',
			'ORDERBY' => $GLOBALS['TYPO3_DB']->stripOrderBy($orderBy),
			'LIMIT' => $limit
		);

			// Return query:
		return $queryParts;
	}
}















	/**
	 * [Describe function...]
	 *
	 */
class tx_ttnewscatmanager_treeView extends tx_ttnews_categorytree {

	var $TCEforms_itemFormElName='';
	var $TCEforms_nonSelectableItemsArray=array();

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$icon: ...
	 * @param	[type]		$row: ...
	 * @return	[type]		...
	 */
	function wrapIcon($icon,&$row)	{
		$theIcon = $this->addTagAttributes($icon, $this->titleAttrib.'="'.$this->getTitleAttrib($row).'"');
		if($row['uid']>0) {
			$theIcon = $GLOBALS['TBE_TEMPLATE']->wrapClickMenuOnIcon($theIcon,'tt_news_cat_CM',$row['uid'],0,'&bank='.$this->bank);
			$theIcon = '<span class="dragIcon" id="dragIconID_'.$row['uid'].'">'.$theIcon.'</span>';
		} else {
			$theIcon = '<span class="dragIcon" id="dragIconID_0">'.$theIcon.'</span>';
		}
		return $theIcon;
	}

	/**
	 * wraps the record titles in the tree with links or not depending on if they are in the TCEforms_nonSelectableItemsArray.
	 *
	 * @param	string		$title: the title
	 * @param	array		$v: an array with uid and title of the current item.
	 * @return	string		the wrapped title
	 */
	function wrapTitle($title,$v)	{
// 		debug($v);
		if($v['uid']>0) {
			$hrefTitle = htmlentities('[id='.$v['uid'].'] '.$v['description']);
			$js = htmlspecialchars('txttnewsM1js.loadList(\''.$v['uid'].'\', $(\'ttnewslist\'), \''.intval($this->pageID).'\');');
			$out =  '<a href="#" onclick="'.$js.'" title="'.$hrefTitle.'">'.$title.'</a>';

			// Wrap title in a drag/drop span.
			$out = '<span class="dragTitle" id="dragTitleID_'.$v['uid'].'">'.$out.'</span>';
			if ($this->showEditIcons) {
				$out .= $this->makeControl('tt_news_cat',$v);
			}
		} else {
			$out = '<span class="dragTitle" id="dragTitleID_0">'.$title.'</span>';
		}
		return $out;
	}

	/**
	 * Creates the control panel for a single record in the listing.
	 *
	 * @param	string		The table
	 * @param	array		The record for which to make the control panel.
	 * @return	string		HTML table with the control panel (unless disabled)
	 */
	function makeControl($table,$row)	{
		global $TCA, $LANG;

			// Initialize:
		t3lib_div::loadTCA($table);
		$cells=array();
			// This expresses the edit permissions for this particular element:
		$permsEdit = ($table!='pages' && ($this->calcPerms&16));
			// "Edit" link: ( Only if permissions to edit the page-record of the content of the parent page ($this->id)
		if ($permsEdit)	{
			$params='&edit['.$table.']['.$row['uid'].']=edit';
			$cells[]='<a href="#" onclick="'.htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl)).'">'.
					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/edit2'.(!$TCA[$table]['ctrl']['readOnly']?'':'_d').'.gif',
						'width="11" height="12"').' title="'.$LANG->getLLL('edit',$this->LL).'" alt="" />'.
					'</a>';
		}

// 			// "Info": (All records)
// 		$cells[]='<a href="#" onclick="'.htmlspecialchars('top.launchView(\''.$table.'\', \''.$row['uid'].'\'); return false;').'">'.
// 				'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/zoom2.gif','width="12" height="12"').' title="'.$LANG->getLLL('showInfo',$this->LL).'" alt="" />'.
// 				'</a>';

			// "Hide/Unhide" links:
		$hiddenField = $TCA[$table]['ctrl']['enablecolumns']['disabled'];
		if ($permsEdit && $hiddenField && $TCA[$table]['columns'][$hiddenField] &&
				(!$TCA[$table]['columns'][$hiddenField]['exclude'] || $GLOBALS['BE_USER']->check('non_exclude_fields',$table.':'.$hiddenField)))	{
			if ($row[$hiddenField])	{
				$params='&data['.$table.']['.$row['uid'].']['.$hiddenField.']=0';
				$cells[]='<a href="#" onclick="'.htmlspecialchars('return jumpToUrl(\''.$this->issueCommand($params,$this->returnUrl).'\');').'">'.
						'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_unhide.gif',
							'width="11" height="10"').' title="'.$LANG->getLLL('unHide',$this->LL).'" alt="" />'.
						'</a>';
			} else {
				$params='&data['.$table.']['.$row['uid'].']['.$hiddenField.']=1';
				$cells[]='<a href="#" onclick="'.htmlspecialchars('return jumpToUrl(\''.$this->issueCommand($params,$this->returnUrl).'\');').'">'.
						'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/button_hide.gif',
							'width="11" height="10"').' title="'.$LANG->getLLL('hide',$this->LL).'" alt="" />'.
						'</a>';
			}
		}

			// "Delete" link:
// 		if (
// 			($table=='pages' && ($localCalcPerms&4)) || ($table!='pages' && ($this->calcPerms&16))
// 			)	{
// 			$params='&cmd['.$table.']['.$row['uid'].'][delete]=1';
// 			$cells[]='<a href="#" onclick="'.htmlspecialchars('if (confirm('.$LANG->JScharCode($LANG->getLLL('deleteWarning',$this->LL).t3lib_BEfunc::referenceCount($table,$row['uid'],' (There are %s reference(s) to this record!)')).')) {jumpToUrl(\''.$SOBE->doc->issueCommand($params).'\');} return false;').'">'.
// 					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/garbage.gif','width="11" height="12"').' title="'.$LANG->getLLL('delete',$this->LL).'" alt="" />'.
// 					'</a>';
// 		}


		return '
				<!-- CONTROL PANEL: '.$table.':'.$row['uid'].' -->
				<span style="padding:0 0 0 7px;">'.implode('',$cells).'</span>';
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$params: ...
	 * @param	[type]		$rUrl: ...
	 * @return	[type]		...
	 */
	function issueCommand($params,$rUrl='')	{
		$rUrl = $rUrl ? $rUrl : t3lib_div::getIndpEnv('REQUEST_URI');
		return $this->backPath.'tce_db.php?'.
				$params.
				'&redirect='.($rUrl==-1?"'+T3_THIS_LOCATION+'":rawurlencode($rUrl)).
				'&vC='.rawurlencode($GLOBALS['BE_USER']->veriCode()).
				'&prErr=1&uPT=1';
	}





}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/mod1/index.php']);
}

if (!(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_AJAX)) {
	$SOBE = t3lib_div::makeInstance('tx_ttnews_module1');
	$SOBE->init();
	foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

	$SOBE->main();
	$SOBE->printContent();
}

?>