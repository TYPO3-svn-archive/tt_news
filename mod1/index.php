<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2004  ()
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
 * Module 'multilanguagenews' for the 'tt_news' extension.
 *
 * @author     <>
 */



    // DEFAULT initialization of a module [BEGIN]
unset($MCONF);    
require ("conf.php");
require ($BACK_PATH."init.php");
require ($BACK_PATH."template.php");
$LANG->includeLLFile("EXT:tt_news/mod1/locallang.php");
#include ("locallang.php");
require_once (PATH_t3lib."class.t3lib_scbase.php");
$BE_USER->modAccess($MCONF,1);    // This checks permissions and exits if the users has no permission for entry.
    // DEFAULT initialization of a module [END]

class tx_ttnews_module1 extends t3lib_SCbase {
    var $pageinfo;

    /**
     * 
     */
    function init()    {
        global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
        
        parent::init();

        /*
        if (t3lib_div::_GP("clear_all_cache"))    {
            $this->include_once[]=PATH_t3lib."class.t3lib_tcemain.php";
        }
        */
    }

    /**
     * Adds items to the ->MOD_MENU array. Used for the function menu selector.
     */
    function menuConfig()    {
        global $LANG;
        $this->MOD_MENU = Array (
            "function" => Array (
                "1" => $LANG->getLL("function1"),
                #"2" => $LANG->getLL("function2"),
                #"3" => $LANG->getLL("function3"),
            )
        );
        parent::menuConfig();
    }

        // If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
    /**
     * Main function of the module. Write the content to $this->content
     */
    function main()    {
        global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
        
        // Access check!
        // The page will show only if there is a valid page and if this page may be viewed by the user
        $this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
        $access = is_array($this->pageinfo) ? 1 : 0;
        
        if (($this->id && $access) || ($BE_USER->user["admin"] && !$this->id))    {
    
                // Draw the header.
            $this->doc = t3lib_div::makeInstance("mediumDoc");
            $this->doc->backPath = $BACK_PATH;
            $this->doc->form='<form action="" method="POST">';

                // JavaScript
            $this->doc->JScode = '
                <script language="javascript" type="text/javascript">
                    script_ended = 0;
                    function jumpToUrl(URL)    {
                        document.location = URL;
                    }
                </script>
            ';
            $this->doc->postCode='
                <script language="javascript" type="text/javascript">
                    script_ended = 1;
                    if (top.fsMod) top.fsMod.recentIds["web"] = '.intval($this->id).';
                </script>
            ';

            $headerSection = $this->doc->getHeader("pages",$this->pageinfo,$this->pageinfo["_thePath"])."<br>".$LANG->sL("LLL:EXT:lang/locallang_core.php:labels.path").": ".t3lib_div::fixed_lgd_pre($this->pageinfo["_thePath"],50);

            $this->content.=$this->doc->startPage($LANG->getLL("title"));
            $this->content.=$this->doc->header($LANG->getLL("title"));
            $this->content.=$this->doc->spacer(5);
            $this->content.=$this->doc->section("",$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,"SET[function]",$this->MOD_SETTINGS["function"],$this->MOD_MENU["function"])));
            $this->content.=$this->doc->divider(5);

            
            // Render content:
            $this->moduleContent();

            
            // ShortCut
            if ($BE_USER->mayMakeShortcut())    {
                $this->content.=$this->doc->spacer(20).$this->doc->section("",$this->doc->makeShortcutIcon("id",implode(",",array_keys($this->MOD_MENU)),$this->MCONF["name"]));
            }
        
