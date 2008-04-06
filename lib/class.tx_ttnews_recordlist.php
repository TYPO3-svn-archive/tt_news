<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2005-2008 Rupert Germann <rupi@gmx.li>
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * generates the list view for the 'news admin' module
 *
 * $Id$
 *
 * @author	Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   72: class tx_ttnews_recordlist extends tx_cms_layout
 *
 *              SECTION: Generic listing of items
 *   92:     function makeOrdinaryList($table, $id, $fList, $icon=0, $addWhere='')
 *  195:     function getIcon($table,$row,$noEdit)
 *  219:     function checkRecordPerms(&$row,$checkCategories)
 *  265:     function noEditIcon($reason)
 *  291:     function headerFields($fieldArr,$table,$out=array())
 *  314:     function addSortLink($code,$field,$table)
 *  342:     function listURL($altId='',$table=-1,$exclList='')
 *  367:     function makeQueryArray($table, $id, $addWhere="",$fieldList='')
 *  448:     function ckeckDisallowedCategories($queryParts)
 *  485:     function getCategories($uid)
 *
 * TOTAL FUNCTIONS: 10
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

require_once(PATH_t3lib.'class.t3lib_recordlist.php');
require_once(PATH_typo3.'class.db_list.inc');


require_once(t3lib_extMgm::extPath('cms').'layout/class.tx_cms_layout.php');


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
				if ($this->category) {
					$addP = '&defVals['.$table.'][category]='.$this->category;
					$addLbl = 'InCategory';
				}
				$params = '&edit['.$table.']['.$this->newRecPid.']=new'.$addP;
				$onclick = htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl));
				$theData['__cmds__'] = '<a href="#" onclick="'.$onclick.'">'.
					'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/new_el.gif').' title="'.$GLOBALS['LANG']->getLL('createArticle'.$addLbl,1).'" alt="" />'.
					'</a>';
			}
			$out.= $this->addelement(1,'',$theData,' class="c-headLine"',15);

			$checkCategories = false;
			if (count($this->includeCats) || count($this->excludeCats)) {
				$checkCategories = true;
			}


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
						$noEdit = $this->checkRecordPerms($row,$checkCategories);

							// Setting icons/edit links:
						if ($icon)	{
							$Nrow['__cmds__']= $this->getIcon($table,$row,$noEdit);
						}

						if (!$noEdit)	{
							$Nrow['__cmds__'].= '<a href="#" onclick="'.htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl)).'">'.
											'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/edit2.gif','width="11" height="12"').' title="'.$GLOBALS['LANG']->getLL('edit',1).'" alt="" />'.
											'</a>';
						} else {
							$Nrow['__cmds__'].= $this->noEditIcon($noEdit);
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
	 * Creates the icon image tag for record from table and wraps it in a link which will trigger the click menu.
	 *
	 * @param	string		Table name
	 * @param	array		Record array
	 * @param	string		Record title (NOT USED)
	 * @return	string		HTML for the icon
	 */
	function getIcon($table,$row,$noEdit)	{

			// Initialization
		$alttext = t3lib_BEfunc::getRecordIconAltText($row,$table);
		$iconImg = t3lib_iconWorks::getIconImage($table,$row,$this->backPath,'title="'.$alttext.'"');
		$this->counter++;


		if ($noEdit) {
			$disableList = '+info,copy';
		}
			// The icon with link
		$theIcon = $GLOBALS['SOBE']->doc->wrapClickMenuOnIcon($iconImg,$table,$row['uid'],'','',$disableList);

		return $theIcon;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$$row: ...
	 * @param	[type]		$checkCategories: ...
	 * @return	[type]		...
	 */
	function checkRecordPerms(&$row,$checkCategories)	{
		$noEdit = 1;
		if ($row['pid'] == $this->newRecPid) {
			$pageCalcPerms = $this->ext_CALC_PERMS;
		} else {
			// TODO: cache this
			$PI = t3lib_BEfunc::readPageAccess($row['pid'],$this->perms_clause);
			$pageCalcPerms = $GLOBALS['BE_USER']->calcPerms($PI);
		}

		if (($pageCalcPerms&16)) { // user is allowed to edit page content
			if ($checkCategories) {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery (
					'tt_news_cat_mm.*',
					'tt_news_cat_mm',
					'tt_news_cat_mm.uid_local='.$row['uid']);
				$noEdit = 2;
				$error = false;
				while (($mmrow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
					if (!in_array($mmrow['uid_foreign'],$this->includeCats) || in_array($mmrow['uid_foreign'],$this->excludeCats)) {
						$error = true;
						break;
					}
				}
				$GLOBALS['TYPO3_DB']->sql_free_result($res);
				if (!$error) {
					$noEdit = 0;
				}

			} else {
				$noEdit = 0;
			}

		}


		return $noEdit;
	}

	/**
	 * Returns icon for "no-edit" of a record.
	 * Basically, the point is to signal that this record could have had an edit link if the circumstances were right. A placeholder for the regular edit icon...
	 *
	 * @param	string		Label key from LOCAL_LANG
	 * @return	string		IMG tag for icon.
	 */
	function noEditIcon($reason)	{
		switch ($reason) {
			case 1:
				$label = $GLOBALS['LANG']->getLL('noEditPagePerms',1);
			break;

			case 2:
				$label = $GLOBALS['LANG']->getLL('noEditCategories',1);
			break;
		}
		$img = t3lib_extMgm::extRelPath('tt_news').'res/noedit_'.$reason.'.gif';
		$icon = '<img'.t3lib_iconWorks::skinImg($this->backPath,$img).' title="'.$label.'" alt="" />';

		return $icon;
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
		$sortUrl = $this->listURL('',FALSE,'sortField,sortRev').'&sortField='.$field.'&sortRev='.($this->sortRev || ($this->sortField!=$field)?0:1);
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
	function listURL($altId='',$table='',$exclList='')	{
		return $this->script.
			'?id='.(strcmp($altId,'')?$altId:$this->id).
//			($table!==FALSE?'&table='.rawurlencode($table==-1?$this->table:$table):'').
//			($this->thumbs?'&imagemode='.$this->thumbs:'').
//			($this->returnUrl?'&returnUrl='.rawurlencode($this->returnUrl):'').
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
			$fieldList = 'DISTINCT('.$table.'.uid), '.$fieldList;
			$leftjoin = ' LEFT JOIN '.$mmTable.' AS mm1 ON '.$table.'.uid=mm1.uid_local';
		}

		if ($this->selectedCategories) {
			$catWhere .= ' AND mm1.uid_foreign IN ('.$this->selectedCategories.')';
		} elseif ($this->lTSprop['noListWithoutCatSelection'] && !$this->isAdmin) {
			$addWhere .= ' AND 1=0';
		}
		if ($this->isAdmin) {
			$this->pidSelect = '1=1';
		} else {
			if ($this->showOnlyEditable) {
				$this->pidSelect = $table.'.pid IN ('.$this->editablePagesList.')';
			} else {
				$this->pidSelect = $table.'.pid IN ('.$this->pidList.')';;
			}
		}

		$addWhere .= ' AND '.$table.'.sys_language_uid='.$this->current_sys_language;
		

		// Compiling query array:
		$queryParts = array(
			'SELECT' => $fieldList,
			'FROM' => $table.$leftjoin,
			'WHERE' => $this->pidSelect.
						t3lib_BEfunc::deleteClause($table).
						t3lib_BEfunc::versioningPlaceholderClause($table).
						' '.$addWhere.
						' '.$search.$catWhere,
			'GROUPBY' => '',//$table.'.uid',
			'ORDERBY' => $GLOBALS['TYPO3_DB']->stripOrderBy($orderBy),
			'LIMIT' => $limit
		);



		if (!$this->isAdmin && $this->selectedCategories && $this->showOnlyEditable) {
			$queryParts = $this->ckeckDisallowedCategories($queryParts);
		}






			// Return query:
		return $queryParts;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$queryParts: ...
	 * @return	[type]		...
	 */
	function ckeckDisallowedCategories($queryParts) {
		// if showOnlyEditable is set, we check for each found record if it has any disallowed category assigned
		$tmpLimit = $queryParts['LIMIT'];
		unset($queryParts['LIMIT']);
		$res = $GLOBALS['TYPO3_DB']->exec_SELECT_queryArray($queryParts);
		$results = array();
		while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
			$results[$row['uid']] = $row['uid'];
		}
		array_unique($results);
		foreach ($results as $uid) {
			$currentCats = $this->getCategories($uid);
			foreach ($currentCats as $cat) {
				if (!in_array($cat,$this->includeCats) || in_array($cat,$this->excludeCats)) {
					unset($results[$uid]);
					break; // break after one disallowed category was found
				}
			}
		}

		$matchlist = implode(',',$results);
		if ($matchlist) {
			$queryParts['WHERE'] .= ' AND tt_news.uid IN ('.$matchlist.')';
		} else {
			$queryParts['WHERE'] .= ' AND tt_news.uid IN (0)';
		}

		$queryParts['LIMIT'] = $tmpLimit;
		return $queryParts;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$uid: ...
	 * @return	[type]		...
	 */
	function getCategories($uid) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					'tt_news_cat.uid',
					'tt_news_cat LEFT JOIN tt_news_cat_mm AS mm ON tt_news_cat.uid=mm.uid_foreign',
					'tt_news_cat.deleted=0 AND mm.uid_local='.$uid);

		$categories = array();
		while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
			$categories[] = $row['uid'];
		}
		return $categories;
	}





}









if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_recordlist.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/lib/class.tx_ttnews_recordlist.php']);
}
?>