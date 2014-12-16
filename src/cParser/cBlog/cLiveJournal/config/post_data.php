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
	'comment_html' => array(
		'id' => '%<a\s*name="[^\d]*(?<id>\d+)"></a>%Uims',
		'author' => '%lj:user="(?<author>[^"]+)"%Uims',
		'avatar_url' => '%<img[^>]*src="(?<avatar_url>http://l-userpic\.livejournal\.com/\d+/\d+)"[^>]*>%Uims',
		'parent' => '%<a href="http://ivanetsoleg\.livejournal\.com/\d+\.html\?thread=(?<parent>\d+)\#[^"]*">Parent</a>%Uims',
		//'subject' => '', // not found
		//'comment' => '', // take from cStringWork::betweenTag
		'timestamp' => '%<span title="[^"]*">(?<timestamp>.*)\s*\(UTC\)</span>%Uims',
	),
	'title_json' => '%Site\.entry\s=\s(?<title_json>{.+});\n%Uims',
	'tags' => '%<a[^>]*href=["\']http://[^\'"]+livejournal.com/tag/[^\'"]+["\'][^>]*>(?<tags>[^<]+)</a>,%Uims',
	'last_tag' => '%<a[^>]*href=["\']http://[^\'"]+livejournal.com/tag/[^\'"]+["\'][^>]*>(?<last_tag>[^<]+)</a>[^,]%Uims',
	'comment_page' => '%<a\s*href="http://\w*\.livejournal\.com/\d+\.html\?page=(?<comment_page>\d+)\#comments">\d+</a>%Uims',
	'journal' => '%(http://)?(?<journal>\w+)\.livejournal\.com%ims',
	'list' => '%<a[^>]*href="(?<url>(?<unique>http://(?<journal>\w+)\.livejournal\.com/(?<id>\d+)\.html))"[^>]*>(?<title>[^><]+)</a>%imsu',
	'previous_url' => '%<a[^>]*href="(?<previous_url>(?<url>http://\w+\.livejournal\.com/(\?skip=\d+|\d{4}/\d{2}/\d{2})))"[^>]*>%imsu',
	'user_nic' => '%Site\.journal\s*=\s*(?<user_nic>\{.*\});%imsuU',

);