            $this->content.=$this->doc->spacer(10);
        } else {
                // If no access or if ID == zero
        
            $this->doc = t3lib_div::makeInstance("mediumDoc");
            $this->doc->backPath = $BACK_PATH;
        
            $this->content.=$this->doc->startPage($LANG->getLL("title"));
            $this->content.=$this->doc->header($LANG->getLL("title"));
            $this->content.=$this->doc->spacer(5);
            $this->content.=$this->doc->spacer(10);
        }
    }

    /**
     * Prints out the module HTML
     */
    function printContent()    {

        $this->content.=$this->doc->endPage();
        echo $this->content;
    }
    
    /**
     * Generates the module content
     */
    function moduleContent()    {
     	global $LANG;
        switch((string)$this->MOD_SETTINGS["function"])    {
            case 1:
            	
               // $content=PATH_site."/".t3lib_extMgm::extPath("tt_news");
                //Get Overview of items in this page:
                $res_languages = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
		                '*',         // SELECT ...
		                'sys_language',     // FROM ...
		                '',    // WHERE...
		                '',            // GROUP BY...
		                '',    // ORDER BY...
		                ''            // LIMIT ...
		            );
		 
		//make language array
		$languages[0]='Default';
		$language_count=1;
		while($row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res_languages)) {
			$languages[$row['uid']]=$row['title'];			
			$language_count++;
		}
		
		$res_news = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
		                '*',         // SELECT ...
		                'tt_news',     // FROM ...
		                'deleted=\'0\' AND pid='.$this->id,    // WHERE...
		                '',            // GROUP BY...
		                'sys_language_uid',    // ORDER BY...
		                ''            // LIMIT ...
		);
		//Load the news in this page and make relation arrays
		$this->newsarray=array();
		$language_to_news=array();
		$news_to_language=array();
		while($row=$GLOBALS['TYPO3_DB']->sql_fetch_assoc($res_news)) {
			$sys_language_uid=$row['sys_language_uid'];
			if ($sys_language_uid =="")
				$sys_language_uid=0;
			$news_to_language[$row['uid']]=$sys_language_uid;			
			$language_to_news[$sys_language_uid][]=$row['uid'];
			$this->newsarray[$row['uid']]=$row;
			//Array with flags if newsitem is printed out
			$news_liste[$row['uid']]=1;
		}
 		
 		//Print out the News:
 		$content .="<table>";
 		$content .= $this->renderTableRow($languages,$language_count,true);
 		
 		foreach ($language_to_news as $k => $v) {
 			foreach ($v as $uid) {
 				if ($news_liste[$uid] ==1) {
 					//Get releted news (result is $langageid=>uid)
 					//$languagerelated=$this->getLanguageRelated($uid);
 					
 					$crow=array();
 					//Insert the actual newsitem in the right column:
 					$crow[$k]=$this->renderNewsItem($uid);
 					$news_liste[$uid]=0;	//Mark the item as printed
 					//Look if releted news exists and insert them in the right column
 					for ($i=$k; $i <= $language_count;$i++) {	 					
	 					if (isset($languagerelated[$i]) && $languagerelated[$i] !="" && $news_liste[$languagerelated[$i]] ==1) {
	 						$crow[$i]=$this->renderNewsItem($languagerelated[$i]);
	 						$news_liste[$languagerelated[$i]]=0;	 						
	 					}
	 				}
 					$content .= $this->renderTableRow($crow,$language_count);
 				}
 			}
 		}
 					
 		$content .="</table>";

                
                //Get news for each language
                
                
               
                $this->content.=$this->doc->section($LANG->getLL("overview").":",$content,0,1);
            break;
            case 2:
                $content="<div align=center><strong>Menu item #2...</strong></div>";
                $this->content.=$this->doc->section("Message #2:",$content,0,1);
            break;
            case 3:
                $content="<div align=center><strong>Menu item #3...</strong></div>";
                $this->content.=$this->doc->section("Message #3:",$content,0,1);
            break;
        } 
    }
    
    /* render a complete table row
    * $rowarray can be an an array or an assocarray (in this case the key is interpreted as columnumber)
    * $mincount (if not enough items in the rowarray the rest columns (until mincount) were rendered empty)
    */    
    function renderTableRow($rowarray,$mincount=0,$th=false) {
    	$content="<tr>";
    	$c=0;
    	if (is_array($rowarray)) {
    	//debug($rowarray);
	    	foreach ($rowarray as $k=>$v) {
	    		if (is_numeric($k)) {
		    		while ($k > $c) {
			    		if ($th) {
			    			$content .="<th></th>";
			    		}
			    		else {
			    			$content .="<td></td>";    			
			    		}
			    		$c++;
			    	}
			}	    		
	    		if ($th) {
	    			$content .="<th>".$v."</th>";
	    		}
	    		else {
	    			$content .="<td>".$v."</td>";    			
	    		}
	    		$c++;
	    	}
	}
    	while ($mincount > $c) {
    		if ($th) {
    			$content .="<th></th>";
    		}
    		else {
    			$content .="<td></td>";    			
    		}
    		$c++;
    	}
    	if ($c >0)
    		return '<tr>'.$content.'</tr>';
    	else
    		return;
    }
    
    
    function renderNewsItem($uid) {
	$params='&edit[tt_news]['.$uid.']=edit';
	$link = '<a href="'.$this->doc->backPath.'alt_doc.php?returnUrl='.TYPO3_MOD_PATH.'&amp;edit[tt_news][7]=edit">Edit</a>';
        
        $icon = t3lib_iconWorks::getIconImage(
            'tt_news',
            $this->newsarray[$uid],
           $this->doc->backPath,
            'align="top" class="c-recIcon"'
        );


    	
    	return $icon.'<b>'.$this->newsarray[$uid]['title'].'</b> ('.$this->newsarray[$uid]['uid'].')'.$link;
    }
    	
}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/tt_news/mod1/index.php"])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/tt_news/mod1/index.php"]);
}




// Make instance:
$SOBE = t3lib_div::makeInstance("tx_ttnews_module1");
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)    include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>