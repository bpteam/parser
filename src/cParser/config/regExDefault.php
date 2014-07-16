<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 16.07.14
 * Time: 9:40
 * Project: parser_carters
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

return array(
	'category' => '%<a\s*href="(?<category_url>[^"]*)">\s*(?<category_name>[^<]*)\s*</a>%imsu',
	'category_parent' => '%(?<text>.*)%imsu',
	'subcategory' => '%<a\s*href="(?<subcategory_url>[^"]*)"[^>]*>\s*<span>(?<subcategory_name>[^<]*)</span>%imsu',
	'subcategory_parent' => '%(?<text>.*)%imsu',
	'list' => 'regEx for parsing links for ad page index:[unique] - link',
	'list_parent' => 'parent block for list index: [text] - text for list',
	'site_page' => 'download page checker index:[0]',
	'pagination' => 'find numbers of pages in catalog index:[url] - link to next page [url_start] - first part url [num] - number of page [url_end] second part url',
	'current_page' => 'curent page, need for move to the next page index:[current_page] - number of current page',
	'total_pages' => 'count peges in catalog index:[total_pages]',
	'pagination_parent' => 'parent block for pagination index:[text]',
	'ad' => array(),
	'ad_parent' => 'parent of ad block index:[text]',
);