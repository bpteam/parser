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
	'list' => '%<a\s*href="(?<unique>[^"]+)">%imsU',
	'list_parent' => '%(?<text>.*)%imsu',
	'site_page' => '%</html>%imsu',
	'pagination' => '%<a\s*href="(?<url>(?<url_start>[^"]+page=)(?<num>\d+)(?<url_end>[^"]*))">%ims',
	'current_page' => '%<span\s*class="[^"]*current[^"]*">\s*<span>(?<current_page>\d+)</span>\s*</span>%ims',
	'total_pages' => '%<input[^>]*class="{totalPages:\s*(?<total_pages>\d+)}"[^>]*>%imsU',
	'pagination_parent' => '%(?<text>.*)%imsu',
	'ad' => array(),
	'ad_parent' => '%(?<text>.*)%imsu',
);