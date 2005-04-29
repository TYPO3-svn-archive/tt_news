<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2004 Kasper Skaarhoj (kasper@typo3.com)
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
 * This is an example for processing the news images by a user function.
 *
 * $Id$
 *
 * @author	Rupert Germann <rupi@gmx.li>
 */

/**
 * Example function that adds 4 new imageWraps to the images in 'SINGLE' view.
 * Each image will be wrapped with its own css-class to display f.e. different background colors. 
 * The function expects, that you define image wraps in your TS setup, 
 * that contain a number (see example TS below)  
 * 'imageWrapIfAny' (without number) can still be used to wrap all images
 */ 
/*  add this to your TS-setup:

  	# include the php script
    includeLibs.imageMarkerFunc = EXT:tt_news/res/example_imageMarkerFunc.php

	plugin.tt_news {
 		# call user function
 		imageMarkerFunc = user_imageMarkerFunc
 		displaySingle {
 			imageWrapIfAny_0 = <div class='news-single-images-container0'> | </div>
    		imageWrapIfAny_1 = <div class='news-single-images-container1'> | </div>
    		imageWrapIfAny_2 = <div class='news-single-images-container2'> | </div>
    		imageWrapIfAny_3 = <div class='news-single-images-container3'> | </div>
		}
		# example styles for the new wraps 
		_CSS_DEFAULT_STYLE (
		  	.news-single-images-container0, .news-single-images-container1, .news-single-images-container2, .news-single-images-container3 { width: 200px; margin-left: 5px; }
			.news-single-images-container0 { background-color: #900; }
			.news-single-images-container1 { background-color: #090; }
			.news-single-images-container2 { background-color: #009; }
			.news-single-images-container3 { background-color: #990; }
		)
 	}
 		
*/
/** 
 * Example function that adds different wraps to images.
 *   
 * @param 	array	$paramArray: $markerArray and $config of the current news item in an array
 * @return	array	the processed markerArray 
 */
function user_imageMarkerFunc($paramArray,$conf){

	$markerArray = $paramArray[0];
	$lConf = $paramArray[1];
    $pObj = &$conf['parentObj']; // make a reference to the parent-object
	$row = $pObj->local_cObj->data;
	
	$imageNum = isset($lConf['imageCount']) ? $lConf['imageCount']:1;
	$imageNum = t3lib_div::intInRange($imageNum, 0, 100);
	$theImgCode = '';
	$imgs = t3lib_div::trimExplode(',', $row['image'], 1);
	$imgsCaptions = explode(chr(10), $row['imagecaption']);
	reset($imgs);
	$cc = 0;

	// unset the first image in the array (in single view) if the TS-var 'firstImageIsPreview' is set
	if (count($imgs) > 1 && $pObj->config['firstImageIsPreview'] && $textRenderObj == 'displaySingle') {
		unset($imgs[0]);
		unset($imgsCaptions[0]);
		$cc = 1;
	}
	while (list(, $val) = each($imgs)) {
		if ($cc == $imageNum) break;
		if ($val) {
		 	$lConf['image.']['altText'] = ''; // reset altText
			$lConf['image.']['altText'] = $lConf['image.']['altText']; // set altText to value from TS
			$lConf['image.']['file'] = 'uploads/pics/'.$val;
			switch($lConf['imgAltTextField']) {
				case 'image': 
					$lConf['image.']['altText'] .= $val;
				break;
				case 'imagecaption': 
					$lConf['image.']['altText'] .= $imgsCaptions[$cc];
				break;
				default:
					$lConf['image.']['altText'] .= $row[$lConf['imgAltTextField']];
			} 
		}
		$theImgCode .= $pObj->local_cObj->wrap($pObj->local_cObj->IMAGE($lConf['image.']).$pObj->local_cObj->stdWrap($imgsCaptions[$cc], $lConf['caption_stdWrap.']),$lConf['imageWrapIfAny_'.$cc]);
		$cc++;
	}
	$markerArray['###NEWS_IMAGE###'] = '';
	if ($cc) {
		$markerArray['###NEWS_IMAGE###'] = $pObj->local_cObj->wrap(trim($theImgCode), $lConf['imageWrapIfAny']);
		
	}
		return $markerArray;
	
}

/**
 * Example function which adds masks to images
 */ 
