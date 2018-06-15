<?php
if(empty($title['Degree']['closed'])){
echo "<div class='black-bar margin_b50'><h1>[".$title['Degree']['content']."]を獲得した者たち</h1></div>\n";
echo "<div id=\"paginator\">";
echo "<div id=\"mondai-pagination\">";
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
echo "</div>";
echo "</div>";

echo "<div id=\"mondai-pagination\" class=\"pagination\">";
echo "<table class=\"mondai_table\">";
echo "<tr>";
echo "<th class=\"mondai\">獲得者</th>";
echo "<th class=\"mondai\">付与者</th>";
echo "<th class=\"mondai\">獲得した日付</th>";
echo "</tr>";

$color1 = 1;
for($i = 0;$i < count($data);$i++){
    $arr = $data[$i];
    if ($color1 == 1){
        echo "<tr>";
        $color1 = 2;
    } else {
        echo "<tr class=\"kage\">";
        $color1 = 1;
    }
    echo "<td>";
    echo "<a href='" . $this->Html->url('/mondai/profile/' . $arr['User']['id']) . "'>" . h($arr['User']['name']) . "</a>";
    echo "</td>";
    echo "<td width=\"120\">";
    echo h($arr['Degreelink']['addname']);
    echo "</td>";
    echo "<td width=\"120\">";
    echo trim($this->Html->dfj($arr['Degreelink']['created']),20);
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
} else {
    echo "<div class='black-bar margin_b50'><h1>？？？</h1></div>\n";
}
 ?>
