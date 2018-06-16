<?php
echo "<div class=\"black-bar margin_b50\"><h1>問題の削除</h1></div>";
echo "<a href='" . $this->Html->url('/admin') . "'>トップ</a><br />";
echo "<br />";
echo "<a href='" . $this->Html->url('/admin/degree') . "'>称号一覧・編集</a><br />";
echo "<br />";
if (!empty($data['Mondai']['content'])){
    echo "<h1>問題タイトル「".nl2br(h($data['Mondai']['title']))."」</h1>";
    echo "<h1>問題文「".nl2br(h($data['Mondai']['content']))."」</h1>";
    echo $this->Form->create(null,array('type'=>'post','url'=>'./delete/'.$param));
    echo "<table class=\"mondai_table\">";
    echo "<tr>";
    echo "<td>".$this->Form->text("Mondai.delete",array('placeholder'=>'削除する場合は「delete」と打ち込む'))."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><input type=\"submit\" value=\"削除\" /></td>";
    echo "</form>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<h1>削除問題がセットされていません。<br />";
    echo "「admin/delete/〇〇」〇〇に問題idを打ち込むと削除問題がセットされます。(セットしただけでは削除されません)</h1>";
}
echo "<br /><br />";
echo "問題を削除すると、関連した質問データ、挿絵データ(画像は残ります)、相談チャットデータも一緒に消えます。<br />";
echo "ただし問題についたタグは消えませんので、<b>削除する前に必ずタグは手動で削除してください。</b>(でないとタグ検索時の数が合わなくなります)";
?>
