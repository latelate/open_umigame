<div class="black-bar margin_b50"><h1>ログイン画面</h1></div>
<?php
echo $this->Session->flash();
echo "<div class=\"border\">\n";
echo $this->Form->create(null, array('url' => 'login'));
echo "<table>\n";
echo "<tr><td>" . $this->Form->text('User.username',array('placeholder'=>'ユーザーIDを記入してください。')) . "</td></tr>";
echo "<tr><td>" . $this->Form->password('User.password',array('placeholder'=>'パスワードを記入してください。'));
echo "</td></tr>";
echo "<tr><td>";
echo "<center>".$this->Form->submit("ログイン",array('class'=>'btn btn-default'))."</center>\n";
echo $this->Form->end()."\n";
echo "</td></tr>";
echo "</table>\n";
echo "</div>\n";
?>
<b>パスワードを忘れた場合、本人確認ができないため再発行はできません。必ず忘れないようにメモしてください。</b>
