<script type="text/javascript">
    <!--
    function check(){
        if (window.confirm('退室します。よろしいですか？')){ // 確認ダイアログを表示
            return true;
        } else {
            window.alert('ごゆっくり'); // 警告ダイアログを表示
            return false;
        }
    }
    // -->
</script>
<?php
Cache::set(Array('duration' => '+10 seconds'));
if(! $data = Cache::read('cache_roomdata_'.$param)) {
    $cache_data_kari = $roomdata;
    Cache::write('cache_roomdata_'.$param, $cache_data_kari);
    $data = Cache::read('cache_roomdata_'.$param);
} else {
    $data = Cache::read('cache_roomdata_'.$param);
}

if (empty($data)){
    echo "<div class=\"black-bar margin_b50\"><h1>ルームキーが間違ってるか、ルームが存在しません。</h1></div>";
} else {
    Cache::set(Array('duration' => '+10 seconds'));
    if(! $cache_data3 = Cache::read('cache_data3_'.$param)) {
        $cache_data3_kari = $data3;
        Cache::write('cache_data3_'.$param, $cache_data3_kari);
        $cache_data3 = Cache::read('cache_data3_'.$param);
    } else {
        $cache_data3 = Cache::read('cache_data3_'.$param);
    }

    if (!empty(AuthComponent::user('id'))){
    Cache::set(Array('duration' => '+10 seconds'));
    if(! $in_flg = Cache::read('cache_in_flg_'.AuthComponent::user('id'))) {
        $cache_in_flg_kari = $in_flg_data;
        Cache::write('cache_in_flg_'.AuthComponent::user('id'), $cache_in_flg_kari);
        $in_flg = Cache::read('cache_in_flg_'.AuthComponent::user('id'));
    } else {
        $in_flg = Cache::read('cache_in_flg_'.AuthComponent::user('id'));
    }
    }

    echo "<div class=\"black-bar margin_b50\"><h1>" . h($data['Secretroom']['title']) . "</h1></div>";
    if (AuthComponent::user('id') == $data['Secretroom']['user_id']){
        if(!empty(AuthComponent::user('id'))){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
            echo "    ".$this->Form->text("Secretroom.title",array('placeholder'=>'タイトルを編集する'))."\n";
            echo "    ".$this->Form->submit("タイトルの編集")."\n";
            echo $this->Form->end()."\n";
            echo "<br />";
        }
    }
    echo "<div class=\"border background_siro inline_block r\">\n";
    echo "<div class=\"r align_l\">\n";
    echo "作成者：<b>".h($data['User']['name'])."</b><br />";
    echo "部屋名：<b>".h($data['Secretroom']['title'])."</b><br />";
    echo "ルームキー：<b>".h($data['Secretroom']['secretid'])."</b><br />";
    if(!empty(AuthComponent::user('id'))){
        echo "<br />";
        echo "<center>";
        echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
        echo $this->Form->hidden('Favorite.user_id', array('value' => AuthComponent::user('id')))."\n";
        echo $this->Form->hidden('Favorite.secretid', array('value' => h($data['Secretroom']['secretid'])))."\n";
        echo $this->Form->hidden('Favorite.title', array('value' => h($data['Secretroom']['title'])))."\n";
        echo "<input type=\"submit\" value=\"お気に入りルームに追加\" />\n";
        echo $this->Form->end()."\n";
        echo "</center>";
        if (AuthComponent::user('id') == $data['Secretroom']['user_id']){
            echo "<center>";
            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
            echo $this->Form->hidden('Secretroom.flg', array('value' => '2'))."\n";
            if ($data['Secretroom']['open'] == '2'){
                echo $this->Form->hidden('Secretroom.open', array('value' => '1'))."\n";
                echo "<input type=\"submit\" value=\"ルームを非公開に切替：現在は「公開」\" />\n";
            } else {
                echo $this->Form->hidden('Secretroom.open', array('value' => '2'))."\n";
                echo "<input type=\"submit\" value=\"ルームを公開に切替：現在は「非公開」\" />\n";
            }
            echo $this->Form->end()."\n";
            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
            if ($data['Secretroom']['editflg'] == 2){
                echo $this->Form->hidden('Secretroom.editflg', array('value' => '1'))."\n";
                echo $this->Form->submit("部屋説明を主のみ編集可に切替：現在は「誰でも」", array('div'=>false, 'label'=>false))."\n";
            } else {
                echo $this->Form->hidden('Secretroom.editflg', array('value' => '2'))."\n";
                echo $this->Form->submit("部屋説明を誰でも編集可に切替：現在は「主のみ」", array('div'=>false, 'label'=>false))."\n";
            }
            echo $this->Form->end()."\n";
                echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
            if ($data['Secretroom']['nanashiflg'] == 2){
                echo $this->Form->hidden('Secretroom.nanashiflg', array('value' => '1'))."\n";
                echo $this->Form->submit("名無し入室許可に切替：現在は「不許可」", array('div'=>false, 'label'=>false))."\n";
            } else {
                echo $this->Form->hidden('Secretroom.nanashiflg', array('value' => '2'))."\n";
                echo $this->Form->submit("名無し入室不許可に切替：現在は「許可」", array('div'=>false, 'label'=>false))."\n";
            }
            echo $this->Form->end()."\n";
            echo "</center>";
        }
    }
    echo "</div>\n";
    echo "</div>\n";
    echo nl2br(h($data['Secretroom']['content']));
    //フォーム
    if ($data['Secretroom']['editflg'] == 2 or AuthComponent::user('id') == $data['Secretroom']['user_id']){
        if(!empty(AuthComponent::user('id'))){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
            echo "    ".$this->Form->textarea("Secretroom.content",array("cols" => "50","rows" => "5"))."\n";
            echo "    ".$this->Form->submit("部屋の説明、自由欄の編集")."\n";
            echo $this->Form->end()."\n";
            echo "<br />";
        }
    }
    echo "<br /><br />";
    if (!empty($data)){
        if (empty($in_flg)){
            if(!empty(AuthComponent::user('id'))){
                echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param))))."\n";
                echo $this->Form->hidden('Secretuse.flg', array('value' => 1))."\n";
                echo "<input type=\"submit\" value=\"入室\" />\n";
                if ($data['Secretroom']['nanashiflg'] == 1){
                    echo $this->Form->checkbox("Secretuse.nanashi",array('checked'=>true)) . "名前表示\n";
                }
                echo $this->Form->end()."\n";
            }
        }
        if (!empty($in_flg)){
            if(!empty(AuthComponent::user('id'))){
                    echo "<div class=\"form\">\n";
                            echo "<div class=\"situmon-right\">\n";
                echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param)),'id'=>'new-message'))."\n";
                echo $this->Form->textarea("Secret.content",array("cols" => "50","rows" => "5",'class'=>'form-text'))."\n";
                echo $this->Form->error('Secret.content');
                echo "</div>\n";
                echo "<div class=\"situmon-right\">\n";
                echo "<input type=\"submit\" value=\"発言/更新\" class=\"big-submit\" />\n";
                echo "</div>\n";
                echo "</div>\n";
                echo $this->Form->end()."\n";
                echo "<div class=\"clear\"></div>\n";
            }
        }
        if (!empty($data3)){
            echo "<b>現在  ";
            for($i = 0;$i < count($data3);$i++){
                $arr = $data3[$i]['Secretuse'];
                if ($arr['nanashi'] == 1){
                    echo "<a href='" . $this->Html->url('/mondai/profile/' . $data3[$i]['User']['id']) . "'>" . h($data3[$i]['User']['name']) . "</a>";
                    echo "さん  ";
                } else {
                        $tripkey = trim($this->Html->angou($arr['created']),20).$data3[$i]['User']['name']; //パスワードとする文字列（# 付き）
                        $tripkey = substr($tripkey, 1);

                        $salt = substr($tripkey . 'H.', 1, 2);
                        $salt = preg_replace('/[^\.-z]/', '.', $salt);
                        $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
                        $trip = crypt($tripkey, $salt);
                        $trip = substr($trip, -10);
                        $trip = '◆' . $trip;

                        echo "名無し".$trip."さん";
                }
            }
            echo "が入室してます。</b>";
            echo "(" . $i . "人)";
        }
        echo "<br />";
    }
    echo "<div id=\"mondai-pagination\" class=\"pagination\">";
    $options = array(
        'tag'=>'span class="pagi"',
        'modulus'=>18,
        'first'=>'',
        'last'=>'',
        'separator'=>false,
    );

    echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->numbers($options,array('class'=>'page'));
    echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );

    echo "</div>";
    echo "<div class=\"clear\"></div>\n";
    echo $this->Paginator->counter(array(
        'format' => '【総発言数：%count%】'
    ));

    if (!empty($data)){
        if (!empty($in_flg)){
            if(!empty(AuthComponent::user('id'))){
                echo $this->Form->create(null,array('type'=>'post','url'=>'./show/' . h(urldecode($param)),'onSubmit'=>'return check()'))."\n";
                echo $this->Form->hidden('Secretuse.flg', array('value' => 2))."\n";
                echo "<input type=\"submit\" value=\"退室\" />\n";
                echo $this->Form->end()."\n";
            }
        }
    }

    echo "<table class=\"mondai_table\">";
    $color1 = 1;
    for($i = 0;$i < count($data2);$i++){
        if (!empty($data2[$i])){
            $arr = $data2[$i]['Secret'];
            if (!empty($arr['content'])){//発言の中身入ってるか？
                if ($arr['flg'] == 1){//入室フラグ
                } else {//flg2かnull
                    if ($color1 == 1){
                        echo "<tr class=\"kage\">";
                        $color1 = 2;
                    } else {
                        echo "<tr>";
                        $color1 = 1;
                    }
                    echo "<td>\n";
                    echo "[".$arr['id']."]";
                    echo "<b>";
                    if ($arr['nanashi'] == 1){
                        echo "<a href='" . $this->Html->url('/mondai/profile/' . $data2[$i]['User']['id']) . "'>" . h($data2[$i]['User']['name']) . "</a>";
                        if (!empty($data2[$i]['User']['degree'])){
                            echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $data2[$i]['User']['degreeid']) . "'>[" .  h($data2[$i]['User']['degree']) . "]</a>";
                        }
                    } else {
                        //日付＋名前
                        $tripkey = trim($this->Html->angou($arr['created']),20).$data2[$i]['User']['name']; //パスワードとする文字列（# 付き）
                        $tripkey = substr($tripkey, 1);//最初１文字消す

                        $salt = substr($tripkey . 'H.', 1, 2);//saltつくる、２文字になる
                        $salt = preg_replace('/[^\.-z]/', '.', $salt);
                        $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
                        $trip = crypt($tripkey, $salt);//keyは８文字、saltは２文字が有効
                        $trip = substr($trip, -10);
                        $trip = '◆' . $trip;

                        echo "名無し".$trip;
                    }
                    echo "</b>";
                    echo "<br />\n";
                    if(empty(h($arr['edit']))){
                        echo nl2br(h($arr['content']));
                    } else {
                        echo nl2br(h($arr['editcont']));
                        echo "<Font Color=\"#AC965A\">[編集済]</Font>\n";
                    }
                    echo "<br />\n";
                    echo "<Font Color=\"#bfbfbf\">[" . $this->Html->df(h($arr['created'])) . "]</Font>";

                    if ($data2[$i]['User']['id'] == AuthComponent::user('id')){
                        echo "        <a href=\"" . $this->Html->url('/secret/edit/' . h($arr['id'])) . "\">編集</a>\n";
                    }
                    echo "</td>\n";
                    echo "</tr>\n";
                }
            } else {//発言内容がカラ
                if ($arr['flg'] == 1){//入室フラグ
                    if ($color1 == 1){
                        echo "<tr class=\"kage\">";
                        $color1 = 2;
                    } else {
                        echo "<tr>";
                        $color1 = 1;
                    }
                    echo "<td>\n";
                    echo "<Font Color=\"#909090\">";
                    echo "<b>";
                    if ($arr['nanashi'] == 1){
                        echo "" . h($data2[$i]['User']['name']);
                        if (!empty($data2[$i]['User']['degree'])){
                            echo "[" .  h($data2[$i]['User']['degree']) . "]";
                        }
                    } else {
                        $tripkey = trim($this->Html->angou($arr['created']),20).$data2[$i]['User']['name']; //パスワードとする文字列（# 付き）
                        $tripkey = substr($tripkey, 1);

                        $salt = substr($tripkey . 'H.', 1, 2);
                        $salt = preg_replace('/[^\.-z]/', '.', $salt);
                        $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
                        $trip = crypt($tripkey, $salt);
                        $trip = substr($trip, -10);
                        $trip = '◆' . $trip;

                        echo "名無し".$trip;
                    }
                    echo "さんが入室しました。</Font>";
                    echo "</b>";
                    echo "<br />\n";
                    echo "<Font Color=\"#909090\">ウミガメのスープを一つください。</Font>";
                    echo "<Font Color=\"#bfbfbf\">[" . $this->Html->df(h($arr['created'])) . "]</Font>";
                    echo "</td>\n";
                    echo "</tr>\n";
                } else {//退室フラグ　flg2かnull
                if ($color1 == 1){
                    echo "<tr class=\"kage\">";
                    $color1 = 2;
                } else {
                    echo "<tr>";
                    $color1 = 1;
                }
                    echo "<td>\n";
                    echo "<b>";
                    if ($arr['hour'] == 1){//溶け
                        echo "<Font Color=\"#909090\">しばらく発言していないので";
                        if ($arr['nanashi'] == 1){
                             echo h($data2[$i]['User']['name']);
                             if (!empty($data2[$i]['User']['degree'])){
                                 echo "[" .  h($data2[$i]['User']['degree']) . "]";
                             }
                        } else {
                            $tripkey = trim($this->Html->angou($arr['created']),20).$data2[$i]['User']['name']; //パスワードとする文字列（# 付き）
                            $tripkey = substr($tripkey, 1);

                            $salt = substr($tripkey . 'H.', 1, 2);
                            $salt = preg_replace('/[^\.-z]/', '.', $salt);
                            $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
                            $trip = crypt($tripkey, $salt);
                            $trip = substr($trip, -10);
                            $trip = '◆' . $trip;

                            echo "名無し".$trip;
                        }
                        echo "さんはスープになりました。</Font>";
                    } else {
                        echo "<Font Color=\"#909090\">";
                        if ($arr['nanashi'] == 1){
                            echo h($data2[$i]['User']['name']);
                            if (!empty($data2[$i]['User']['degree'])){
                                echo "[" .  h($data2[$i]['User']['degree']) . "]";
                            }
                        } else {
                            $tripkey = trim($this->Html->angou($arr['created']),20).$data2[$i]['User']['name']; //パスワードとする文字列（# 付き）
                            $tripkey = substr($tripkey, 1);

                            $salt = substr($tripkey . 'H.', 1, 2);
                            $salt = preg_replace('/[^\.-z]/', '.', $salt);
                            $salt = strtr($salt, ':;<=>?@[\\]^_`', 'ABCDEFGabcdef');
                            $trip = crypt($tripkey, $salt);
                            $trip = substr($trip, -10);
                            $trip = '◆' . $trip;

                            echo "名無し".$trip;
                        }
                        echo "さんは勘定を済ませ、帰宅した。</Font>";
                    }
                    echo "</b>";
                    echo "<br />\n";
                    echo "<Font Color=\"#bfbfbf\">[" . $this->Html->df(h($arr['created'])) . "]</Font>";
                    echo "</td>\n";
                    echo "</tr>\n";
                }
            }
        }
    }
    echo "</table>";
    echo "<br />";

    echo "<div id=\"mondai-pagination\" class=\"pagination\">";
    $options = array(
        'tag'=>'span class="pagi"',
        'modulus'=>18,
        'first'=>'',
        'last'=>'',
        'separator'=>false,
    );
    echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->numbers($options,array('class'=>'page'));
    echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
    echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );
    echo "</div>";

}
echo "<div class=\"clear\"></div>\n";
?>