/*  add this to your TS-setup:

# include the php script
includeLibs.imageMarkerFunc = EXT:tt_news/res/example_imageMarkerFunc.php

plugin.tt_news {
  # call user function
  imageMarkerFunc = user_maskImages
}
*/
/** 
 * masking images.
 *   
 * @param 	array	$paramArray: $markerArray and $config of the current news item in an array
 * @return	array	the processed markerArray 
 */
function user_maskImages($paramArray,$conf){

	$markerArray = $paramArray[0];
	$lConf = $paramArray[1];
    $pObj = &$conf['parentObj']; // make a reference to the parent-object
	$row = $pObj->local_cObj->data;

	$imageNum = isset($lConf['imageCount']) ? $lConf['imageCount']:1;
	$imageNum = t3lib_div::intInRange($imageNum, 0, 100);
	$theImgCode = '';
	$imgs = t3lib_div::trimExplode(',', $row['image'], 1);
	$imgsCaptions = explode(chr(10), $row['imagecaption']);
	$imgsAltTexts = explode(chr(10), $row['imagealttext']);
	$imgsTitleTexts = explode(chr(10), $row['imagetitletext']);

	reset($imgs);

	$cc = 0;
	// remove first img from the image array in single view if the TSvar firstImageIsPreview is set
	if (count($imgs) > 1 && $pObj->config['firstImageIsPreview'] && $textRenderObj == 'displaySingle') {
		array_shift($imgs);
		array_shift($imgsCaptions);
		array_shift($imgsAltTexts);
		array_shift($imgsTitleTexts);
	}
	// get img array parts for single view pages
	if ($pObj->piVars[$pObj->config['singleViewPointerName']]) {
		$spage = $pObj->piVars[$pObj->config['singleViewPointerName']];
		$astart = $imageNum*$spage;
		$imgs = array_slice($imgs,$astart,$imageNum);
		$imgsCaptions = array_slice($imgsCaptions,$astart,$imageNum);
		$imgsAltTexts = array_slice($imgsAltTexts,$astart,$imageNum);
		$imgsTitleTexts = array_slice($imgsTitleTexts,$astart,$imageNum);
	}
	$img = t3lib_div::makeInstance('t3lib_stdGraphic');
	$img->mayScaleUp = 1;
	while (list(, $val) = each($imgs)) {
		if ($cc == $imageNum) break;
		if ($val) {

			$lConf['image.']['altText'] = $imgsAltTexts[$cc];
			$lConf['image.']['titleText'] = $imgsTitleTexts[$cc];
			$lConf['image.']['file'] = 'uploads/pics/' . $val;
		}

		$img->init();
		if ($pObj->alternativeTempPath && t3lib_div::inList($GLOBALS['TYPO3_CONF_VARS']['FE']['allowedTempPaths'],$pObj->alternativeTempPath)) {
			$img->tempPath = $pObj->alternativeTempPath;
		}
		
		$imgInfo = $img->imageMagickConvert($lConf['image.']['file'],'',$lConf['image.']['file.']['maxW'],$lConf['image.']['file']['maxH'],'-quality 100','0','');
	
		$bgInfo = $img->imageMagickConvert('media/frames/darkroom8_bottom.jpg','',$imgInfo[0],$imgInfo[1],'-quality 100 -negate','0','');
		$mInfo = $img->imageMagickConvert('media/frames/darkroom8_mask.jpg','',$imgInfo[0],$imgInfo[1],'-quality 100 -negate','0','');
	
		$cmd = $img->imageMagickPath.$img->combineScript.' -compose over '.$img->wrapFileName($imgInfo[3]).' '.$img->wrapFileName($bgInfo[3]).'	'.$img->wrapFileName($mInfo[3]).' '.$img->wrapFileName($imgInfo[3]);
	
		exec($cmd);
		if (!$imgInfo[3]) {
			$theImgCode.= '<img src="fileadmin/Templates/notavaible.gif" border="0">'.$pObj->local_cObj->stdWrap($imgsCaptions[$cc],$lConf['caption_stdWrap.']);
		} else {
			$theImgCode.= '<img src="'. $imgInfo[3] .'" border="0">'.$pObj->local_cObj->stdWrap($imgsCaptions[$cc],$lConf['caption_stdWrap.']);
		}
		$cc++;
	}
	$markerArray['###NEWS_IMAGE###'] = '';
	if ($cc) {
		$markerArray['###NEWS_IMAGE###'] = $pObj->local_cObj->wrap(trim($theImgCode), $lConf['imageWrapIfAny']);
	}
		
	return $markerArray;

}

?>