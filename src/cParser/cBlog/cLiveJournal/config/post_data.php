<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 13.03.14
 * Time: 10:47
 * Email: bpteam22@gmail.com
 */
return array(
	'comments_json' => '%Site\.page\s=\s(?<comments_json>{.*});\n%Uims',
	'title_json' => '%Site\.entry\s=\s(?<title_json>{.+});\n%Uims',
	'tag' => '%<a[^>]*href=["\']http://[^\'"]+livejournal.com/tag/[^\'"]+["\'][^>]*>(?<tag>[^<]+)</a>%Uims',
);