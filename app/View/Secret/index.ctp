<?php
if(!empty(AuthComponent::user('id'))){
    Cache::set(Array('duration' => '+60 seconds'));
    if(! $cache_secret_fav_data = Cache::read('cache_secret_fav_data_'.AuthComponent::user('id'))) {
        $cache_secret_fav_data_kari = $secret_fav_data;
        Cache::write('cache_secret_fav_data_'.AuthComponent::user('id'), $cache_secret_fav_data_kari);
        $cache_secret_fav_data = Cache::read('cache_secret_fav_data_'.AuthComponent::user('id'));
    } else {
        $cache_secret_fav_data = Cache::read('cache_secret_fav_data_'.AuthComponent::user('id'));
    }
    Cache::set(Array('duration' => '+60 seconds'));
    if(! $cache_secret_data = Cache::read('cache_secret_data_'.AuthComponent::user('id'))) {
        $cache_secret_data_kari = $secret_data;
        Cache::write('cache_secret_data_'.AuthComponent::user('id'), $cache_secret_data_kari);
        $cache_secret_data = Cache::read('cache_secret_data_'.AuthComponent::user('id'));
    } else {
        $cache_secret_data = Cache::read('cache_secret_data_'.AuthComponent::user('id'));
    }
}
echo "<div class=\"black-bar margin_b50\"><h1>秘密の部屋</h1></div>";
echo $this->Html->image("secret.jpg",array('class'=>'img-responsive l gakudake margin_r20'));
echo "<b>秘密の部屋は一般公開されない、個別のチャットルームです。</b><br /><br />";
echo "部屋を作成すると「<b>ルームキー</b>」が発行され、それを入室画面で入力するとチャットルームに入る事ができます。<br />";
echo "一人いくつでも作ることができます。<br />";
echo "用途は自由で、「一般公開できない問題」もそこでプレイする事ができます。<br />";
echo "<br />";
if(!empty(AuthComponent::user('id'))){
    echo "<center><span class=\"text-big2\"><a href='" . $this->Html->url('/secret/add') . "'><b>チャットルームを作成する。</b></a></span></center>";
    echo "<br />";
    echo "<br />";
    echo $this->Form->create(null,array('type'=>'post','url'=>'./'))."\n";
    echo "<table class=\"mondai_table\">";
    echo "<tr><td><center><h2>秘密の部屋に入室する</b></h2></center></td></tr>";
    echo "<tr><td>" . $this->Form->text("Secretroom.secretid",array('placeholder'=>'ルームキーを入力してください'))."</td></tr>";
    echo "<tr><td><center><input type=\"submit\" value=\"入室\" /></center></td></tr>\n";
    echo "</table></form>\n";
} else {
    echo "<b>ご利用にはログインが必要です。</b>";
}
echo "<div class=\"clear\"></div>";
?>
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
echo "<h2>公開されたチャットルーム</h2>";
echo "<table class=\"mondai_table\">";
echo "<tr><th class=\"mondai\">タイトル</th><th class=\"mondai\">ルームキー</th></tr>";
$color1 = 1;

for($i = 0;$i < count($open_data);$i++){
    $arr = $open_data[$i];
    if ($color1 == 1){
        echo "<tr>";
        $color1 = 2;
    } else {
        echo "<tr class=\"kage\">";
        $color1 = 1;
    }
    echo "<td width=\"50%\">";
    //暗号化
    $angou = openssl_encrypt($arr['Secretroom']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
    $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
    echo "<a href='" . $this->Html->url('/secret/show/' . $angou) . "'>" . h($arr['Secretroom']['title']) . "</a>";
    echo "</td>";
    echo "<td>";
    echo $arr['Secretroom']['secretid'];
    echo "</td>";
    echo "</tr>";

}

echo "</table>";
if(!empty(AuthComponent::user('id'))){
    echo "<br />";
    echo "<h2>お気に入りルーム</h2>";
    echo "<table class=\"mondai_table\">";
    $color1 = 1;
    for($i = 0;$i < count($cache_secret_fav_data);$i++){
        $arr = $cache_secret_fav_data[$i];
        if ($color1 == 1){
            echo "<tr>";
            $color1 = 2;
        } else {
            echo "<tr class=\"kage\">";
            $color1 = 1;
        }
        echo "<td width=\"50%\">";
        //暗号化
        $angou = openssl_encrypt($arr['Favorite']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
        $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
        if (!empty($cache_secret_fav_data[$i]['User']['id'])){
            echo "「部屋主：<b><a href='" . $this->Html->url('/mondai/profile/'.$cache_secret_fav_data[$i]['User']['id'])."'>";
            echo "".$cache_secret_fav_data[$i]['User']['name']."</a></b>」";
        }
        echo "<a href='" . $this->Html->url('/secret/show/' . $angou) . "'>" . h($arr['Favorite']['title']) . "</a>";
        echo "</td>";
        echo "<td>";
        echo $this->Form->create(null,array('type'=>'post','url'=>'./'));
        echo $this->Form->hidden('Favorite.id', array('value' => $arr['Favorite']['id']))."\n";
        echo $this->Form->hidden('Favorite.del', array('value' => 1))."\n";
        echo $this->Form->submit("外す", array('div'=>false, 'label'=>false))."\n";
        echo $this->Form->end()."\n";
        echo $arr['Favorite']['secretid'];
        echo "</td>";
        echo "</tr>";

    }
    echo "</table>";
    echo "<br />";

    echo "<h2>あなたの作ったチャットルーム</h2>";
    echo "<table class=\"mondai_table\">";
    $color1 = 1;

    for($i = 0;$i < count($cache_secret_data);$i++){
        $arr = $cache_secret_data[$i];
        if ($color1 == 1){
            echo "<tr>";
            $color1 = 2;
        } else {
            echo "<tr class=\"kage\">";
            $color1 = 1;
        }
        echo "<td width=\"50%\">";
        //暗号化
        $angou = openssl_encrypt($arr['Secretroom']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
        $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
        echo "<a href='" . $this->Html->url('/secret/show/' . $angou) . "'>" . h($arr['Secretroom']['title']) . "</a>";
        echo "</td>";
        echo "<td>";
        echo $arr['Secretroom']['secretid'];
        echo "</td>";
        echo "</tr>";

    }

    echo "</table>";
}
echo "<div class=\"clear\"></div>\n";
?>
