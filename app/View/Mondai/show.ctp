<script type="text/javascript">
    <!--
    function check4(){
        if (window.confirm('この問題は質問できる数に「限り」があります！下の相談チャットでみんなと協力して「慎重」に問題を解こう！')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('まずは相談チャットで「出すのはどんな質問がいいか」を相談してみよう！'); // キャンセルおしたら
            return false;
        }
    }
    function check3(){
        if (window.confirm('投票しますか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    function check2(){
        if (window.confirm('ブックマークに追加しますか？(マイページから削除できます)')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    function check(){
        if (window.confirm('自動で解説が出ます。よろしいですか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    function sashie1(){
        if (window.confirm('問題文の挿絵を削除します。よろしいですか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    function sashie2(){
        if (window.confirm('解説の挿絵を削除します。よろしいですか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    function yami(){
        if (window.confirm('闇スープ形式のON・OFFボタンです。よろしいですか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('キャンセルされました'); // 警告ダイアログを表示
            return false;
        }
    }
    // -->
</script>
<cake:nocache>
<?php
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_data = Cache::read('cache_data_'.$param)) {
    $cache_data_kari = $data;
    Cache::write('cache_data_'.$param, $cache_data_kari);
    $cache_data = Cache::read('cache_data_'.$param);
} else {
    $cache_data = Cache::read('cache_data_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_data2 = Cache::read('cache_data2_'.$param)) {
    $cache_data2_kari = $data2;
    Cache::write('cache_data2_'.$param, $cache_data2_kari);
    $cache_data2 = Cache::read('cache_data2_'.$param);
} else {
    $cache_data2 = Cache::read('cache_data2_'.$param);
}
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_neighbors = Cache::read('cache_neighbors_'.$param)) {
    $cache_neighbors_kari = $neighbors;
    Cache::write('cache_neighbors_'.$param, $cache_neighbors_kari);
    $cache_neighbors = Cache::read('cache_neighbors_'.$param);
} else {
    $cache_neighbors = Cache::read('cache_neighbors_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_tags = Cache::read('cache_tags_'.$param)) {
    $cache_tags_kari = $tags;
    Cache::write('cache_tags_'.$param, $cache_tags_kari);
    $cache_tags = Cache::read('cache_tags_'.$param);
} else {
    $cache_tags = Cache::read('cache_tags_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_data3 = Cache::read('cache_data3_'.$param)) {
    $cache_data3_kari = $data3;
    Cache::write('cache_data3_'.$param, $cache_data3_kari);
    $cache_data3 = Cache::read('cache_data3_'.$param);
} else {
    $cache_data3 = Cache::read('cache_data3_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_data4 = Cache::read('cache_data4_'.$param)) {
    $cache_data4_kari = $data4;
    Cache::write('cache_data4_'.$param, $cache_data4_kari);
    $cache_data4 = Cache::read('cache_data4_'.$param);
} else {
    $cache_data4 = Cache::read('cache_data4_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_sasie = Cache::read('cache_sasie')) {
    $cache_sasie_kari = $sasie;
    Cache::write('cache_sasie_'.$param, $cache_sasie_kari);
    $cache_sasie = Cache::read('cache_sasie_'.$param);
} else {
    $cache_sasie = Cache::read('cache_sasie_'.$param);
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_sasie2 = Cache::read('cache_sasie2')) {
    $cache_sasie2_kari = $sasie2;
    Cache::write('cache_sasie2_'.$param, $cache_sasie2_kari);
    $cache_sasie2 = Cache::read('cache_sasie2_'.$param);
} else {
    $cache_sasie2 = Cache::read('cache_sasie2_'.$param);
}
?>
</cake:nocache>

<?php
//公開・非公開
if ($cache_data['Mondai']['delete'] >= 2 and $cache_data['User']['id'] != AuthComponent::user('id')){
    if ($cache_data['Mondai']['delete'] == 2){
        echo "<h1 id=\"text-h1\">".h($cache_data['Mondai']['title']);
        echo "<Font Color=\"#ff0000\">は[非公開]設定されています。</Font>";
        echo "</h1>\n";
    }
    if ($cache_data['Mondai']['delete'] == 3){
        echo "<h1 id=\"text-h1\">".h($cache_data['Mondai']['title']);
        echo "<Font Color=\"#ff0000\">は規約違反のため[強制非公開]設定されています。</Font>";
        echo "</h1>\n";
    }
} else {
    //タイトル
    if (!empty($cache_data)){
        echo "<div class=\"black-bar\">";
        echo "<h1>";
        if ($cache_data['Mondai']['genre'] == 1) {
            echo "【ウミガメ】";
        } elseif ($cache_data['Mondai']['genre'] == 2) {
            echo "【20の扉】";
        } elseif ($cache_data['Mondai']['genre'] == 3) {
            echo "【亀夫君】";
        } elseif ($cache_data['Mondai']['genre'] == 4) {
            echo "【新・形式】";
        }
        echo "「 ";
        echo h($cache_data['Mondai']['title']);
        echo " 」";
        if ($cache_data['Mondai']['delete'] >= 2){
            echo "<Font Color=\"#ff0000\">[非公開中です]</Font>";
            if ($cache_data['Mondai']['delete'] == 4){
                echo "<br />";
                echo "<Font Color=\"#ff0000\">一覧に表示されない[完全非公開]設定されています。</Font>";
            }
            echo "</h1>\n";
        }
        echo "</h1>\n";
        echo "</div>";


    } else {
        echo "<h1 id=\"text-h1\">問題データがありません。</h1>\n";
        echo "削除されたか、URLが間違っている可能性があります。";
    }
//公開・非公開
}
//問題前後リンク
if(!empty($cache_neighbors['next']['Mondai'])){
    echo "<div class=\"big l margin_t50\">";
    echo "<a href=\"".$this->Html->url('/mondai/show/'.$cache_neighbors['next']['Mondai']['id'])."\">";
    if (mb_strlen(h($cache_neighbors['next']['Mondai']['title'])) > 15) {
        echo "＜＜「".nl2br(mb_substr(h($cache_neighbors['next']['Mondai']['title']), 0, 15, "UTF-8")) . "...」</a>";
    } else {
        echo "＜＜「".$cache_neighbors['next']['Mondai']['title']."」</a>";
    }
    echo "</div>";
}
if(!empty($cache_neighbors['prev']['Mondai'])){
    echo "<div class=\"big r margin_t50\">";
    echo "<a href=\"".$this->Html->url('/mondai/show/'.$cache_neighbors['prev']['Mondai']['id'])."\">";
    if (mb_strlen(h($cache_neighbors['prev']['Mondai']['title'])) > 15) {
        echo "「".nl2br(mb_substr(h($cache_neighbors['prev']['Mondai']['title']), 0, 15, "UTF-8")) . "...」＞＞</a>";
    } else {
        echo "「".$cache_neighbors['prev']['Mondai']['title']."」＞＞</a>";
    }
    echo "</div>";
}
echo "<div class=\"clear\"></div>\n";
//公開・非公開
if ($cache_data['Mondai']['delete'] >= 2 and $cache_data['User']['id'] != AuthComponent::user('id')){
} else {
    //問題文box
    echo "<div class=\"box\">\n";
    //挿絵表示
    if (!empty($cache_sasie['Img']['img_file_name'])){
        echo $this->Html->image("img_sashie/".$cache_sasie['Img']['id']."/thumb_".
        $cache_sasie['Img']['img_file_name'],array("border"=>"0",'class'=>'img_sashie img_center'));
    }
    echo nl2br(h($cache_data['Mondai']['content']));
    echo "<div class=\"r align_r font14\">\n";
    echo $this->Html->df(h($cache_data['Mondai']['created']))."\n";
    echo "<br />";
    if ($cache_data['Mondai']['genre'] == 1) {
        echo "【ウミガメのスープ】";
    } elseif ($cache_data['Mondai']['genre'] == 2) {
        echo "【20の扉】";
    } elseif ($cache_data['Mondai']['genre'] == 3) {
        echo "【亀夫君問題】";
    } elseif ($cache_data['Mondai']['genre'] == 4) {
        echo "【新・形式】";
    }
    if (!empty($cache_data['Mondai']['stime'])){
        switch ($cache_data['Mondai']['stime']) {
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
    if (!empty($cache_data['Mondai']['scount'])){
        echo "【質問制限：" . $cache_data['Mondai']['scount'] . "回まで】";
    }
    if ($cache_data['Mondai']['yami'] == 2){
            echo "【闇スープ】";
    }
    if(!empty($cache_data['User']['name'])){
        //一時名無し
        if ($cache_data['Mondai']['itijinanashi'] == 2) {
            echo "<b>[名無しますか？]</b>";
        } else {
            echo "        <b>[<a href='" . $this->Html->url('/mondai/profile/'.$cache_data['User']['id'])."'>".h($cache_data['User']['name'])."</a>]</b>\n";
            if (!empty($cache_data['User']['degree'])){
                echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $cache_data['User']['degreeid']) . "'>[" .  h($cache_data['User']['degree']) . "]</a>";
            }
        }
    } else {
        echo "        <b>不明</b>\n";
    }
    echo "</div>\n";
    echo "<div class=\"clear\"></div>\n";
    if (!empty($cache_data['Mondai']['comment'])){
            echo "<div class=\"clear\"></div>\n";
            echo "<div class=\"hukidasi r hukidasi-hitokoto\">\n";
                echo "<div class=\"f-rh\">\n";
                    echo $this->Html->image("f-rh.png",array('class'=>'img-responsive'));
                echo "</div>\n";
                echo "<div class=\"hukidasi_box clearfix\">\n";
                    echo "<p class=\"align_r\">\n";
                        echo "<b>".h($cache_data['Mondai']['comment'])."</b>";
                    echo "</p>";
                echo "</div>\n";
            echo "</div>\n";
    }
echo "</div>\n";
    if (!empty($data)){
        //タグ
        echo "<div id=\"edit_tag\">";
            for($ta = 0;$ta < count($cache_tags);$ta++){
                $arr = $cache_tags[$ta]['Tag'];
                echo "<a href='" . $this->Html->url('/mondai/tag/' . urlencode($arr['name'])) . "'>" . h($arr['name']) . "</a>";
                echo "　";
            }
            if(!empty(AuthComponent::user('id'))){
                echo "<button>タグ編集</button>";
            }
        echo "</div>";
        echo "<div class=\"clear\"></div>\n";
        //質問一覧
        $d = 0;
        $kara = null;
        $zero = '0';

        if (AuthComponent::user('id') == $cache_data['User']['id']){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
        }
        $co = 0;
        $adco = 0;
        echo "<div class=\"situmon_wrap\">";
        for($i = 0;$i < count($cache_data2);$i++){
            if ($cache_data['Mondai']['scount'] > 0){
                $cache_data['Mondai']['scount']--;
            }
            $d++;
            $arr = $cache_data2[$i]['Resq'];

            //闇スープ and 自分の投稿じゃない and 未解決 or 出題者じゃない
            if (
                    $cache_data['Mondai']['yami'] != 2
                    or
                    $cache_data['Mondai']['seikai'] != 1
                    or
                    AuthComponent::user('id') == $cache_data['User']['id']
                    or
                    AuthComponent::user('id') == $cache_data2[$i]['User']['id']
                ) {

                //質問の名前・時刻
                echo "<span class=\"name name-l\"><b>No.".h($d)."</b>[<a href='" .
                $this->Html->url('/mondai/profile/'.$cache_data2[$i]['User']['id'])."'>".
                h($cache_data2[$i]['User']['name'])."</a>]".$this->Html->mdhi(h($arr['created']));
                echo "</span>";
                //回答の名前・時刻
                echo "<span class=\"name align_r name-r\">";
                if (!empty($arr['ansflg'])){
                    echo $this->Html->mdhi(h($arr['modified']));
                } else {
                    echo "未回答";
                }
                echo "</span>";


                echo "<div class=\"clearfix\">\n";
                echo "<div class=\"mobile_clearfix\">\n";
                echo "<div class=\"hukidasi l\">\n";
                echo "<div class=\"f\">\n";
                echo $this->Html->image("f.png",array('class'=>'img-responsive'));
                echo "</div>\n";
                echo "<div class=\"hukidasi_box clearfix\">\n";

                echo "\n";
                echo "<p class=\"align_l\">";
                if ($arr['editq'] == 1){
                    echo "            <span>\n";
                    if ($arr['nice'] == 1 or $arr['fa'] == 1){
                        //フォント大きさ
                        echo "<span class=\"goodques\"><b>";
                    }
                    if ($arr['textq'] != 1){
                        echo "                ".h($arr['ediqcont'])."\n";
                    } else {
                        echo "                ".nl2br(h($arr['ediqcont']))."\n";
                    }
                    if ($arr['nice'] == 1 or $arr['fa'] == 1){
                        //フォント大きさ
                        echo "</b></span>";
                    }
                    echo "            </span>\n";
                    echo "            <Font Color=\"#AC965A\">[編集済]</Font>\n";
                    if ($cache_data['Mondai']['scount'] > 0){
                        echo "<b><Font Color=\"#ff0000\">[後" . $cache_data['Mondai']['scount'] . "回]</Font></b>";
                    } elseif ($cache_data['Mondai']['scount'] == $zero){
                        echo "<b>[質問締切り]</b>";
                    }
                } else {
                    echo "            <span>\n";
                    if ($arr['nice'] == 1 or $arr['fa'] == 1){
                        //フォント大きさ
                        echo "<span class=\"goodques\"><b>";
                    }
                    if ($arr['textq'] != 1){
                        echo "                ".h($arr['content'])."\n";
                    } else {
                        echo "                ".nl2br(h($arr['content']))."\n";
                    }
                    if ($cache_data['Mondai']['scount'] > 0){
                        echo "<b><Font Color=\"#ff0000\">[後" . $cache_data['Mondai']['scount'] . "回]</Font></b>";
                    } elseif ($cache_data['Mondai']['scount'] == $zero){
                        echo "<b>[質問締切り]</b>";
                    }
                    if ($arr['nice'] == 1 or $arr['fa'] == 1){
                        //フォント大きさ
                        echo "</b></span>";
                    }
                    echo "            </span>\n";
                }
                //質問編集リンク
                if (empty($arr['answer'])){
                    if ($cache_data['Mondai']['seikai'] == 1){
                        if ($cache_data2[$i]['User']['id'] == AuthComponent::user('id')){
                            echo "        <a href=\"" . $this->Html->url('/mondai/edit/' . h($arr['id'])) . "\">編集</a>\n";
                        }
                    }
                }
                echo "</p>\n";
                echo "</div>\n";
                echo "</div>\n";
                echo "</div>\n";
                //回答内容
                echo "<div class=\"mobile_clearfix\">\n";
                echo "<div class=\"hukidasi r hukidasi-r\">\n";
                echo "<div class=\"f-r\">\n";
                echo $this->Html->image("f-r.png",array('class'=>'img-responsive'));
                echo "</div>\n";

                echo "<div class=\"hukidasi_box clearfix\">\n";
                echo "<p class=\"align_l\">";
                if (!empty($arr['ansflg'])){
                    if ($arr['edita'] == 1){
                        if ($arr['nice'] == 1 or $arr['fa'] == 1){
                            //フォント大きさ
                            echo "<span class=\"goodques\"><b>";
                        }
                        echo "            ".nl2br(h($arr['ediacont']))."\n";
                        if ($arr['nice'] == 1 or $arr['fa'] == 1){
                            //フォント大きさ
                            echo "</b></span>";
                        }
                        echo "<Font Color=\"#AC965A\">[編集済]</Font>\n";
                    } else {
                        if ($arr['nice'] == 1 or $arr['fa'] == 1){
                            //フォント大きさ
                            echo "<span class=\"goodques\"><b>";
                        }
                        echo "            ".nl2br(h($arr['answer']))."\n";
                        if ($arr['nice'] == 1 or $arr['fa'] == 1){
                            //フォント大きさ
                            echo "</b></span>";
                        }
                    }
                    if ($arr['fa'] == 1){
                        echo "<Font Color=\"#ff0000\">[正解]</Font>";
                    }
                    if ($arr['nice'] == 1){
                        echo "<Font Color=\"#ff0000\">[良い質問]</Font>";
                    }
                    if (AuthComponent::user('id') == $cache_data['User']['id']){
                        echo "            <input type=\"hidden\" name=\"data[" . $co .
                        "][Resq][id]\" value=\"" .$arr['id']  . "\" id=\"ResqId\" /> \n";
                        if ($arr['fa'] != 1){
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][fa]\" value=\"1\" id=\"ResqFa\" />正解表示\n";
                        } elseif($arr['fa'] == 1) {
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][fa]\" value=\"0\" id=\"ResqFa\" />正解解除\n";
                        }
                        if ($arr['nice'] != 1){
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][nice]\" value=\"1\" id=\"ResqNice\" />良質問表示\n";
                        } elseif($arr['nice'] == 1) {
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][nice]\" value=\"0\" id=\"ResqNice\" />良質問解除\n";
                        }
                    }
                    //回答編集リンク
                    if ($cache_data['Mondai']['seikai'] == 1){
                        if ($cache_data['User']['id'] == AuthComponent::user('id')){
                            echo "<a href=\"" . $this->Html->url('/mondai/edit/' . h($arr['id'])) . "\">編集</a>\n";
                        }
                    }
                } else {
                    if (AuthComponent::user('id') == $cache_data['User']['id']){
                        echo "            <input type=\"hidden\" name=\"data[" . $co .
                        "][Resq][id]\" value=\"" .$arr['id']  . "\" id=\"ResqId\" /> \n";
                        echo $this->Form->error('Resq.radio');
                        if ($cache_data['Mondai']['genre'] == 4){
                            echo "            "."<textarea name=\"data[" . $co .
                            "][Resq][answer]\" cols=\"40\" rows=\"5\" id=\"ResqAnswe\" ></textarea>\n";
                        } else {
                            echo "            "."<input name=\"data[" . $co .
                            "][Resq][answer]\" type=\"text\" id=\"ResqAnswe\" />\n";
                        }
                        echo $this->Form->error('Resq.answer');
                        if ($arr['fa'] != 1){
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][fa]\" value=\"1\" id=\"ResqFa\" />正解表示\n";
                        } elseif($arr['fa'] == 1) {
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][fa]\" value=\"0\" id=\"ResqFa\" />正解解除\n";
                        }
                        if ($arr['nice'] != 1){
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][nice]\" value=\"1\" id=\"ResqNice\" />良質問表示\n";
                        } elseif($arr['nice'] == 1) {
                            echo "<input type=\"checkbox\" name=\"data[" . $co .
                            "][Resq][nice]\" value=\"0\" id=\"ResqNice\" />良質問解除\n";
                        }
                    } else {
                        echo "<Font Color=\"#AC965A\">回答はまだです。</Font>\n";
                    }
                }
                $co++;
                echo "</p>\n";
                echo "</div>\n";

                echo "</div>\n";
                echo "</div>\n";
                echo "</div>\n";
            }
            //ヒント内容
            for($ii = 0;$ii < count($cache_data3);$ii++){
                if ($cache_data3[$ii]['Chat']['i'] == $i){
                    if (empty($cache_data3[$ii]['Chat']['kaitou'])){
                        //ヒント表示
                        echo "<div class=\"border align_c margin_t30\">\n";
                        if (!empty($cache_data3[$ii]['Chat']['admin'])){
                            switch ($cache_data3[$ii]['Chat']['admin']) {
                                case '1':
                                    echo "<Font Color=\"#AC965A\">削除されました。【他者の権利やプライバシーを侵害する物】</Font>";
                                    break;
                                case '2':
                                    echo "<Font Color=\"#AC965A\">削除されました。【有害なプログラム・スクリプト等を含む物】</Font>";
                                    break;
                                case '3':
                                    echo "<Font Color=\"#AC965A\">削除されました。【宣伝だけが目的の物】</Font>";
                                    break;
                                case '4':
                                    echo "<Font Color=\"#AC965A\">削除されました。【その他、管理人が不適当と判断した物】</Font>";
                                    break;
                            }
                        } else {
                            if ($cache_data3[$ii]['Chat']['edit'] == 1){
                            echo nl2br(h($cache_data3[$ii]['Chat']['editcont']));
                                echo "<Font Color=\"#AC965A\">[編集済]</Font>\n";
                            } else {
                            echo nl2br(h($cache_data3[$ii]['Chat']['hint']));
                            }
                        }
                        //ヒント編集リンク
                        if (empty($cache_data3[$ii]['Chat']['admin'])){
                            if (empty($cache_data3[$ii]['Chat']['answer'])){
                                if ($cache_data['Mondai']['seikai'] == 1){
                                    if ($cache_data3[$ii]['User']['id'] == AuthComponent::user('id')){
                                        echo "<a href=\"" . $this->Html->url('/mondai/hintedit/' .
                                        h($cache_data3[$ii]['Chat']['id'])) . "\">編集</a>\n";
                                    }
                                }
                            }
                        }
                        echo "</div>\n";
                        echo "<div class=\"clear\"></div>\n";
                    }
                }
            }
            echo "<div class=\"clear\"></div>\n";
        }
        echo "</div>\n";
        if (AuthComponent::user('id') == $cache_data['User']['id']){
            echo "            ".$this->Form->submit("すべての質問に一括回答する")."\n";
            echo "        ".$this->Form->end()."\n";
        }

        //解答フォームと表示
        if ($cache_data['Mondai']['seikai'] != 1){
            //解説box
            echo "<div class=\"box\">";
            //挿絵表示
            if (!empty($cache_sasie2['Img']['img_file_name'])){
                echo $this->Html->image("img_sashie/".$cache_sasie2['Img']['id']."/thumb_".
                $cache_sasie2['Img']['img_file_name'],array("border"=>"0",'class'=>'img_sashie img_center'));
            }

            echo nl2br(h($cache_data['Mondai']['kaisetu']));
            echo "    <div class=\"clear\"></div>\n";
            echo "    <div class=\"r align_r font14\">\n";
            echo $this->Html->df(h($cache_data['Mondai']['created']))."\n";
            if(!empty($cache_data['User']['name'])){
                echo "<b>[<a href='" . $this->Html->url('/mondai/profile/'.$cache_data['User']['id'])."'>".
                h($cache_data['User']['name'])."</a>]</b>\n";
                if (!empty($cache_data['User']['degree'])){
                    echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' .
                    $cache_data['User']['degreeid']) . "'>[" .  h($cache_data['User']['degree']) . "]</a>";
                }
            } else {
                echo "<b>不明</b>\n";
            }
            echo "    </div>\n";
            echo "    <div class=\"clear\"></div>\n";
            echo "</div>\n";
            if (!empty(AuthComponent::user('id'))){
                if ($cache_data['Mondai']['seikai'] == 2){
                    echo $this->Form->create(null,array('type'=>'post','url'=>'./show/'.$param,'onSubmit'=>'return check2()'))."\n";
                    echo $this->Form->hidden('Temple.mondai_id', array('value' => $cache_data['Mondai']['id']))."\n";
                    echo $this->Form->hidden('Temple.user_id', array('value' => $cache_data['User']['id']))."\n";
                    echo $this->Form->submit("ブックマーク", array('class'=>"bookmark", 'label'=>false))."\n";
                    echo $this->Form->end()."\n";
                    //ブックマーク
                    if (!empty($cache_data['Indextemp'][0]['count'])){
                        echo "<Font Color=\"#787878\">「" . h($cache_data['Indextemp'][0]['count']) . "ブックマーク獲得」</Font>";
                    }
                }
            }
            echo "<div class=\"clear\"></div>\n";
            if (!empty($templetajyuu[$cache_data['Mondai']['id']])){
                echo "<b>" . h($templetajyuu[$cache_data['Mondai']['id']]) . "</b>";
            }
            //ブックマーク
            echo "<div class=\"clear\"></div>\n";
        }
        //０ならカラにする
        if ($cache_data['Mondai']['scount'] == $zero){
            $cache_data['Mondai']['scount'] = 'kara';
            $kara = 'kara';
            echo "<div class=\"clear\"></div>\n";
        }

        if ($cache_data['User']['id'] != AuthComponent::user('id')){
        if ($cache_data['Mondai']['seikai'] == 1){//正解では無い場合
            if(!empty(AuthComponent::user('id'))){//ログインした場合
                if (empty($cache_data['Mondai']['stime'])){//時間制限が無い場合
                    if (!empty($cache_data['Mondai']['scount'])){//時間制限が無く、カウントがある場合
                        if($cache_data['Mondai']['scount'] != 0){
                            echo "<div class=\"border\">\n";
                            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param),'onSubmit'=>'return check4()'))."\n";
                            echo $this->Form->error('Resq.content');
                            if ($cache_data['Mondai']['textflg'] != 1){
                                echo "    ".$this->Form->text("Resq.content",array("size" => "40",'class'=>'form-text','placeholder'=>'質問文を入力してください'))."\n";
                            } else {
                                echo "    ".$this->Form->textarea("Resq.content",array("cols" => "50","rows" => "5",'placeholder'=>'質問文を入力してください'))."\n";
                                echo "    ".$this->Form->checkbox("Resq.textq",array('checked'=>false,'value'=>1))."長文にするならチェック\n";
                            }
                            echo "<div class=\"clear\"></div>\n";
                            echo "<center>".$this->Form->submit("質問する")."</center>\n";
                            echo $this->Form->end()."\n";
                            echo "</div>\n";
                        }
                    } else {//時間制限もカウントも無い場合
                        echo "<div class=\"border\">\n";
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
                        echo $this->Form->error('Resq.content');
                        if ($cache_data['Mondai']['textflg'] != 1){
                            echo "    ".$this->Form->text("Resq.content",array("size" => "40",'class'=>'form-text','placeholder'=>'質問文を入力してください'))."\n";
                        } else {
                            echo "    ".$this->Form->textarea("Resq.content",array("cols" => "50","rows" => "5",'placeholder'=>'質問文を入力してください'))."\n";
                            echo "    ".$this->Form->checkbox("Resq.textq",array('checked'=>false,'value'=>1,'placeholder'=>'質問文を入力してください'))."長文にするならチェック\n";
                        }
                        echo "<div class=\"clear\"></div>\n";
                        echo "<center>".$this->Form->submit("質問する")."</center>\n";
                        echo $this->Form->end()."\n";
                        echo "</div>\n";
                    }
                } else {//時間制限がある場合
                    if ($cache_data['Mondai']['timelog'] > date("Y-m-d H:i:s",strtotime("now"))){//時間制限内の場合
                        if (!empty($cache_data['Mondai']['scount'])){//時間制限があり、カウントがある場合
                            if($cache_data['Mondai']['scount'] != $kara){
                                echo "<div class=\"border\">\n";
                                echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param),'onSubmit'=>'return check4()'))."\n";
                                echo $this->Form->error('Resq.content');
                                if ($cache_data['Mondai']['textflg'] != 1){
                                    echo "    ".$this->Form->text("Resq.content",array("size" => "40",'class'=>'form-text','placeholder'=>'質問文を入力してください'))."\n";
                                } else {
                                    echo "    ".$this->Form->textarea("Resq.content",array("cols" => "50","rows" => "5",'placeholder'=>'質問文を入力してください'))."\n";
                                    echo "    ".$this->Form->checkbox("Resq.textq",array('checked'=>false,'value'=>1))."長文にするならチェック\n";
                                }
                                echo "<div class=\"clear\"></div>\n";
                                echo "<center>".$this->Form->submit("質問する")."</center>\n";
                                echo $this->Form->end()."\n";
                                echo "</div>\n";
                            }
                        } else {//時間制限があり、カウントが無い場合
                            echo "<div class=\"border\">\n";
                            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
                            echo $this->Form->error('Resq.content');
                            if ($cache_data['Mondai']['textflg'] != 1){
                                echo "    ".$this->Form->text("Resq.content",array("size" => "40",'class'=>'form-text','placeholder'=>'質問文を入力してください'))."\n";
                            } else {
                                echo "    ".$this->Form->textarea("Resq.content",array("cols" => "50","rows" => "5",'placeholder'=>'質問文を入力してください'))."\n";
                                echo "    ".$this->Form->checkbox("Resq.textq",array('checked'=>false,'value'=>1))."長文にするならチェック\n";
                            }
                            echo "<div class=\"clear\"></div>\n";
                            echo "<center>".$this->Form->submit("質問する")."</center>\n";
                            echo $this->Form->end()."\n";
                            echo "</div>\n";
                        }
                    } else {//時間制限外の場合
                        echo "時間制限を超えました。<br />\n";
                    }
                }
            } else {
                echo "ゲストの方は質問できません、ログインまたは登録してください。<br />\n";
            }
        }
        }
        if (!empty($cache_data['Mondai']['scount'])){
            if($cache_data['Mondai']['scount'] != 0){
                echo "<center><span class=\"bigfont\"><b><Font Color=\"#ff0000\">質問数制限</Font>があります。相談しながら質問をしていきましょう。</b></Font></center>";
            }
        }
    }


    ?>
    <DIV id="myCwww"></DIV>
    <SCRIPT language="JavaScript"><!--
    function myCountd(){
        myHyouji = 1;            //0で秒数、1で日数含む形式
    <?php $mmm = $this->Html->mmm($cache_data['Mondai']['timelog']);?>
        mySetname = "<span class=\"big red\"><b>";        //目標時間の名称
        mySetyear = <?php echo $this->Html->yyy($cache_data['Mondai']['timelog']);?>;        //目標年
        mySetmon = <?php echo $this->Html->mmm($cache_data['Mondai']['timelog']);?>;            //目標月
        mySetday = <?php echo $this->Html->ddd($cache_data['Mondai']['timelog']);?>;            //目標日
        mySethour = <?php echo $this->Html->hhh($cache_data['Mondai']['timelog']);?>;            //目標時
        mySetmin = <?php echo $this->Html->iii($cache_data['Mondai']['timelog']);?>;            //目標分
        mySetsec = <?php echo $this->Html->sss($cache_data['Mondai']['timelog']);?>;            //目標秒

        myTime = new Date();
        mySettime = new Date(mySetyear,mySetmon - 1,mySetday,mySethour,mySetmin,mySetsec);
        myTimeth = (Math.floor( ( myTime.getTime() - mySettime.getTime() ) / 1000) ) * -1;

        if (myTimeth > -1) {
            if (myHyouji == 1) {
                var myWarid = 0;
                var myWarih = 0;
                var myWarim = 0;
                if (myTimeth > 86399) {
                    myWarid = myTimeth / 86400;
                    myWarid = Math.floor(myWarid);
                    myTimeth = myTimeth - (86400 * myWarid);
                }
                if (myTimeth > 3599) {
                    myWarih = myTimeth / 3600;
                    myWarih = Math.floor(myWarih);
                    myTimeth = myTimeth - (3600 * myWarih);
                }
                if (myTimeth > 59) {
                    myWarim = myTimeth / 60;
                    myWarim = Math.floor(myWarim);
                    myTimeth = myTimeth - (60 * myWarim);
                }
                if ((myWarid == 0) && (myWarih == 0) && (myWarim == 0)) {
                    myTimeth = "<Font Size=\"7\">" + myTimeth + "秒</Font>";
                } else if((myWarid == 0) && (myWarih == 0)){
                    myTimeth = myWarim + "分" + myTimeth + "秒";
                } else if(myWarid == 0){
                    myTimeth = myWarih + "時間" + myWarim + "分" + myTimeth + "秒";
                } else {
                    myTimeth = myWarid + "日" + myWarih + "時間" + myWarim + "分" + myTimeth + "秒";
                }
            }
            document.getElementById("myCwww").innerHTML = mySetname + "" + myTimeth + "</b></span>";
        }
    }
    setInterval("myCountd()", 1000);
    // --></SCRIPT>
    <?php
    if (!empty($cache_data['Mondai']['stime'])){
        echo "(海外だと時間が変わるみたいです。)";
    }

    echo "<div class=\"clear\"></div>\n";
    //相談for
    if (!empty($data)){
        echo "<div class=\"scroll small\">\n";
        echo "<table class=\"soudan_table\">\n";
        echo "<tr bgcolor=\"#D4BD81\"><th colspan=\"3\" class=\"mondai\">相談チャットです。この問題に関する事を書き込みましょう。</th></tr>\n";
        for($so = 0;$so < count($cache_data4);$so++){
            $arr2 = $cache_data4[$so]['Soudan'];
            if (!empty($arr2['content'])){
                if ($arr2['secret'] == 1){
                    if (AuthComponent::user('id') == $cache_data['User']['id'] or
                    $cache_data4[$so]['User']['id'] == AuthComponent::user('id') or AuthComponent::user('flg') == 3){
                        echo "<tr>\n";
                        echo "<td><font color=\"#bfbfbf\">\n";
                        if ($arr2['nanashiflg'] == 1){
                            echo "<Font Color=\"#0080ff\">名無しさん</Font>";
                        } else {
                            //一時名無し
                            if ($cache_data['Mondai']['itijinanashi'] == 2 and $cache_data4[$so]['User']['id'] == $cache_data['User']['id']) {
                                echo "<b>[名無しますか？]</b>";
                            } else {
                                echo "<a href='" . $this->Html->url('/mondai/profile/' . $cache_data4[$so]['User']['id']) . "'>" .
                                h($cache_data4[$so]['User']['name']) . "</a>";
                                if (!empty($cache_data4[$so]['User']['degree'])){
                                    echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' .
                                    $cache_data4[$so]['User']['degreeid']) . "'>[" .  h($cache_data4[$so]['User']['degree']) . "]</a>";
                                }
                            }
                        }
                        echo "＞＞</font>";
                        if ($arr2['edit'] == 1){
                            echo "<Font Color=\"#6666ff\">" . nl2br(h($arr2['editcont'])) . "[出題者のみに表示]</Font>";
                            echo "<Font Color=\"#AC965A\">[編集済]</Font>\n";
                        } else {
                            echo "<Font Color=\"#6666ff\">" . nl2br(h($arr2['content'])) . "[出題者のみに表示]</Font>";
                        }
                        //相談編集リンク
                        if (empty($arr2['answer'])){
                            if (!empty(AuthComponent::user('id'))){
                                if ($cache_data4[$so]['User']['id'] == AuthComponent::user('id')){
                                    echo "<a href=\"" . $this->Html->url('/mondai/soudanedit/') . "" . h($arr2['id']) . "\">編集</a>\n";
                                }
                            }
                        }
                        echo "[".$this->Html->dft(h($arr2['created']))."]\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                } else {
                    echo "<tr>\n";
                    echo "<td><font color=\"#bfbfbf\">\n";
                    if ($arr2['nanashiflg'] == 1){
                        echo "<Font Color=\"#0080ff\">名無しさん</Font>";
                    } else {
                        //一時名無し
                        if ($cache_data['Mondai']['itijinanashi'] == 2 and $cache_data4[$so]['User']['id'] == $cache_data['User']['id']) {
                            echo "<b>[名無しますか？]</b>";
                        } else {
                            echo "<a href='" . $this->Html->url('/mondai/profile/' . $cache_data4[$so]['User']['id']) . "'>" . h($cache_data4[$so]['User']['name']) . "</a>";
                            if (!empty($cache_data4[$so]['User']['degree'])){
                                echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' .
                                $cache_data4[$so]['User']['degreeid']) . "'>[" .  h($cache_data4[$so]['User']['degree']) . "]</a>";
                            }
                        }
                    }
                    echo "＞＞</font>";
                    if ($arr2['edit'] == 1){
                        echo nl2br(h($arr2['editcont']));
                        echo "<Font Color=\"#AC965A\">[編集済]</Font>\n";
                    } else {
                        echo nl2br(h($arr2['content']));
                    }
                    //相談編集リンク
                    if (empty($arr2['answer'])){
                        if (!empty(AuthComponent::user('id'))){
                            if ($cache_data4[$so]['User']['id'] == AuthComponent::user('id')){
                                echo "        <a href=\"" . $this->Html->url('/mondai/soudanedit/') . "" . h($arr2['id']) . "\">編集</a>\n";
                            }
                        }
                    }
                    echo "<font color=\"#bfbfbf\">[".$this->Html->dft(h($arr2['created']))."]</font>\n";
                    echo "</td>\n";
                    echo "</tr>\n";
                }
            }
        }
        echo "    </table>\n";
        echo "</div>\n";

        //相談発言
        if(!empty(AuthComponent::user('id'))){
            echo "<div class=\"border\">\n";
            echo "    ".$this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
            echo "        ".$this->Form->text("Soudan.content",array("size" => "39",'class'=>'form-text','placeholder'=>'相談チャット'))."<br />\n";
            echo $this->Form->error('Soudan.content');
            echo "<div class=\"r\">　出題者のみに見せたい場合にチェック".$this->Form->checkbox("Soudan.secret",array('checked'=>false,'value'=>1))."</div>\n";
            if ($cache_data['Mondai']['nanashi'] == 2){
                echo "<div class=\"r\">　名前非表示" . $this->Form->checkbox("Soudan.nanashiflg",array('checked'=>false)) . "</div>\n";
            }
            echo "<div class=\"clear\"></div>\n";
            echo "<center>".$this->Form->submit("発言")."</center>\n";
            echo "    ".$this->Form->end()."\n";
            echo "</div>\n";
        } else {
            echo "    ゲストの方は発言できません、ログインまたは登録してください。<br />\n";
        }
        echo "<div class=\"clear\"></div>\n";
    }

    //まとメモ帳表示
    if (!empty($data)){
        if (!empty($cache_data['Mondai']['summary'])){
            //解説box
            echo "<div class=\"box\">";
            echo nl2br(h($cache_data['Mondai']['summary']));
            echo "</div>\n";
        }
    }

    //問題前後リンク
    if(!empty($cache_neighbors['next']['Mondai'])){
        echo "<div class=\"big l margin_t50\">";
        echo "<a href=\"".$this->Html->url('/mondai/show/'.$cache_neighbors['next']['Mondai']['id'])."\">";
        if (mb_strlen(h($cache_neighbors['next']['Mondai']['title'])) > 15) {
            echo "＜＜「".nl2br(mb_substr(h($cache_neighbors['next']['Mondai']['title']), 0, 15, "UTF-8")) . "...」</a>";
        } else {
            echo "＜＜「".$cache_neighbors['next']['Mondai']['title']."」</a>";
        }
        echo "</div>";
    }
    if(!empty($cache_neighbors['prev']['Mondai'])){
        echo "<div class=\"big r margin_t50\">";
        echo "<a href=\"".$this->Html->url('/mondai/show/'.$cache_neighbors['prev']['Mondai']['id'])."\">";
        if (mb_strlen(h($cache_neighbors['prev']['Mondai']['title'])) > 15) {
            echo "「".nl2br(mb_substr(h($cache_neighbors['prev']['Mondai']['title']), 0, 15, "UTF-8")) . "...」＞＞</a>";
        } else {
            echo "「".$cache_neighbors['prev']['Mondai']['title']."」＞＞</a>";
        }
        echo "</div>";
    }
    echo "<div class=\"clear\"></div>\n";

        //------------------------------出題者画面------------------------------//
        if (!empty(AuthComponent::user('id'))){
            if (AuthComponent::user('id') == $cache_data['User']['id']){
                echo "<div class=\"box syutugamen\">";
                echo "<span class=\"bigfont\">出題者画面</Font><br />";
                    //まとメモ帳フォーム
                    echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
                    echo $this->Form->input('id', array('type'=>'hidden'))."\n";
                    echo "    ".$this->Form->textarea("Mondai.summary",array("cols" => "40","rows" => "5",'placeholder'=>'まとメモコメント欄'))."\n";
                    echo $this->Form->error('Mondai.summary');
                    echo "    ".$this->Form->submit("まとメモ帳を出す",array('div'=>false))."\n";
                    echo $this->Form->end()."\n";
                    //ヒントを出す
                    if ($cache_data['Mondai']['seikai'] == 1){
                        echo "    ".$this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
                        echo "        ".$this->Form->hidden("Chat.tuuka",array("value" => "tuuka"))."\n";
                        echo "        ".$this->Form->hidden("Chat.i",array("value" => $i-1))."\n";
                        echo "        ".$this->Form->textarea("Chat.hint",array("cols" => "40","rows" => "5",'placeholder'=>'ヒント欄'))."\n";
                        echo $this->Form->error('Chat.hint');
                        echo "        ".$this->Form->submit("ヒントを出す",array('div'=>false))."\n";
                        echo "    ".$this->Form->end()."\n";
                    }
                    //一言コメント、非公開設定、グロ注意の３つ
                    echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                    echo $this->Form->text("Mondai.comment",array("size" => "40",'placeholder'=>'一言コメント欄','class'=>'formjquery'))."\n";
                    echo $this->Form->hidden('Mondai.idc', array('value' => $cache_data['Mondai']['id']))."\n";
                    echo $this->Form->submit("一言コメント",array('div'=>false))."\n";
                    echo $this->Form->error('Mondai.comment');
                    echo $this->Form->end()."\n";
                    //長文変更
                    if ($cache_data['Mondai']['seikai'] == 1){
                        if ($cache_data['Mondai']['textflg'] == 0){
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden("Mondai.textflg",array('value'=>false,'value'=>2))."\n";
                            echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                            echo $this->Form->submit("長文許可する",array('div'=>false))."\n";
                            echo $this->Form->end()."\n";
                        } else {
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden("Mondai.textflg",array('value'=>false,'value'=>1))."\n";
                            echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                            echo $this->Form->submit("長文許可しない",array('div'=>false))."\n";
                            echo $this->Form->end()."\n";
                        }
                    }
                    //非公開送信
                    $resco = count($data2);
                    //問題解決したかどうか
                    if ($cache_data['Mondai']['seikai'] == 1){
                        //ウミガメかつ、質問が０かどうか。
                        if($resco == 0 and $cache_data['Mondai']['genre'] == 1){
                            if ($cache_data['Mondai']['delete'] == 1){
                                echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                                echo $this->Form->hidden("Mondai.delete",array('value'=>false,'value'=>2))."\n";
                                echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                                echo $this->Form->submit("非公開にする",array('div'=>false))."\n";
                                echo $this->Form->end()."\n";
                            } elseif ($cache_data['Mondai']['delete'] == 2 and $cache_data['Mondai']['delete'] != 3){
                                echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                                echo $this->Form->hidden("Mondai.delete",array('value'=>false,'value'=>1))."\n";
                                echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                                echo $this->Form->submit("公開する",array('div'=>false))."\n";
                                echo $this->Form->end()."\n";
                            }
                        }
                    } else {
                        if ($cache_data['Mondai']['delete'] == 1){
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden("Mondai.delete",array('value'=>false,'value'=>2))."\n";
                            echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                            echo $this->Form->submit("非公開にする",array('div'=>false))."\n";
                            echo $this->Form->end()."\n";
                        } elseif ($cache_data['Mondai']['delete'] == 2 and $cache_data['Mondai']['delete'] != 3){
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden("Mondai.delete",array('value'=>false,'value'=>1))."\n";
                            echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                            echo $this->Form->submit("公開する",array('div'=>false))."\n";
                            echo $this->Form->end()."\n";
                        }
                    }
                    //問題文の挿絵追加
                    if (!empty($imgerror)){
                        echo $imgerror;
                    }
                    if (empty($cache_sasie['Img']['id'])){
                        if ($cache_data['User']['id'] == AuthComponent::user('id')){
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden('Img.flg', array('value' => 1))."\n";
                            echo $this->Form->hidden('Img.mondai_id', array('value' => h($param)))."\n";
                            echo $this->Form->file('Img.img');
                            echo $this->Form->error('Img.img');
                            echo $this->Form->submit("問題文に挿絵をつける(1MBまで)",array('div'=>false));
                            echo $this->Form->end();
                        }
                    } else {
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param),'onSubmit'=>'return sashie1()'));
                        echo $this->Form->hidden('Img.id', array('value' => $cache_sasie['Img']['id']))."\n";
                        echo $this->Form->hidden('Img.mondai_id', array('value' => h($param)))."\n";
                        echo $this->Form->hidden('Img.img_file_name', array('value' => $cache_sasie['Img']['img_file_name']))."\n";
                        echo $this->Form->hidden('Img.delete', array('value' => 1))."\n";
                        echo $this->Form->submit("問題文の挿絵削除",array('div'=>false));
                        echo $this->Form->end();
                    }
                    //解説の挿絵追加
                    if (!empty($imgerror)){
                        echo $imgerror;
                    }
                    if (empty($cache_sasie2['Img']['id'])){
                        if ($cache_data['User']['id'] == AuthComponent::user('id')){
                            echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                            echo $this->Form->hidden('Img.flg', array('value' => 2))."\n";
                            echo $this->Form->hidden('Img.mondai_id', array('value' => h($param)))."\n";
                            echo $this->Form->file('Img.img');
                            echo $this->Form->submit("解説に挿絵をつける(1MBまで)",array('div'=>false));
                            echo $this->Form->end();
                        }
                    } else {
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param),'onSubmit'=>'return sashie2()'));
                        echo $this->Form->hidden('Img.id', array('value' => $cache_sasie2['Img']['id']))."\n";
                        echo $this->Form->hidden('Img.mondai_id', array('value' => h($param)))."\n";
                        echo $this->Form->hidden('Img.img_file_name', array('value' => $cache_sasie2['Img']['img_file_name']))."\n";
                        echo $this->Form->hidden('Img.delete', array('value' => 1))."\n";
                        echo $this->Form->submit("解説の挿絵削除",array('div'=>false));
                        echo $this->Form->end();
                    }

                    if ($cache_data['Mondai']['yami'] != 2){
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param),'onSubmit'=>'return yami()'));
                        echo $this->Form->hidden("Mondai.yami",array('value'=>false,'value'=>2))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("闇スープにする",array('div'=>false))."\n";
                        echo $this->Form->end()."";
                    } else {
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param),'onSubmit'=>'return yami()'));
                        echo $this->Form->hidden("Mondai.yami",array('value'=>false,'value'=>1))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("闇スープにしない",array('div'=>false))."\n";
                        echo $this->Form->end()."\n";
                    }
                    if ($cache_data['Mondai']['itijinanashi'] != 2){
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                        echo $this->Form->hidden("Mondai.itijinanashi",array('value'=>false,'value'=>2))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("名前を解説まで非表示にする",array('div'=>false))."\n";
                        echo $this->Form->end()."\n";
                    } else {
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                        echo $this->Form->hidden("Mondai.itijinanashi",array('value'=>false,'value'=>1))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("名前を表示する",array('div'=>false))."\n";
                        echo $this->Form->end()."\n";
                    }
                    if ($cache_data['Mondai']['nanashi'] != 2){
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                        echo $this->Form->hidden("Mondai.nanashi",array('value'=>false,'value'=>2))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("名無し発言許可する",array('div'=>false))."\n";
                        echo $this->Form->end()."\n";
                    } else {
                        echo $this->Form->create(null,array('type'=>'file','url'=>'./show/'.h($param)));
                        echo $this->Form->hidden("Mondai.nanashi",array('value'=>false,'value'=>1))."\n";
                        echo $this->Form->hidden('Mondai.idh', array('value' => $cache_data['Mondai']['id']))."\n";
                        echo $this->Form->submit("名無し発言許可しない",array('div'=>false))."\n";
                        echo $this->Form->end()."\n";
                    }
                    //現在回答中オン
                    if ($cache_data['Mondai']['seikai'] == 1){
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)));
                        echo $this->Form->hidden("Mondai.realtime",array("value" => "1"))."\n";
                        echo $this->Form->submit("10分間「現在回答中」を出す。",array('div'=>false))."\n";
                        echo "    ".$this->Form->end()."\n";
                    }
                //解答フォーム
                if ($cache_data['Mondai']['seikai'] == 1){
                    echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param)))."\n";
                    echo "    ".$this->Form->hidden("Mondai.id",array("value" => $cache_data['Mondai']['id']))."\n";
                    echo "    ".$this->Form->textarea("Mondai.kaisetu",array("cols" => "50","rows" => "5"))."\n";
                    echo $this->Form->error('Mondai.kaisetu');
                    echo $this->Form->submit("解説文を編集",array('div'=>false))."\n";
                    echo $this->Form->end()."\n";
                }
                //解説の締切り
                echo "    <div class=\"r\">\n";
                if ($cache_data['Mondai']['seikai'] == 1){
                    echo "(<b>注意:質問が締め切られます！</b>)\n";
                    echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h($param),'onSubmit'=>'return check()'))."\n";
                    echo "    ".$this->Form->hidden("Mondai.seikai",array('value'=>false,'value'=>2))."\n";
                    echo $this->Form->submit("解説文を出して問題解決",array('div'=>false))."\n";
                    echo $this->Form->end()."\n";
                }
                echo "</div>\n";
                echo "    <div class=\"clear\"></div>\n";
                echo "</div>\n";

                //解説boxの一時的表示
                if ($cache_data['Mondai']['seikai'] == 1){
                    echo "<h2>解説確認画面(出題者にのみ表示)</h2>";
                    //解説box
                    echo "<div class=\"box usui\">";
                    //挿絵表示
                    if (!empty($cache_sasie2['Img']['img_file_name'])){
                        echo $this->Html->image("img_sashie/".$cache_sasie2['Img']['id']."/thumb_".
                        $cache_sasie2['Img']['img_file_name'],array("border"=>"0",'align'=>'left','class'=>'img_sashie'));
                    }
                    //独自タグ
                    echo nl2br(h($cache_data['Mondai']['kaisetu']));
                    echo "    <div class=\"clear\"></div>\n";
                    echo "</div>\n";
                    if (!empty(AuthComponent::user('id'))){
                        if ($cache_data['Mondai']['seikai'] == 2){
                            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/'.$param,'onSubmit'=>'return check2()'))."\n";
                            echo $this->Form->hidden('Temple.mondai_id', array('value' => $cache_data['Mondai']['id']))."\n";
                            echo $this->Form->hidden('Temple.user_id', array('value' => $cache_data['User']['id']))."\n";
                            if (!empty($templetajyuu[$cache_data['Mondai']['id']])){
                                echo "<b>" . h($templetajyuu[$cache_data['Mondai']['id']]) . "</b>";
                            }
                            echo $this->Form->submit("", array('class'=>"temple", 'label'=>false))."\n";
                            echo $this->Form->end()."\n";
                            //ブックマーク
                            if (!empty($cache_data['Indextemp'][0]['count'])){
                                echo "<Font Color=\"#787878\">「" . h($cache_data['Indextemp'][0]['count']) . "ブックマーク獲得」</Font>";
                            }
                        }
                    }
                    echo "<div class=\"clear\"></div>\n";
                }
            }
        }
    //非公開終わり
}
?>
