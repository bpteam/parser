<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 06.02.14
 * Time: 10:53
 * Email: bpteam22@gmail.com
 */
require_once dirname(__FILE__) . '/../include.php';
if(isset($_POST['tag'])){
	$regEx = Parser\cGeneratorRegEx::fromHtmlTag($_POST['tag']);
}

?>

<form method="post">
	<label>
		Тэг:
		<textarea name="tag" cols="40" rows="5"></textarea>
	</label><br>
	<?
		if(isset($regEx)){
		?>
			<label>
				Выражение:
				<textarea cols="40" rows="5"><?=$regEx?></textarea>
			</label><br>
		<?
		}
	?>
	<input type="submit" value="Gen">
</form>