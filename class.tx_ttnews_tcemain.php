<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Rupert Germann (rupi@gmx.li)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
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
 * Class 'tx_ttnews_tcemain' for the tt_news extension.
 *
 * $Id:
 *
 * @author     Rupert Germann <rupi@gmx.li>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   53: class tx_ttnews_tcemain
 *   69:     function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$pObj)
 *
 * TOTAL FUNCTIONS: 1
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


/**
 * Class being included by TCEmain using a hook
 *
 * @author	Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
class tx_ttnews_tcemain {
	function processDatamap_preProcessIncomingFieldArray() {
		// this function seems to needed for compatibility with TYPO3 3.7.0. In this version tcemain ckecks the existence of the method "processDatamap_preProcessIncomingFieldArray()" and calls "processDatamap_preProcessFieldArray()"
	}
	/**
	 * This method is called by a hook in the TYPO3 Core Engine (TCEmain). We use it to check if a element reference
	 * has changed and update the table tx_templavoila_elementreferences accordingly
	 *
	 * @param	string		$status: The TCEmain operation status, fx. 'update'
	 * @param	string		$table: The table TCEmain is currently processing
	 * @param	string		$id: The records id (if any)
	 * @param	array		$fieldArray: The field names and their values to be processed
	 * @param	object		$reference: Reference to the parent object (TCEmain)
	 * @return	void
	 * @access public
	 */
	function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$pObj) {
		if ($table == 'tt_news') {
			if ($GLOBALS['BE_USER']->getTSConfigVal('options.useListOfAllowedItems') && !$GLOBALS['BE_USER']->isAdmin()) {
				if (!$fieldArray['category']) { // either the record has no category or all assigned categories have been deleted at the same time

					$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query ('tt_news_cat.uid,tt_news_cat_mm.sorting AS mmsorting', 'tt_news', 'tt_news_cat_mm', 'tt_news_cat', ' AND tt_news_cat_mm.uid_local='.(is_int($id)?$id:0).t3lib_BEfunc::BEenableFields('tt_news_cat'));

					$categories = array();
					while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
						$categories[] = $row['uid'];
					}
					if (!$categories[0]) { // original record has no categories
						$notAllowedItems = array();
					} else {
						$notAllowedItems[]='empty';
					}
				} else {
					$allowedItemsList=$GLOBALS['BE_USER']->getTSConfigVal('tt_newsPerms.tt_news_cat.allowedItems');
					$catArr = t3lib_div::trimExplode(',',$fieldArray['category'],1);
					$notAllowedItems = array();
					foreach ($catArr as $k) {
						if(!t3lib_div::inList($allowedItemsList,$k)) {
							$notAllowedItems[]=$k;
						}
					}
				}
				if ($notAllowedItems[0]) {
					$pObj->log($table,$id,2,0,1,"Attempt to modify a record from table '%s' without permission. Reason: the record has one or more categories assigned that are not defined in your BE usergroup (tablename.allowedItems).",1,array($table));
					$fieldArray = array();

				}
			}
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.tx_ttnews_tcemain.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.tx_ttnews_tcemain.php']);
}

?>