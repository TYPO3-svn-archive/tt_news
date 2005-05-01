<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2005 Kasper Skaarhoj (kasperYYYY@typo3.com)
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
 * Wizard to add new records to a group/select TCEform formfield
 *
 * $Id$
 * Revised for TYPO3 3.6 November/2003 by Kasper Skaarhoj
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   75: class SC_wizard_add
 *  104:     function init()
 *  157:     function main()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


/**
 * Script Class for adding new items to a group/select field. Performs proper redirection as needed.
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @package TYPO3
 * @subpackage core
 */
class ux_SC_wizard_add extends SC_wizard_add {

		// Internal, dynamic:
	var $content;				// Content accumulation for the module.
	var $include_once=array();	// List of files to include.

	var $processDataFlag=0;		// If set, the TCEmain class is loaded and used to add the returning ID to the parent record.

		// Internal, static:
	var $pid;					// Create new record -pid (pos/neg). If blank, return immediately
	var $table;					// The parent table we are working on.
	var $id;					// Loaded with the created id of a record when TCEforms (alt_doc.php) returns ...

		// Internal, static: GPvars
	var $P;						// Wizard parameters, coming from TCEforms linking to the wizard.
	var $returnEditConf;		// Information coming back from alt_doc.php script, telling what the table/id was of the newly created record.








	/**
	 * Initialization of the class.
	 *
	 * @return	void
	 */
	function init()	{

			// Init GPvars:
		$this->P = t3lib_div::_GP('P');
		$this->returnEditConf = t3lib_div::_GP('returnEditConf');

			// Get this record
		$origRow = t3lib_BEfunc::getRecord($this->P['table'],$this->P['uid']);

			// Set table:
		$this->table = $this->P['params']['table'];

			// Get TSconfig for it.
		$TSconfig = t3lib_BEfunc::getTCEFORM_TSconfig($this->table,is_array($origRow)?$origRow:array('pid'=>$this->P['pid']));

			// Set [params][pid]
		if (substr($this->P['params']['pid'],0,3)=='###' && substr($this->P['params']['pid'],-3)=='###')	{
			$this->pid = intval($TSconfig['_'.substr($this->P['params']['pid'],3,-3)]);
		} else $this->pid = intval($this->P['params']['pid']);

			// Return if new record as parent (not possibly/allowed)
		if (!strcmp($this->pid,''))	{
			header('Location: '.t3lib_div::locationHeaderUrl($this->P['returnUrl']));
			exit;
		}

			// Else proceed:
		if ($this->returnEditConf)	{	// If a new id has returned from a newly created record...
			$eC = unserialize($this->returnEditConf);
			if (is_array($eC[$this->table]) && t3lib_div::testInt($this->P['uid']))	{

					// Getting id and cmd from returning editConf array.
				reset($eC[$this->table]);
				$this->id = intval(key($eC[$this->table]));
				$cmd = current($eC[$this->table]);

					// ... and if everything seems OK we will register some classes for inclusion and instruct the object to perform processing later.
				if ($this->P['params']['setValue'] && $cmd=='edit' && $this->id && $this->P['table'] && $this->P['field'] && $this->P['uid'])	{
					$this->include_once[]=PATH_t3lib.'class.t3lib_loaddbgroup.php';
					$this->include_once[]=PATH_t3lib.'class.t3lib_transferdata.php';
					$this->include_once[]=PATH_t3lib.'class.t3lib_tcemain.php';
					$this->processDataFlag=1;
				}
			}
		}
	}

	/**
	 * Main function
	 * Will issue a location-header, redirecting either BACK or to a new alt_doc.php instance...
	 *
	 * @return	void
	 */
	function main()	{

		if ($this->returnEditConf)	{
			if ($this->processDataFlag)	{
					// Preparing the data of the parent record...:
				$trData = t3lib_div::makeInstance('t3lib_transferData');
				$trData->fetchRecord($this->P['table'],$this->P['uid'],'');	// 'new'
				reset($trData->regTableItems_data);
				$current = current($trData->regTableItems_data);

					// If that record was found (should absolutely be...), then init TCEmain and set, prepend or append the record
				if (is_array($current))	{
					$tce = t3lib_div::makeInstance('t3lib_TCEmain');
					$tce->stripslashes_values=0;
					$data=array();
					$addEl = $this->table.'_'.$this->id;
					switch((string)$this->P['params']['setValue'])	{
						case 'set':
							$data[$this->P['table']][$this->P['uid']][$this->P['field']] = $addEl;
						break;
						case 'prepend':
							$data[$this->P['table']][$this->P['uid']][$this->P['field']] = $current[$this->P['field']].','.$addEl;
						break;
						case 'append':
							$data[$this->P['table']][$this->P['uid']][$this->P['field']] = $addEl.','.$current[$this->P['field']];
						break;
					}

						// Setting the new field data:
					$data[$this->P['table']][$this->P['uid']][$this->P['field']] = implode(',',t3lib_div::trimExplode(',',$data[$this->P['table']][$this->P['uid']][$this->P['field']],1));

						// Submit the data:
					$tce->start($data,array());
					$tce->process_datamap();
				}
			}

				// Return to the parent alt_doc.php record editing session:
			header('Location: '.t3lib_div::locationHeaderUrl($this->P['returnUrl']));
		} else {
			$defVals = '';
			// get dafault values for new records
			if (is_array($this->P['params']['defVals'])) {
				foreach($this->P['params']['defVals'] as $theF => $theV)	{
					if (isset($GLOBALS['TCA'][$this->P['params']['table']]['columns'][$theF]))	{
						$defVals .= '&defVals['.$this->P['params']['table'].']['.$theF.']='.$this->P['uid'];
					}
				}
			}
			#debug($defVals);
				// Redirecting to alt_doc.php with instructions to create a new record AND when closing to return back with information about that records ID etc.
			header('Location: '.t3lib_div::locationHeaderUrl('alt_doc.php?returnUrl='.rawurlencode(t3lib_div::getIndpEnv('REQUEST_URI')).'&returnEditConf=1&edit['.$this->P['params']['table'].']['.$this->pid.']=new'.$defVals));
		}
	}
}

// Include extension?
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ux_SC_wizard_add.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ux_SC_wizard_add.php']);
}











// Make instance:
$SOBE = t3lib_div::makeInstance('SC_wizard_add');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
?>