<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 15.07.14
 * Time: 10:00
 * Email: bpteam22@gmail.com
 */
return array(
	'catalog' => array('category hierarchy index:[category_key] - id category [category_name] - name of category [category_url] - url of category' =>
		array('regEx for sub_category [category_key] - id category [category_name] - name of category [category_url] - url of category' => array('sub sub level' => 'end level'))
	),
	'list' => 'regEx for parsing links for ad page index:[unique] - link',
	'list_parent' => 'parent block for list index: [text] - text for list',
	'site_page' => 'download page checker index:[0]',
	'pagination' => 'find numbers of pages in catalog index:[url] - link to next page [url_start] - first part url [num] - number of page [url_end] second part url',
	'current_page' => 'curent page, need for move to the next page index:[current_page] - number of current page',
	'total_pages' => 'count peges in catalog index:[total_pages]',
	'pagination_parent' => 'parent block for pagination index:[text]',
	'ad' => array(
		'*' => 'regEx of property index:[*]'
	),
	'ad_parent' => 'parent of ad block index:[text]',
);