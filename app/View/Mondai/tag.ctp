<div class="black-bar margin_b50"><h1>タグ「<b><?php echo urldecode(h($param)) ?></b>」のついた問題。<?php echo $this->Paginator->counter(array('format' => '(%count%問)'));?></h1></div>
<?php
echo "<div id=\"mondai-pagination\" class=\"pagination\">";
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
echo "<div class=\"clear\"></div>\n";
echo "<div id=\"mondai-pagination\" class=\"pagination\">";
echo "<div class=\"sort\">" . $this->Paginator->sort('genre','ジャンル別') . "</div>";
echo "<div class=\"sort\">" . $this->Paginator->sort('created','日付順') . "</div>";
echo "<div class=\"sort\">" . $this->Paginator->sort('endtime','解決順') . "</div>";
echo "<div class=\"sort\">" . $this->Paginator->sort('modified','更新順') . "</div>";
echo "</div>\n";
echo "<div class=\"clear margin_b10\"></div>";
echo "(".$this->Html->image("kaisuu.png",array('class'=>'list-icon'))."質問数制限)　";
echo "(".$this->Html->image("zikan.png",array('class'=>'list-icon'))."時間制限)　";
echo "(".$this->Html->image("yami.png",array('class'=>'list-icon'))."闇スープ)　";
echo "(".$this->Html->image("nanashi.png",array('class'=>'list-icon'))."名無し出題)　";
echo "(".$this->Html->image("sashie.png",array('class'=>'list-icon'))."挿絵あり)";
echo "<table class=\"mondai_table\">";
$color1 = 1;
$sakai = 1;
//pr($data2);
for($i = 0;$i < count($data2);$i++){
    $arr = $data2[$i];
    if ($sakai == 1){
        echo "<tr>";
        echo "<th>出題者</th>";
        echo "</tr>";
        echo "<tr>";
        $sakai = 2;
    } else {
        if ($color1 == 1){
            echo "<tr class=\"kage\">";
            $color1 = 2;
        } else {
            echo "<tr>";
            $color1 = 1;
        }
    }
    echo "<td>";
    //ジャンル
    echo "<div class=\"list-others2 margin_r\">";
    if ($arr['Mondai']['genre'] == 1) {
        echo $this->Html->image("genreumi.png",array('class'=>'img-responsive'));
    } elseif ($arr['Mondai']['genre'] == 2) {
        echo $this->Html->image("genre20.png",array('class'=>'img-responsive'));
    } elseif ($arr['Mondai']['genre'] == 3) {
        echo $this->Html->image("genrekame.png",array('class'=>'img-responsive'));
    } elseif ($arr['Mondai']['genre'] == 4) {
        echo $this->Html->image("genresin.png",array('class'=>'img-responsive'));
    } else {
        echo $this->Html->image("genreumi.png",array('class'=>'img-responsive'));
    }
    echo "</div>";

    echo "<div class=\"list-left\">";
    echo "<div class=\"list-others\">";
    if ($arr['Mondai']['delete'] == 2){
        echo "<b>非公開</b>";
    }
    //日付
    $today = date("Y年m月d日");
    if ($this->Html->dfj(h($arr['Mondai']['created'])) == $today){
        echo "<b>";
    }
    echo trim($this->Html->YmdH($arr['Mondai']['created']),20);
    if ($this->Html->dfj(h($arr['Mondai']['created'])) == $today){
        echo "</b>";
    }
    echo "</div>";
    echo "<div class=\"l\">";
    echo "<div class=\"list-title\">";
    if ($arr['Mondai']['seikai'] == 3){//解決
        echo "<Font Color=\"#BEBBA3\">[迷宮入]</Font>";
    }
    //タイトル
    echo "<a href='" . $this->Html->url('/mondai/show/' . $arr['Mondai']['id']) . "'>";
    echo h($arr['Mondai']['title']);
    echo "</a>";
    echo "</div>";
    if (!empty($arr['Mondai']['scount'])){
        echo $this->Html->image("kaisuu.png",array('class'=>'list-icon'));
    }
    if (!empty($arr['Mondai']['stime'])) {
        echo $this->Html->image("zikan.png",array('class'=>'list-icon'));
    }
    if ($arr['Mondai']['yami'] == 2) {//闇スープ
        echo $this->Html->image("yami.png",array('class'=>'list-icon'));
    }
    if ($arr['Mondai']['itijinanashi'] == 2) {//一時的名無し
        echo $this->Html->image("nanashi.png",array('class'=>'list-icon'));
    }
    echo "</div>";
    //一言コメント
    if (!empty($arr['Mondai']['comment'])){
        echo "<div class=\"clear\"></div>\n";
        echo "<div class=\"list-hitokoto\">";
        echo "<Font Color=\"#787878\">[" . h($arr['Mondai']['comment']) . "]</Font>";
        echo "</div>";
    }
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
