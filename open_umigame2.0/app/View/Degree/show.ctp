<?php
$arr = $data['Degree'];
echo "<div class=\"black-bar margin_b50\"><h1>";
echo $arr['content'];
echo "</h1></div>";
echo "<div class=\"box\">";
echo "【取得条件】<br />\n";
echo h($arr['condition']) . "<br />\n";
echo "<br />\n";
echo "【称号解説】<br />\n";
echo nl2br($arr['explanation']) . "\n";
echo "</div>";
?>
