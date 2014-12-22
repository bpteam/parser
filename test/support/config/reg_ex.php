<?php
/**
 * Created by PhpStorm.
 * User: ec
 * Date: 22.12.14
 * Time: 10:40
 * Project: fo_realty
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */
return array(
	'category' => '%<a\s*href="(?<category_url>[^"]*)">\s*(?<category_name>[^<]*)\s*</a>%imsu',
	'category_parent' => '%(?<text>.*)%imsu',
	'subcategory' => '%<a\s*href="(?<subcategory_url>[^"]*)"[^>]*>\s*<span>(?<subcategory_name>[^<]*)</span>%imsu',
	'subcategory_parent' => '%(?<text>.*)%imsu',
	'list' => '%<p><a\s*href="(?<unique>[^\"]+)">\w+</a></p>%imsU',
	'list_parent' => '%(?<text>.*)%imsu',
	'site_page' => '%</html>%imsu',
	'pagination' => '%<a\s*href="(?<url>(?<url_start>[^"]+page=)(?<num>\d+)(?<url_end>[^"]*))">%ims',
	'current_page' => '%<span\s*class="[^"]*current[^"]*">\s*<span>(?<current_page>\d+)</span>\s*</span>%ims',
	'total_pages' => '%<input[^>]*class="{totalPages:\s*(?<total_pages>\d+)}"[^>]*>%imsU',
	'pagination_parent' => '%(?<text>.*)%imsu',
	'ad' => array(
		'data' => '%<div id="data">(?<data>.*?)</div>%imsu',
	),
	'ad_parent' => '%(?<text>.*)%imsu',
	'404' => '%404 куды залез\?%imsu',
	'empty_list' => '%Чет ты не то ищешь%imsu',
);