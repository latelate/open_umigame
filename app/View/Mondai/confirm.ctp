<?php
$arr = $data;
    //フォント赤
    preg_match_all('/#red#(.+?)#\/red#/u', h($arr['Mondai']['content']), $fontred);
    //フォント大きさ５
    preg_match_all('/#big5#(.+?)#\/big5#/u', h($arr['Mondai']['content']), $fontbig5);
    //太い
    preg_match_all('/#b#(.+?)#\/b#/u', h($arr['Mondai']['content']), $fontb);
    //最初の文字を大きく
    $preg = preg_replace('/^(#(.+?)#)/u',"",h($arr['Mondai']['content']));
    preg_match_all("/^./u",h($preg), $matches);
    if (!empty($matches[0][0])){
        $initial = $matches[0][0];
    }
    //問題文box
    echo "<div class=\"black-bar margin_b50\"><h1>新規作成：確認画面「".h($arr['Mondai']['title']);
    echo "」</h1></div>";
    echo "<div class=\"box\">\n";
    //問題文
    echo nl2br(h($arr['Mondai']['content']));
    echo "    <div class=\"r align_r font14\">\n";
    echo "<br />";
    if ($arr['Mondai']['genre'] == 1) {
        echo "【ウミガメのスープ】";
    } elseif ($arr['Mondai']['genre'] == 2) {
        echo "【20の扉】";
    } elseif ($arr['Mondai']['genre'] == 3) {
        echo "【亀夫君問題】";
    } elseif ($arr['Mondai']['genre'] == 4) {
        echo "【新・形式】";
    } elseif ($arr['Mondai']['genre'] == 5) {
        echo "【闇スープ】";
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
        switch ($arr['Mondai']['scount']) {
            case '1':
                echo "【質問制限：1回まで】";
                break;
            case '3':
                echo "【質問制限：3回まで】";
                break;
            case '10':
                echo "【質問制限：10回まで】";
                break;
            case '20':
                echo "【質問制限：20回まで】";
                break;
            case '50':
                echo "【質問制限：50回まで】】";
                break;
            case '100':
                echo "【質問制限：100回まで】】";
                break;
        }
    }
    if ($arr['Mondai']['yami'] == 2){
            echo "【闇スープ】";
    }
    //一時名無し
    if ($arr['Mondai']['itijinanashi'] == 2) {
        echo "<b>[名無しますか？]</b>";
    } else {
        echo "<b>".h(AuthComponent::user('name'))."</b>\n";
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
    echo "    <div class=\"clear\"></div>\n";
    echo "    </div>\n";




    //解説box
    echo "<div class=\"box\">";
    //独自タグ
    echo nl2br(h($arr['Mondai']['kaisetu']));
    echo "    <div class=\"clear\"></div>\n";
    echo "</div>\n";
?>



<?php
    echo "    ".$this->Form->create(null,array('type'=>'post','url'=>'./add'))."\n";
    echo "        ".$this->Form->hidden('Mondai.genre', array('value' => $data['Mondai']['genre']))."\n";
    echo "        ".$this->Form->hidden('Mondai.title', array('value' => $data['Mondai']['title']))."\n";
    echo "        ".$this->Form->hidden('Mondai.content', array('value' => $data['Mondai']['content']))."\n";
    echo "        ".$this->Form->hidden('Mondai.kaisetu', array('value' => $data['Mondai']['kaisetu']))."\n";
    echo "        ".$this->Form->hidden('Mondai.stime', array('value' => $data['Mondai']['stime']))."\n";
    echo "        ".$this->Form->hidden('Mondai.scount', array('value' => $data['Mondai']['scount']))."\n";
    echo "        ".$this->Form->hidden('Mondai.textflg', array('value' => $data['Mondai']['textflg']))."\n";
    echo "        ".$this->Form->hidden('Mondai.nanashi', array('value' => $data['Mondai']['nanashi']))."\n";
    echo "        ".$this->Form->hidden('Mondai.itijinanashi', array('value' => $data['Mondai']['itijinanashi']))."\n";
    echo "        ".$this->Form->hidden('Mondai.yami', array('value' => $data['Mondai']['yami']))."\n";
    echo "<br />";
    echo "<br />";
    echo "<center>".$this->Form->submit("問題投稿")."</center>\n";
    echo "    ".$this->Form->end()."\n";
?>
<input type="submit" value="出題画面に戻る" onclick="history.go(-1)" />
</form>
