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
			$this->fieldArray = explode(',',$fList);

				// Header line is drawn
			$theData = array();
			$theData = $this->headerFields($this->fieldArray,$table,$theData);
			if ($this->doEdit)	{
				$newRecIcon = $this->getNewRecordButton($table);
			}
			
			$out.= $this->addelement(1,$newRecIcon,$theData,' class="c-headLineTable"');

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
						$Nrow = array();
						$NrowIcon = '';
						$noEdit = $this->checkRecordPerms($row,$checkCategories);

							// Setting icons/edit links:
						if ($icon)	{
							$NrowIcon = $this->getIcon($table,$row,$noEdit);
						}

						if (!$noEdit)	{
							$params = '&edit['.$table.']['.$row['uid'].']=edit';
							$NrowIcon .= '<a href="#" onclick="'.htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl)).'">'.
											'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/edit2.gif','width="11" height="12"').' title="'.$GLOBALS['LANG']->getLL('edit',1).'" alt="" />'.
											'</a>';
						} else {
							$NrowIcon .= $this->noEditIcon($noEdit);
						}

							// Get values:
						$Nrow = $this->dataFields($this->fieldArray,$table,$row,$Nrow,$noEdit);
						$tdparams = $this->eCounter%2 ? ' class="bgColor4"' : ' class="bgColor4-20"';
						$out.= $this->addelement(1,$NrowIcon,$Nrow,$tdparams);
					}
					$this->eCounter++;
				}
			}

				// Wrap it all in a table:
			$out='
				<table border="0" cellpadding="1" cellspacing="1" class="typo3-dblist">
					'.$out.'
				</table>';
		}
		return $out;
	}
	
	
	/**
	 * Adds content to all data fields in $out array
	 *
	 * @param	array		Array of fields to display. Each field name has a special feature which is that the field name can be specified as more field names. Eg. "field1,field2;field3". Field 2 and 3 will be shown in the same cell of the table separated by <br /> while field1 will have its own cell.
	 * @param	string		Table name
	 * @param	array		Record array
	 * @param	array		Array to which the data is added
	 * @return	array		$out array returned after processing.
	 * @see makeOrdinaryList()
	 */
	function dataFields($fieldArr,$table,$row,$out=array(),$noEdit=FALSE)	{
		global $TCA;

			// Check table validity:
		if ($TCA[$table])	{
			t3lib_div::loadTCA($table);
			$thumbsCol = $TCA[$table]['ctrl']['thumbnail'];
			$url = t3lib_div::getIndpEnv('TYPO3_SITE_URL').'index.php';
			$thumbsize = $this->lTSprop['imageSize'];
				// Traverse fields:
			foreach($fieldArr as $fieldName)	{

				if ($TCA[$table]['columns'][$fieldName])	{	// Each field has its own cell (if configured in TCA)
					if ($fieldName==$thumbsCol)	{	// If the column is a thumbnail column:
						if ($this->thumbs) {
							$val = t3lib_BEfunc::thumbCode($row,$table,$fieldName,$this->backPath,$this->thumbScript,NULL,0,'',$thumbsize);
						} else {
							$val = str_replace(',',', ',basename($row[$fieldName]));
						}
						
						
					} else {	// ... otherwise just render the output:
						$val = nl2br(htmlspecialchars(trim(t3lib_div::fixed_lgd_cs(t3lib_BEfunc::getProcessedValue($table,$fieldName,$row[$fieldName],0,0,0,$row['uid']),250))));
						
						if ($this->lTSprop['clickTitleMode'] == 'view') {
							if ($this->singlePid) {
								$val = $this->linkSingleView($url,$val,$row['uid']);
							}
						} elseif ($this->lTSprop['clickTitleMode'] == 'edit') {
							if (!$noEdit)	{
								$params = '&edit['.$table.']['.$row['uid'].']=edit';
								$lTitle = ' title="'.$GLOBALS['LANG']->getLL('edit',1).'"';
								$val = '<a href="#" onclick="'.htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl)).'"'.$lTitle.'>'.$val.'</a>';	
							}	
						}
						

					}
					$out[$fieldName] = $val;				
				} else {	// Each field is separated by <br /> and shown in the same cell (If not a TCA field, then explode the field name with ";" and check each value there as a TCA configured field)
					$theFields = explode(';',$fieldName);

						// Traverse fields, separated by ";" (displayed in a single cell).
					foreach($theFields as $fName2)	{
						if ($TCA[$table]['columns'][$fName2])	{
							 $out[$fieldName].= '<b>'.$GLOBALS['LANG']->sL($TCA[$table]['columns'][$fName2]['label'],1).'</b>'.
							 					'&nbsp;&nbsp;'.
												htmlspecialchars(t3lib_div::fixed_lgd_cs(t3lib_BEfunc::getProcessedValue($table,$fName2,$row[$fName2],0,0,0,$row['uid']),25)).
												'<br />';
						}
					}
				}
					// If no value, add a nbsp.
				if (!$out[$fieldName])	$out[$fieldName]='&nbsp;';

					// Wrap in dimmed-span tags if record is "disabled"
				if ($this->isDisabled($table,$row))	{
					$out[$fieldName] = $GLOBALS['TBE_TEMPLATE']->dfw($out[$fieldName]);
				}
			}
		}
		return $out;
	}
	
	
	function linkSingleView($url, $val, $uid) {
		$params = array(
				'id' => $this->singlePid, 
				'tx_ttnews[tt_news]' => $uid,
				'no_cache' => 1);
		$linkedurl = t3lib_div::linkThisUrl($url,$params);
		$onclick = 'openFePreview(\''.htmlspecialchars($linkedurl).'\');';
		$lTitle = $GLOBALS['LANG']->getLL('openFePreview',1);
		$link = '<a href="#" onclick="'.$onclick.'" title="'.$lTitle.'">'.$val.'</a>';
		return $link;
	}
	
	
	
	function getNewRecordButton($table, $withLabel=false) {
		if ($this->category) {
			$addP = '&defVals['.$table.'][category]='.$this->category;
			$addLbl = 'InCategory';
		}
		$params = '&edit['.$table.']['.$this->newRecPid.']=new'.$addP;
		$onclick = htmlspecialchars(t3lib_BEfunc::editOnClick($params,$this->backPath,$this->returnUrl));
		$button = '<a href="#" onclick="'.$onclick.'">'.
			'<img'.t3lib_iconWorks::skinImg($this->backPath,'gfx/new_el.gif').' title="'.$GLOBALS['LANG']->getLL('createArticle'.$addLbl,1).'" alt="" /> '.
			($withLabel?$GLOBALS['LANG']->getLL('createArticle'.$addLbl):'').
			'</a>';
		return $button;
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
		if ($this->pObj->checkPageAccess($row['pid'])) { // user is allowed to edit page content
			$noEdit = 0;
			if ($checkCategories) {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery (
					'tt_news_cat_mm.*',
					'tt_news_cat_mm, tt_news_cat',
					'tt_news_cat_mm.uid_foreign=tt_news_cat.uid AND tt_news_cat.deleted=0 AND tt_news_cat_mm.uid_local='.$row['uid']);
				
				while (($mmrow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
					if (!in_array($mmrow['uid_foreign'],$this->includeCats) || in_array($mmrow['uid_foreign'],$this->excludeCats)) {
						$noEdit = 2;
						break;
					}
				}
				$GLOBALS['TYPO3_DB']->sql_free_result($res);
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
			($this->thumbs?'&showThumbs='.$this->thumbs:'').
//			($this->returnUrl?'&returnUrl='.rawurlencode($this->returnUrl):'').
			($this->searchString?'&search_field='.rawurlencode($this->searchString):'').
			($this->searchLevels?'&searchLevels='.rawurlencode($this->searchLevels):'').
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
		
		if ($this->searchLevels == -1) {
			$this->pidSelect = '';
		}
		$ps = ($this->pidSelect?$this->pidSelect.' AND ':'');
		if ($this->isAdmin) {
			$this->pidSelect = $ps.'1=1';
		} else {
			if ($this->showOnlyEditable) {
				$this->pidSelect = $ps.$table.'.pid IN ('.$this->editablePagesList.')';
			} else {
				$this->pidSelect = $ps.$table.'.pid IN ('.$this->pidList.')';
			}
		}
		$addWhere .= ' AND '.$table.'.sys_language_uid='.$this->current_sys_language;

		// Compiling query array:
		$queryParts = array(
			'SELECT' => $fieldList,
			'FROM' => $table.$leftjoin,
			'WHERE' => $this->pidSelect.' AND '.$table.'.pid > 0'.
						t3lib_BEfunc::deleteClause($table).
						t3lib_BEfunc::versioningPlaceholderClause($table).
						' '.$addWhere.
						' '.$search.$catWhere,
			'GROUPBY' => '',//$table.'.uid',
			'ORDERBY' => $GLOBALS['TYPO3_DB']->stripOrderBy($orderBy),
			'LIMIT' => $limit
		);

		if (!$this->isAdmin && ($this->selectedCategories || !$this->lTSprop['noListWithoutCatSelection']) && $this->showOnlyEditable) {
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
		if (count($this->excludeCats) || count($this->includeCats)) {
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
		}
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