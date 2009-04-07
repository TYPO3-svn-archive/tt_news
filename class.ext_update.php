<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2004-2009 Rupert Germann <rupi@gmx.li>
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
 * New for tt_news 3.0.0
 * Class for updating tt_news content elements and static template file relations.
 *
 * $Id$
 *
 * @author  Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
class ext_update {

	var $tstemplates;


	/**
	 * Main function, returning the HTML content of the module
	 *
	 * @return	string		HTML
	 */
	function main() {
		$out = '';

		// analyze
		$this->tstemplates = $this->getTsTemplates();
		$ts_count = count($this->tstemplates);

		$this->contentElements = $this->getContentElements();
		$ce_count = count($this->contentElements);

		if (t3lib_div::_GP('do_update')) {
			$out .= '<a href="' . t3lib_div::linkThisScript(array('do_update' => '', 'func' => '')) . '">[<- back]</a><br>';

			$func = t3lib_div::_GP('func');
			if (method_exists($this, $func)) {
				$out .= $this->$func();
			} else {
				$out .= 'ERROR: ' . $func . '() not found';
			}
		} else {
			if ($ce_count || $ts_count) {
				$out .= '<table class="warningbox" border="0" cellpadding="0" cellspacing="0">
					<tr><td>
						<img ' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/icon_warning2.gif', 'width="14" height="14"') . '>
						<span class="warningboxheader">Important Notice!</span>

						<p style="font-weight:normal;">
						The updater manipulates your database and due to the huge amount of configuration variants it is possible that it <br>
						might not produce the expexted results.<br>
						So backup your database (at least the tables sys_template and tt_content) or do a t3d export of your site <strong>BEFORE</strong> <br>
						you click on any of the "DO_IT" Buttons.
						</p>



						</td>
					</tr>
				</table>
				<br>
				';

				if ($ce_count) {
					$ceout = 'There have been found ' . $ce_count . ' content elements with a configured html template (EXT:tt_news/pi/tt_news_v2_template.html) which
						doesn\'t exist in this tt_news version.
						<br>Should the updater clean this settings?<br>';

					$ceout .= $this->getButton('clearWrongTemplateInCE');
					$out .= $this->wrapForm($ceout, 'Search for non existing html templates');
					$out .= '<br><br>';
				}
				if ($ts_count) {
					$tsout = 'There have been found ';
					$tsout .= $ts_count . ' TypoScript templates which include one of the tt_news static templates but with an outdated path.
						<br>Should the updater update these records?<br>';

					$tsout .= $this->getButton('updateStaticTemplateFiles');
					$out .= $this->wrapForm($tsout, 'Search for old static TS templates');
					$out .= '<br><br>';
				}

			} else {
				$out .= 'Check for content elements with a configured html template (EXT:tt_news/pi/tt_news_v2_template.html) which
						doesn\'t exist in this tt_news version: 0<br>
						Check for TypoScript templates which include one of the tt_news static templates but with an outdated path: 0<br><br>
						Nothing to do.
				<br><br>';
			}

		}
		return $out;
	}


	function clearWrongTemplateInCE() {
		$msg = array();
		foreach ($this->contentElements as $id => $ce) {
			$ff = $ce['ff'];

			$s = array('EXT:tt_news/pi/tt_news_v2_template.html');
			$r = array('');
			$newff = str_replace($s, $r, $ff);

			$table = 'tt_content';

			$where = 'uid=' . $id;
			$fields_values = array('pi_flexform' => $newff);
			if ($GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values)) {
				$msg[] = 'Updated contentElement "' . $ce['title'] . '" uid: ' . $id . ', page: ' . $ce['pid'];
			}
		}
		return implode('<br>', $msg);

	}


	function updateStaticTemplateFiles() {
		$msg = array();
		foreach ($this->tstemplates as $ts) {
			$oldincFile = $ts['include_static_file'];

			$s = array('EXT:tt_news/static/ts_old', 'EXT:tt_news/static/ts_new', 'EXT:tt_news/static/rss_feed', 'EXT:tt_news/static/css');
			$r = array('EXT:tt_news/pi/static/ts_old', 'EXT:tt_news/pi/static/ts_new', 'EXT:tt_news/pi/static/rss_feed',
					'EXT:tt_news/pi/static/css');
			$newincfile = str_replace($s, $r, $oldincFile);

			$table = 'sys_template';

			$where = 'uid=' . $ts['uid'];
			$fields_values = array('include_static_file' => $newincfile);
			if ($GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values)) {
				$msg[] = 'Updated template "' . $ts['title'] . '" uid: ' . $ts['uid'] . ', page: ' . $ts['pid'];
			}
		}
		return implode('<br>', $msg);
	}


	function wrapForm($content, $fsLabel) {
		$out = '<form action="">
			<fieldset>
			<legend>' . $fsLabel . '</legend>
			' . $content . '

			</fieldset>
			</form>';
		return $out;
	}


	function getButton($func, $lbl = 'DO IT') {

		$params = array('do_update' => 1, 'func' => $func);

		$onClick = "document.location='" . t3lib_div::linkThisScript($params) . "'; return false;";
		$button = '<input type="submit" value="' . $lbl . '" onclick="' . htmlspecialchars($onClick) . '">';

		return $button;
	}


	function getTsTemplates() {
		$select_fields = '*';
		$from_table = 'sys_template';
		$where_clause = 'deleted=0 AND include_static_file LIKE \'%EXT:tt_news/static/%\'';

		$groupBy = '';
		$orderBy = '';
		$limit = '';

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);

		$resultRows = array();
		while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
			$resultRows[] = $row;
		}

		return $resultRows;
	}


	function getContentElements() {
		$select_fields = '*';
		$from_table = 'tt_content';
		$where_clause = 'CType="list" AND list_type="9" AND deleted=0';

		$where_clause .= ' AND pi_flexform LIKE \'%EXT:tt_news/pi/tt_news_v2_template.html%\'';

		$groupBy = '';
		$orderBy = '';
		$limit = '';

		$res_flex = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);

		if ($res_flex) {
			$resultRows = array();
			while (($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res_flex))) {
				$resultRows[$row['uid']] = array('ff' => $row['pi_flexform'], 'title' => $row['title'], 'pid' => $row['pid']);
			}
		}
		return $resultRows;
	}


	/**
	 * Checks how many rows are found and returns true if there are any
	 * (this function is called from the extension manager)
	 *
	 * @param	string		$what: what should be updated
	 * @return	boolean
	 */
	function access($what = 'all') {

		return TRUE;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ext_update.php']) {
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ext_update.php']);
}
?>