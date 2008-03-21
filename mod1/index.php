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
 *  105: class  tx_newsadmin_module1 extends t3lib_SCbase
 *  121:     function init()
 *  221:     function menuConfig()
 *
 * TOTAL FUNCTIONS: 44
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

require_once(t3lib_extMgm::extPath('tt_news').'lib/class.tx_ttnews_div.php');
require_once(t3lib_extMgm::extPath('tt_news').'lib/class.tx_ttnews_categorytree.php');

/**
 * Module 'News Admin' for the 'tt_news' extension.
 *
 * @author	Rupert Germann <rg@rgdata.de>
 * @package	TYPO3
 * @subpackage	tt_news
 * 
 * $Id$
 *  
 */
class tx_ttnews_module1 extends t3lib_SCbase {
	var $pageinfo;
	var $treeObj;

	/**
	 * Initializes the Module
	 *
	 * @return	void
	 */
	function init()	{
		parent::init();
		$this->confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);
	}

	
	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig()	{
		$this->MOD_MENU = Array (
			'function' => Array (
				'1' => $GLOBALS['LANG']->getLL('function1'),
//				'2' => $GLOBALS['LANG']->getLL('function2'),
// 				'3' => $LANG->getLL('function3'),
			),
			'showEditIcons' => 0,
			'expandAll' => 0
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
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;

		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{
				// Draw the header.
			$this->doc = t3lib_div::makeInstance('bigDoc');
			$this->doc->backPath = $GLOBALS['BACK_PATH'];
			$this->doc->form = '';

				// JavaScript
			$this->doc->JScode = $this->doc->wrapScriptTags('
				script_ended = 0;
				function jumpToUrl(URL)	{	//
					window.location.href = URL;
				}
			'.$this->doc->redirectUrls());

			$this->doc->postCode=$this->doc->wrapScriptTags('
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = 0;
					beCategoryTree.registerDragDropHandlers();
				');
			
			$this->doc->JScodeLibArray[] = '
				<script src="'.$GLOBALS['BACK_PATH'].t3lib_extMgm::extRelPath('tt_news').'js/beCategoryTree.js" type="text/javascript"></script>';
			
			$this->doc->getDragDropCode('tt_news_cat');
			$this->doc->getContextMenuCode();
			
			$headerSection = $this->doc->getHeader(
				'pages',
				$this->pageinfo,
				$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],
				50);

			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));

			// Render content:
			$this->moduleContent();

			// ShortCut
			if ($BE_USER->mayMakeShortcut())	{
				$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
			}

			$this->content.=$this->doc->spacer(10);
		} else {
				// If no access or if ID == zero

			$this->doc = t3lib_div::makeInstance('mediumDoc');
			$this->doc->backPath = $BACK_PATH;

			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->getNothingFoundMsg();
			$this->content.=$this->doc->spacer(10);
		}
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$$params: ...
	 * @param	[type]		$ajaxObj: ...
	 * @return	[type]		...
	 */
	function ajaxExpandCollapse(&$params, &$ajaxObj) {
		$this->init();
		$this->initTreeObj();
		
		$tree = $this->treeObj->getBrowsableTree();		

		if (!$this->treeObj->ajaxStatus) {
			$ajaxObj->setError($tree);
		} else	{
			$ajaxObj->addContent('tree', $tree);
		}
	}

	
	function initTreeObj() {
		if ($this->confArr['useStoragePid']) {
//			$TSconfig = t3lib_BEfunc::getTCEFORM_TSconfig($this->table,$this->row);
//			$this->id = intval(t3lib_div::_GP('id'));
			$SPaddWhere = ' AND tt_news_cat.pid=' . $this->id;
		}
		
		$treeOrderBy = $this->confArr['treeOrderBy']?$this->confArr['treeOrderBy']:'uid';
		
		if (!is_object($this->treeObj)) {
			$this->treeObj = t3lib_div::makeInstance('tx_ttnewscatmanager_treeView');
		}

//		$this->treeObj->treeName = 'ttNewsCatTree';
		$this->treeObj->table = 'tt_news_cat';
		$this->treeObj->init($SPaddWhere,$treeOrderBy);
		
		if (!is_object($this->doc)) {
			$pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		} 
//		else {
//			$this->treeObj->doc = &$this->doc;
//		}
//		$this->treeObj->backPath = $GLOBALS['BACK_PATH'];
		$this->treeObj->parentField = 'parent_category';
		$this->treeObj->thisScript = 'index.php?id='.$this->id;
		$this->treeObj->returnUrl = t3lib_extMgm::extRelPath('tt_news').'mod1/'.$this->treeObj->thisScript;
		
		$this->treeObj->fieldArray = array('uid','title','description','hidden','starttime','endtime','fe_group'); // those fields will be filled to the array $this->treeObj->tree
		$this->treeObj->calcPerms = $GLOBALS['BE_USER']->calcPerms($pageinfo);
		$this->treeObj->title = $GLOBALS['LANG']->getLL('treeTitle');
		$this->treeObj->pageID = $this->id;		
		$this->treeObj->expandAll = $GLOBALS['SOBE']->MOD_SETTINGS['expandAll'];
		$this->treeObj->expandable = true;
		$this->treeObj->titleLen = 60;
		$this->treeObj->useAjax = true;
		$this->treeObj->showEditIcons = $GLOBALS['BE_USER']->uc['moduleData']['web_txttnewsM1']['showEditIcons'];
		
//		$this->treeObj->allowedCategories = false;
	
	}	
	
	function getNothingFoundMsg() {
		return '<table border="0" cellpadding="0" cellspacing="3"><tr>
				<td valign="top"><img'.t3lib_iconWorks::skinImg($this->doc->backPath,'gfx/icon_note.gif','width="18" height="16"').' title="" alt="" /></td>
				<td>'.$GLOBALS['LANG']->getLL('nothingfound').'</td>
				</tr></table>';
	}
	
	
	/**
	 * Prints out the module HTML
	 *
	 * @return	void
	 */
	function printContent()	{
		$this->content.=$this->doc->endPage();
		echo $this->content;
	}

	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				if ($this->confArr['useStoragePid']) {
					$catRows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid','tt_news_cat','pid='.$this->id.' AND deleted=0');
					if (empty($catRows)) {
						$content = $this->getNothingFoundMsg();
					}
				}
				if (!$content) {
					$content = $this->renderButtons();
					$this->initTreeObj();
					$content .= '<div id="ttnews-cat-tree">'.$this->treeObj->getBrowsableTree().'</div>';
				}
				$this->content .= $this->doc->section('tt_news category manager:',$content,0,1);
			break;
//			case 2:
//
//				
//
//			break;



		}
	}
	
	function renderButtons() {
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







}






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
			$params='&edit[tt_news_cat]['.$v['uid'].']=edit';
			$aOnClick = htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl));

			$out = '<a href="#" onclick="'.$aOnClick.'" title="'.$hrefTitle.'">'.$title.'</a>';
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
		global $TCA, $LANG, $SOBE;

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