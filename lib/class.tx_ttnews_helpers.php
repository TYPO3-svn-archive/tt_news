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
 * tt_news helper functions
 *
 * $Id: class.tx_ttnews_div.php 8958 2008-04-20 14:11:42Z rupertgermann $
 *
 * @author	Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
class tx_ttnews_helpers {

	var $pObj;

	function tx_ttnews_helpers(&$pObj) {
		$this->pObj = &$pObj;
	}



	/**
	 * checks for each field of a list of items if it exists in the tt_news table ($this->fieldNames) and returns the validated fields
	 *
	 * @param	string		$fieldlist: a list of fields to ckeck
	 * @return	string		the list of validated fields
	 */
	function validateFields($fieldlist,$existingFields) {
		$checkedFields = array();
		$fArr = t3lib_div::trimExplode(',',$fieldlist,1);
		foreach ($fArr as $fN) {
			if (in_array($fN,$existingFields)) {
				$checkedFields[] = $fN;
			}
		}
		$checkedFieldlist = implode($checkedFields,',');
		return $checkedFieldlist;
	}



	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$caller: ...
	 * @param	[type]		$getGlobalTime: ...
	 * @return	[type]		...
	 */
	function getParsetime($caller='',$getGlobalTime=false) {
		$currentTime = time() + microtime();
		$call_info = array_shift( debug_backtrace() );
		$code_line = $call_info['line'];
		$file = array_pop( explode('/', $call_info['file']));
		$lbl = $caller;
		$msg = array();
		if ($this->pObj->start_time === NULL)	{
			$lbl = 'START: '.basename($file);
			$msg['INITIALIZE'] = $caller;
			$this->pObj->start_time = $currentTime;
			$this->pObj->global_start_time = $currentTime;
			$this->pObj->start_time = $currentTime;

			$msg['file:'] = $file;
			$msg['start_code_line:'] = $this->pObj->start_code_line;
			$msg['mem:'] = ceil( memory_get_usage()/1024).'  KB';
 			$this->writelog($msg, $lbl, $code_line,0);

			return ;
		}

		if ($getGlobalTime) {
			$time = round(($currentTime - $this->pObj->global_start_time),3);
			$lbl = 'RESULTS: '.$this->pObj->theCode;
			$msg['pid_list'] = $this->pObj->pid_list;
		} else {
			$time = round(($currentTime - $this->pObj->start_time),3);
		}

		$msg['time:'] = $time;
		$msg['caller:'] = $caller;
		$msg['code-lines:'] = $this->pObj->start_code_line.'-'.$code_line;
		$msg['mem:'] = ceil( memory_get_usage()/1024).'  KB';

		$this->pObj->start_time = $currentTime;
		$this->pObj->start_code_line = $code_line;

		if ($time > $this->pObj->parsetimeThreshold || $getGlobalTime) {
 			$this->writelog($msg, $lbl, $code_line, $getGlobalTime);
		}
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$msg: ...
	 * @param	[type]		$lbl: ...
	 * @param	[type]		$code_line: ...
	 * @param	[type]		$sev: ...
	 * @return	[type]		...
	 */
	function writelog($msg, $lbl, $code_line, $sev) {
		if ($this->pObj->useDevlog) {
			$time = $msg['time:'];
			if ($time > 0.5) {
				$sev = 2;
				if ($time > 1) {
					$sev = 3;
				}
			}
			t3lib_div::devLog($lbl.($time?' time: '.$time.' s':''), $this->pObj->extKey, (int)$sev, $msg);
		} else {
			debug($msg, $lbl, $code_line, $msg['file:'], 3);
		}
	}


	/**
	 * returns an error message if some important settings are missing (template file, singlePid, pidList, code)
	 *
	 * @return	string		the error message
	 */
	function displayErrors() {
		if (count($this->pObj->errors) >= 2) {
			$msg = '--> Did you include the static TypoScript template (\'News settings\') for tt_news?';
		}
		return '<div style="border:2px solid red; padding:10px; margin:10px;"><img src="typo3/gfx/icon_warning2.gif" />
				<strong>plugin.tt_news ERROR:</strong><br />'.implode('<br /> ',$this->pObj->errors).'<br />'.$msg.'</div>';
	}



	/**
	 * cleans the content for rss feeds. removes '&nbsp;' and '?;' (dont't know if the scond one matters in real-life).
	 * The rest of the cleaning/character-conversion is done by the stdWrap functions htmlspecialchars,stripHtml and csconv.
	 * For details see http://typo3.org/documentation/document-library/doc_core_tsref/stdWrap/
	 *
	 * @param	string		$str: input string to clean
	 * @return	string		the cleaned string
	 */
	function cleanXML($str) {
		$cleanedStr = preg_replace(
			array('/&nbsp;/', '/&;/', '/</', '/>/'),
			array(' ', '&amp;;', '&lt;', '&gt;'),
			$str);
		return $cleanedStr;
	}


	/**
	 * Obtains current extension version (for use with compatVersion)
	 *
	 * @return	string		Extension version (for example, '2.5.1')
	 */
	function getCurrentVersion() {
		$_EXTKEY = $this->pObj->extKey;
		// require_once fails if the plugin is executed multiple times
		require(t3lib_extMgm::extPath($_EXTKEY, 'ext_emconf.php'));
		return $EM_CONF[$_EXTKEY]['version'];
	}

	/**
	 * Generates the date format needed for Atom feeds
	 * see: http://www.w3.org/TR/NOTE-datetime (same as ISO 8601)
	 * in php5 it would be so easy: date('c', $row['datetime']);
	 *
	 * @param	integer		the datetime value to be converted to w3c format
	 * @return	string		datetime in w3c format
	 */
	function getW3cDate($datetime) {
		$offset = date('Z', $datetime) / 3600;
		if($offset < 0) {
			$offset *= -1;
			if($offset < 10) {
				$offset = '0'.$offset;
			}
			$offset = '-'.$offset;
		} elseif ($offset == 0) {
			$offset = '+00';
		} elseif ($offset < 10) {
			$offset = '+0'.$offset;
		} else {
			$offset = '+'.$offset;
		}
		return strftime('%Y-%m-%dT%H:%M:%S', $datetime).$offset.':00';
 	}



}

?>