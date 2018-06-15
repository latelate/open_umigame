<?php
//リンク
echo "<div class=\"black-bar margin_b50\"><h1>称号一覧・編集</h1></div>";
echo "<a href='" . $this->Html->url('/admin') . "'>トップ</a><br />";
echo "<br />";
echo "<a href='" . $this->Html->url('/admin/delete/0') . "'>問題の削除ページ</a><br />";
echo "<br />";
echo "<div class=\"border\">\n";
echo $this->Form->create(null,array('type'=>'post','url'=>'./degree'));
echo "ユーザーID：" . $this->Form->text("Degreelink.user_id") . "<br />";
echo $this->Form->input('Degreelink.degree_id', array('type'=>'select','options'=>$degree2,'label'=>false,'div'=>false,'empty'=>'選んでください'));
echo $this->Form->submit("称号付与", array('div'=>false, 'label'=>false))."\n";
echo $this->Form->end()."\n";
echo "</div>";
echo "<br />";
echo "<br />";
echo "<div class=\"border\">\n";
echo $this->Form->create(null,array('type'=>'post','url'=>'./degree'));
echo $this->Form->hidden('Degree.sinki', array('value' => 1))."\n";
echo "新規称号<br />";
echo "称号名：" . $this->Form->text("Degree.content",array('placeholder'=>'称号名を書きましょう')) . "<br />";
echo "条件：" . $this->Form->text("Degree.condition",array('placeholder'=>'称号付与に必要な条件を書きましょう')) . "<br />";
echo "説明：" . $this->Form->textarea("Degree.explanation",array("cols" => "70","rows" => "10",'placeholder'=>'称号の説明を自由に書きましょう')) . "<br />";
echo "ソートのジャンル：" . $this->Form->text("Degree.genre",array('placeholder'=>'半角英数で種類ごとに同じ単語をつけましょう')) . "<br />";
echo "ソートの順番：" . $this->Form->text("Degree.sort",array('placeholder'=>'半角数字を入力して順番を決めましょう')) . "<br />";
echo $this->Form->checkbox("Degree.closed",array('checked'=>false,'value'=>1))."\n";
echo "非公開にする場合はチェック<br />";
echo $this->Form->submit("新規称号", array('div'=>false, 'label'=>false))."\n";
echo $this->Form->end()."\n";
echo "</div>";
?>
<div id='mondai'>

<?php

echo "<br /><br /><br />";
echo "称号取得者の履歴\n";
echo "<table class=\"mondai_table\">";
for($c = 0;$c < count($rireki);$c++){
    $arr = $rireki[$c];
    echo "<tr>";
    echo "<td>";
    echo $this->Form->create(null,array('type'=>'post','url'=>'./degree'));
    echo h($arr['User']['name']);
    echo "さんは『";
    echo h($arr['Degree']['content']);
    echo "』の称号を獲得しました。";
    echo $this->Form->hidden('Degreelink.id', array('value' => $arr['Degreelink']['id']))."\n";
    echo $this->Form->hidden('Degreelink.del', array('value' => 1))."\n";
    echo $this->Form->submit("取り消し", array('div'=>false, 'label'=>false))."\n";
    echo $this->Form->end()."\n";
    echo "</td>";
    echo "</tr>";
}
echo "</table>\n";
?>
</div>
<?php
for($i = 0;$i < count($data);$i++){
    $arr = $data[$i]['Degree'];
    echo "<div class=\"border\">\n";
    echo $this->Form->create(null,array('type'=>'post','url'=>'./degree'));
    echo $this->Form->hidden('Degree.id', array('value' => $arr['id']))."\n";
    echo "称号名：" . $this->Form->text("Degree.content", array('value' => $arr['content'])) . "<br />";
    echo "条件：" . $this->Form->text("Degree.condition",array("size" => "50",'value' => $arr['condition'])) . "<br />";
    echo "説明：" . $this->Form->textarea("Degree.explanation",array("cols" => "70","rows" => "10",'value' => $arr['explanation'])) . "<br />";
    echo "ソートのジャンル：" . $this->Form->text("Degree.genre", array('value' => $arr['genre'])) . "<br />";
    echo "ソートの順番：" . $this->Form->text("Degree.sort", array('value' => $arr['sort'])) . "<br />";
    echo "非公開にする場合は1に。公開は0<br />";
    echo $this->Form->text("Degree.closed",array('value'=>$arr['closed']))."<br />\n";
    echo $this->Form->checkbox("Degree.edit",array('checked'=>false,'value'=>1))."\n";
    echo "編集する場合はチェック<br />";
    echo $this->Form->submit("編集", array('div'=>false, 'label'=>false))."\n";
    echo $this->Form->end()."\n";
    echo "</div>";
}
//pr($data);
?>
