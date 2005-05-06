<?php
/**
* Default  TCA_DESCR for "tt_news_cat"
*/

/*
	field.description
	field.syntax
	_field.seeAlso
	field.details
	_field.image
	field.image_descr
*/

$LOCAL_LANG = Array (
	'default' => Array (
			// table description
		'.description' => 'tt_news categories.',
		'_.seeAlso'=>'tt_news manual | http://typo3.org/documentation/document-library/tt_news/',
		
		'title.description' => 'The category title for the default language.',
		'title.details' => 'The display of the category title on the website is configured in the tt_news content element (sheet: category settings) or by TypoScript. The titles for additional website languages are inserted in the field "title language overlays"',
		'_title.seeAlso'=>'tt_news_cat:title_lang_ol',
			
		'title_lang_ol.description' => 'In the field "title language overlays" you can define category titles for other website languages.',
		'title_lang_ol.details' => 'If you have more than one additional website language, you can split the titles with the "|" character.

<strong>Example:</strong>
if you have a website with 3 languages (en,de,fr) it\'s required to write the category title for the default language in the field "title". The titles for german an french are written to the field "title language overlays" like shown in the image below.',
		'_title_lang_ol.image' => 'EXT:tt_news/cshimages/tt_news_cat_title_lang_ol.png',
		'title_lang_ol.image_descr' => 'the order of the overlay titles has to be the same as the order of your system languages.
In this example: en=0, german=1, french=2 ',

		'parent_category.description' => 'Make the current category to a subcategory of the category in this field.',
		'parent_category.details' => 'In the field "Parent category" you can define the current category as a subcategory of the category which is selected in this field. That will include the current category and the newsitems which have this category assigned when the parent category is selected. This works recursive.',
				
		'hidden.description' => 'Use this to temporarily exclude this tt_news category from display and all news which are member of this category.',
		'hidden.details' => 'Setting this option is practical while editing a new tt_news db-record. When it is set, the newsitem will not be displayed unless you - if you\'re logged in as backend user - enable the Admin Panel&gt;Preview&gt;Show hidden records option.',
		'_hidden.seeAlso' => 'tt_news:starttime,tt_news:endtime,tt_news:fe_group',

		'image.description' => 'An image which can be shown instead of (or additionally to) the category title.',
		'image.details' => 'You can upload or assign an image for each news category which is shown f.e. instead of the category title. The behaviour of the category titles/images can be configured in the sheet "Category settings" in the news content element.

The category titles/images can act as shortcut to a page or as "category selector" which means: the contents of a news-list ist filtered by category. Filtering by category works recursive for subcategories.',
		'_image.seeAlso' => 'tt_news_cat:title',
		
		'shortcut.description' => 'An internal page where the category titles and/or images are linked to.',
		'shortcut.details' => 'Category titles or images can also act as shortcut to an internal page. If this is enabled and a visible page is defined as shortcut, the link from the category title or image points to this page.',
		'_shortcut.seeAlso' => 'tt_news_cat:shortcut_target',

		
		'shortcut_target.description' => 'Target for news category shortcut.',
		'shortcut_target.details' => 'With the field "Target for ..." you can configure a target for the category shortcut (this setting will have priority over a global setting for link targets in your website).',
		'_shortcut_target.seeAlso' => 'tt_news_cat:shortcut',

		'single_pid.description' => 'The page which is defined here overrides the globally configured "singlePid".',
		'single_pid.details' => 'The field "Single-view page for news from this category" gives you the possibility to define a Single-View page for each category. If a news-record has 2 or more categories assigned the SinglePid from the first category is choosen. The ordering of categories can be changed with the TSvar "catOrderBy". ',

	),
	'dk' => Array (
		'.description' => 'Indbygget nyhedssystem - kategorier.',
	),
	'de' => Array (
		'.description' => 'Das News System erlaubt es dem Benutzer, Nachrichten zu kategorisieren. Dadurch wird eine bessere Übersichlichkeit der Meldungen gewährleistet.',
	),
	'no' => Array (
		'.description' => 'Kategorier for det innebygde nyhetsystemet.',
	),
	'it' => Array (
		'.description' => 'Categorie delle News integrate al sito',
	),
	'fr' => Array (
	),
	'es' => Array (
		'.description' => 'Categorías incorporadas por el sistema de noticias.',
	),
	'nl' => Array (
		'.description' => 'Categoriën van het nieuwssysteem.',
	),
	'cz' => Array (
		'.description' => 'Vestavìný systém kategorií zpráv.',
	),
	'pl' => Array (
	),
	'si' => Array (
	),
	'fi' => Array (
		'.description' => 'Sisäänrakennetun uutisjärjestelmän luokat',
	),
	'tr' => Array (
		'.description' => 'Haberler Sistem kategorilerinde yapýlandýrýlýyor',
	),
	'se' => Array (
		'.description' => 'Kategorier i det inbyggda nyhetssystemet.',
	),
	'pt' => Array (
	),
	'ru' => Array (
		'.description' => 'Êàòåãîðèè âñòðîåííîé ñèñòåìû íîâîñòåé.',
	),
	'ro' => Array (
	),
	'ch' => Array (
	),
	'sk' => Array (
	),
	'lt' => Array (
	),
	'is' => Array (
	),
	'hr' => Array (
		'.description' => 'Ugraðeni sustav kategorija za novosti.',
	),
	'hu' => Array (
		'.description' => 'Beépített hír kategóriák',
	),
	'gl' => Array (
	),
	'th' => Array (
	),
	'gr' => Array (
	),
	'hk' => Array (
	),
	'eu' => Array (
	),
	'bg' => Array (
	),
	'br' => Array (
	),
	'et' => Array (
	),
	'ar' => Array (
	),
	'he' => Array (
	),
	'ua' => Array (
	),
	'lv' => Array (
	),
	'jp' => Array (
	),
	'vn' => Array (
	),
	'ca' => Array (
	),
	'ba' => Array (
	),
	'kr' => Array (
	),
);
?>