<?php
echo "<div class=\"pagi-auto\">\n";
echo "<div class=\"pagination\">\n";
$this->Paginator->options();
$options = array(
    'tag'=>'span class="pagi"',
    'modulus'=>9,
    'first'=>'',
    'last'=>'',
    'separator'=>false,
);
echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->numbers($options,array('class'=>'page'));
echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );
echo "</div>\n";
echo "<div id=\"mondai-pagination\" class=\"pagination\">";
echo "<div class=\"sort\"><b>総問題数：" . Cache::read('mondaicount') . "問</b></div>";
echo "<div class=\"clear\"></div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<div class=\"clear\"></div>\n";

echo "(".$this->Html->image("kaisuu.png",array('class'=>'list-icon'))."質問数制限)　";
echo "(".$this->Html->image("zikan.png",array('class'=>'list-icon'))."時間制限)　";
echo "(".$this->Html->image("yami.png",array('class'=>'list-icon'))."闇スープ)　";
echo "(".$this->Html->image("nanashi.png",array('class'=>'list-icon'))."名無し出題)　";
echo "(".$this->Html->image("sashie.png",array('class'=>'list-icon'))."挿絵あり)";
if ($this->params['paging']['Mondai']['page'] == 1){
    echo "<div class=\"black-bar margin_b10\"><h1>未解決問題</h1></div>";
    echo "<table class=\"mondai_table\">";
}
$color1 = 1;
$sakai = 1;
for($i = 0;$i < count($mondailist);$i++){
    $arr = $mondailist[$i];
    if($arr['Mondai']['seikai'] == 1){
        if ($color1 == 1){
            echo "<tr class=\"kage\">";
            $color1 = 2;
        } else {
            echo "<tr>";
            $color1 = 1;
        }
    } else {
        if ($sakai == 1){
            if ($this->params['paging']['Mondai']['page'] == 1){
                echo "</table>";
            }
            echo "<div class=\"black-bar  margin_b10\"><h1>解決済みの問題</h1></div>";
            echo "<table class=\"mondai_table\">";
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
        echo "<div class=\"clear\"></div>\n";
    echo "<div class=\"list-hitokoto\">";
    if (!empty($arr['Mondai']['comment'])){
        echo "<Font Color=\"#787878\">[" . h($arr['Mondai']['comment']) . "]</Font>";
    }
    if ($arr['Mondai']['seikai'] == 3){//解決
        echo "<Font Color=\"#BEBBA3\">[迷宮入]</Font>";
    }
    if (!empty($arr['Indextemp']['0']['count'])){//ブックマーク
        echo "<Font Color=\"#787878\">[" . h($arr['Indextemp']['0']['count']) . "ﾌﾞｸﾏ]</Font>";
    }
    echo "</div>";
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
