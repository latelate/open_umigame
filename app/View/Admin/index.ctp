<div id="mondai-pagination" class="pagination">
<?php
//リンク
echo "<div class=\"black-bar margin_b50\"><h1>管理画面(問い合わせ内容閲覧)</h1></div>";
echo "<a href='" . $this->Html->url('/admin/delete/0') . "'>問題の削除ページ</a><br />";
echo "<br />";
echo "<a href='" . $this->Html->url('/admin/degree') . "'>称号一覧・編集</a><br />";
echo "<br />";
$this->Paginator->options();
$options = array(
    'tag'=>'span class="pagi"',
    'modulus'=>19,
    'first'=>'',
    'last'=>'',
    'separator'=>false,
);
echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->numbers($options);
echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );
?>
</div>
<table class="mondai_table">
<tr bgcolor="#7E682D"><th width="130">No</th><th>名前</th><th>メッセージ</th><th>アドレス</th><th>種類</th><th>日付</th></tr>
<?php
$color1 = 1;
for($i = 0;$i < count($maildata);$i++){
    $arr = $maildata[$i];
    if ($color1 == 1){
        echo "<tr>";
        $color1 = 2;
    } else {
        echo "<tr bgcolor=\"#AC965A\">";
        $color1 = 1;
    }
    echo "<td>";
    echo "ユーザーID「".h($arr['User']['id'])."」<br />";
    echo "登録日<br />「".$this->Html->dfj(h($arr['User']['created']))."」";
    echo "</td><td>";
    echo "<a href='" . $this->Html->url('/mondai/profile/' . $arr['User']['id']) . "'>" . h($arr['User']['name']) . "</a>";
    echo "</td><td>";
    echo nl2br(h($arr['Mail']['message']));
    echo "</td><td>";
    echo h($arr['Mail']['mail']);
    echo "</td><td>";
    echo h($arr['Mail']['kind']);
    echo "</td><td>";
    echo h($arr['Mail']['created']);
    echo "</td><tr>";

}
?>
</table>
