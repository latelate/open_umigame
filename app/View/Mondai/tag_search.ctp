<?php
echo "<div class=\"black-bar margin_b50\"><h1>検索結果".$this->Paginator->counter(array('format' => '(%count%)'))."</h1></div>";

echo "<div class=\"border\">\n";
echo "<center><h2>タグの検索</h2></center>";
echo $this->Form->create(null,array('type'=>'post','url'=>'./tag_search'));
echo $this->Form->text("Indextag.keyword",array("size" => "20",'placeholder'=>'検索ワードを入力(スペースでand検索できます)','class'=>'formjquery'));
echo $this->Form->submit("検索", array('div'=>false, 'label'=>false));
echo $this->Form->end();
echo $this->Form->error('Indextag.keyword');
echo "</div>\n";

echo "<div id=\"mondai-pagination\" class=\"pagination\">";
$options = array(
    'tag'=>'span class="pagi"',
    'modulus'=>19,
    'first'=>'',
    'last'=>'',
    'separator'=>false,
);
$this->Paginator->options(array('url' => $searchword  ));
echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->numbers($options);
echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );
echo "</div>";
echo "<div class=\"clear\"></div>\n";
echo "<div class=\"clear margin_b10\"></div>";
?>
<?php
echo "<div class=\"clear\"></div>\n";
echo "<table class=\"mondai_table\">";
$color1 = 1;
$sakai = 1;
echo "<tr>";
echo "<th>タグ</th>";
echo "<th>使われた回数</th>";
echo "</tr>";
for($i = 0;$i < count($data);$i++){
    $arr = $data[$i];
    if ($color1 == 1){
        echo "<tr class=\"kage\">";
        $color1 = 2;
    } else {
        echo "<tr>";
        $color1 = 1;
    }
    echo "<td>";
    echo "<a href='" . $this->Html->url('/mondai/tag/' . h($arr['Indextag']['name'])) . "'>";
    echo h($arr['Indextag']['name']);
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo $arr['Indextag']['count'];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
