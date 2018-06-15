<?php
echo "<div class=\"black-bar margin_b50\"><h1>検索結果</h1></div>";

echo "<div class=\"border\">\n";
echo "<center><h2>問題の検索</h2></center>";
echo $this->Form->create(null,array('type'=>'post','url'=>'./search'));
echo $this->Form->text("Mondai.keyword",array("size" => "20",'placeholder'=>'検索ワードを入力(スペースでand検索できます)','class'=>'formjquery'));

echo $this->Form->input('Mondai.cate', array(
     'label'   => false,
     'type'    => 'select',
     'options' => array(
         'name'=>'名前　',
         'title'=>'タイトル　',
         'content'=>'本文　',
         'kaisetu'=>'解説'
     ),
     'div'     => false,
     'empty'   => '選択してください',
     'class'=>'mondai-search'
 ));


echo $this->Form->submit("検索", array('div'=>false, 'label'=>false));
echo $this->Form->end();
echo $this->Form->error('Mondai.cate');
echo $this->Form->error('Mondai.keyword');
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
for($i = 0;$i < count($data);$i++){
    $arr = $data[$i];
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
    //名前
    if(!empty($arr['User']['name'])){
        //一時名無し
        if ($arr['Mondai']['itijinanashi'] == 2) {
            echo "<b>[名無しますか？]</b>";
        } else {
            echo "<b>";
            echo "<a href='" . $this->Html->url('/mondai/profile/'.h($arr['User']['id'])) . "'>".h($arr['User']['name'])."</a>";
            if (!empty($arr['User']['degree'])){
                echo "[" .  h($arr['User']['degree']) . "]";
            }
            echo "</b>";
        }
    } else {
        echo "<b>不明</b>";
    }
    if ($arr['Mondai']['delete'] == 2){
        echo "<b>非公開</b>";
    }
    if (!empty($arr['Mondai']['realtime'])){
        $realtime = date("Y-m-d H:i:s",strtotime("-10 minute"));
        if ($arr['Mondai']['realtime'] > $realtime){
          if ($arr['Mondai']['seikai'] == 1){//未解決なら表示
            echo "<Font Color=\"#FF0000\">[<b>現在回答中！</b>]</Font>";
          }
        }
    }
    //質問数
    $resa = 0;
    for($c = 0;$c < count($arr['Resq']);$c++){
        if ($arr['Resq'][$c]['ansflg'] != null){
            $resa++;
        }
    }
    if (count($arr['Resq']) == $resa){
        echo "[質問".count($arr['Resq'])."]";
    } else {
        $ato = count($arr['Resq']) - $resa;
        echo "[質問".count($arr['Resq']) . "<Font Color=\"#69623A\">(" . $ato . ")</Font>]";
    }
    //制限
    if (!empty($arr['Mondai']['stime']) or !empty($arr['Mondai']['scount'])){
        echo "[";
    }
    if (!empty($arr['Mondai']['stime'])) {
        switch ($arr['Mondai']['stime']) {
            case '+30 minute':
                echo "30分";
                break;
            case '+1 hour':
                echo "1時間";
                break;
            case '+3 hour':
                echo "3時間";
                break;
            case '+6 hour':
                echo "6時間";
                break;
            case '+12 hour':
                echo "12時間";
                break;
            case '+1 day':
                echo "1日";
                break;
            case '+3 day':
                echo "3日";
                break;
            case '+7 day':
                echo "1週間";
                break;
        }
    }
    if (!empty($arr['Mondai']['stime']) and !empty($arr['Mondai']['scount'])){
        echo "：";
    }
    if (!empty($arr['Mondai']['scount'])){
        echo $arr['Mondai']['scount'] . "回";
    }
    if (!empty($arr['Mondai']['stime']) or !empty($arr['Mondai']['scount'])){
        echo "]";
    }
    echo "　";
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
    if (!empty($arr['Indextemp']['0']['count'])){//ブックマーク
        echo "<Font Color=\"#787878\">[" . h($arr['Indextemp']['0']['count']) . "ﾌﾞｸﾏ]</Font>";
    }
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
    if (!empty($arr['Img']['0']['img_file_name']) or !empty($arr['Img']['1']['img_file_name'])){//挿絵あり
        echo $this->Html->image("sashie.png",array('class'=>'list-icon'));
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
