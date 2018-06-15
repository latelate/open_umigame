<div class="black-bar margin_b50"><h1>問い合わせ</h1></div>
<?php
echo $this->Session->flash();
echo $this->Form->error('Mail.kind');
echo $this->Form->error('Mail.mail');
echo $this->Form->error('Mail.message');
echo $this->Form->create(null,array('type'=>'post','url'=>'./mail'));
echo "<table class=\"mondai_table\">\n";
echo "<tr><th title=\"name\"></th><td title=\"content\">" . $this->Form->radio("Mail.kind",array('バグ報告'=>'バグ報告　','違反者報告'=>'違反者報告　','機能提案'=>'機能提案　','その他'=>'その他　'),array('legend' =>false)) . "</td></tr>";
echo "<tr><th title=\"name\">メッセージ</th><td title=\"content\">" . $this->Form->textarea('Mail.message',array("cols" => "70","rows" => "10")) . "</td></tr>";
echo "<tr><th title=\"name\"></th><td title=\"content\"><div class=\"submit\"><input type=\"submit\" value=\"送信\" /></div></td></tr>\n";
echo "</table></form>\n";
?>
