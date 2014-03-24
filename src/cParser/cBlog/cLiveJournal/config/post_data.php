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
	'tags' => '%<a[^>]*href=["\']http://[^\'"]+livejournal.com/tag/[^\'"]+["\'][^>]*>(?<tags>[^<]+)</a>,%Uims',
	'last_tag' => '%<a[^>]*href=["\']http://[^\'"]+livejournal.com/tag/[^\'"]+["\'][^>]*>(?<last_tag>[^<]+)</a>[^,]%Uims',
	'comment_page' => '%<a\s*href="http://\w*\.livejournal\.com/\d+\.html\?page=(?<comment_page>\d+)\#comments">\d+</a>%Uims',
	'journal' => '%(http://)?(?<journal>\w+)\.livejournal\.com%ims',
	'list' => '%<a[^>]*href="(?<url>(?<unique>http://(?<journal>\w+)\.livejournal\.com/(?<id>\d+)\.html))"[^>]*>(?<title>[^><]+)</a>%imsu',
	'previous_url' => '%<a[^>]*href="(?<previous_url>(?<url>http://\w+\.livejournal\.com/\?skip=\d+))"[^>]*>%imsu',
	'user_nic' => '%Site\.journal\s*=\s*(?<user_nic>\{.*\});%imsuU',

);
