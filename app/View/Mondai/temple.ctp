<?php
    echo "<div class=\"black-bar margin_b50\"><h1>みんなのブックマーク</h1></div>";
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
    echo "<div class=\"clear margin_b10\"></div>";
for($v = 0;$v < count($data);$v++){
    $arr = $data[$v];
    //問題文box
    echo "<table><tr>";
    echo "<td class=\"img-h2-2\">".$this->Html->image("h2-2.png")."</td>";
    echo "<td class=\"text-big3\">「<a href='" . $this->Html->url('/mondai/show/' . $arr['Mondai']['id']) . "'>".h($arr['Mondai']['title'])."</a>」<Font Color=\"#695E39\">「".$arr['Indextemp']['count']."ブックマーク」</Font></td>";
    echo "</tr></table>";

    echo "<div class=\"box margin_b50 margin_t10\">\n";
    //挿絵表示
    if (!empty($cache_sasie['Img']['id'])){
        echo $this->Html->image("img_sashie/".$cache_sasie['Img']['id']."/thumb_".$cache_sasie['Img']['img_file_name'],array("border"=>"0",'class'=>'img_sashie  img_center'));
    }
    //独自タグ
    echo nl2br(h($arr['Mondai']['content']));
    echo "    <div class=\"r align_r font14\">\n";
    echo $this->Html->df(h($arr['Mondai']['created']))."\n";
    echo "<br />";
    if ($arr['Mondai']['genre'] == 1) {
        echo "【ウミガメのスープ】";
    } elseif ($arr['Mondai']['genre'] == 2) {
        echo "【20の扉】";
    } elseif ($arr['Mondai']['genre'] == 3) {
        echo "【亀夫君問題】";
    } elseif ($arr['Mondai']['genre'] == 4) {
        echo "【新・形式】";
    }
    if (!empty($arr['Mondai']['stime'])){
        switch ($arr['Mondai']['stime']) {
            case '+30 minute':
                echo "【時間制限：30分】";
                break;
            case '+1 hour':
                echo "【時間制限：1時間】";
                break;
            case '+3 hour':
                echo "【時間制限：3時間】";
                break;
            case '+6 hour':
                echo "【時間制限：6時間】";
                break;
            case '+12 hour':
                echo "【時間制限：12時間】";
                break;
            case '+1 day':
                echo "【時間制限：1日】";
                break;
            case '+7 day':
                echo "【時間制限：1週間】";
                break;
        }
    }
    if (!empty($arr['Mondai']['scount'])){
        echo "【質問制限：" . $arr['Mondai']['scount'] . "回まで】";
    }
    if ($arr['Mondai']['yami'] == 2){
            echo "【闇スープ】";
    }
    if(!empty($arr['User']['name'])){
        //一時名無し
        if ($arr['Mondai']['itijinanashi'] == 2) {
            echo "<b>[名無しますか？]</b>";
        } else {
            echo "        <b>[<a href='" . $this->Html->url('/mondai/profile/'.$arr['User']['id'])."'>".h($arr['User']['name'])."</a>]</b>\n";
            if (!empty($arr['User']['degree'])){
                echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $arr['User']['degreeid']) . "'>[" .  h($arr['User']['degree']) . "]</a>";
            }
        }
    } else {
        echo "        <b>不明</b>\n";
    }
    echo "    </div>\n";
    if (!empty($arr['Mondai']['comment'])){
            echo "<div class=\"clear\"></div>\n";
            echo "<div class=\"hukidasi r hukidasi-hitokoto\">\n";
                echo "<div class=\"f-rh\">\n";
                    echo $this->Html->image("f-rh.png",array('class'=>'img-responsive'));
                echo "</div>\n";
                echo "<div class=\"hukidasi_box clearfix\">\n";
                    echo "<p class=\"align_r\">\n";
                        echo "<b>".h($arr['Mondai']['comment'])."</b>";
                    echo "</p>";
                echo "</div>\n";
            echo "</div>\n";
    }

    echo "<br />";
    echo "<br />";
    echo "<br />";
    //解説文
    echo "<p class=\"open" . h($v) . "\">解説を見る</p>";
    echo "<div id=\"slideBox" . h($v) . "\">";
    //独自タグ
    echo nl2br(h($arr['Mondai']['kaisetu']));
    echo "</div>";
    echo "<div class=\"clear\"></div>\n";
    echo "</div>";
}
echo "<br />";
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
echo "    <div class=\"clear\"></div>\n";
?>
