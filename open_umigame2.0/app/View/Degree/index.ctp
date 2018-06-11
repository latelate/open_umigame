<?php
//称号選択肢一覧
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_degree = Cache::read('cache_degree')) {
    $cache_degree_kari = $degree;
    Cache::write('cache_degree', $cache_degree_kari);
    $cache_degree = Cache::read('cache_degree');
} else {
    $cache_degree = Cache::read('cache_degree');
}
//称号セレクト
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_degree2 = Cache::read('cache_degree2')) {
    $cache_degree2_kari = $degree2;
    Cache::write('cache_degree2', $cache_degree2_kari);
    $cache_degree2 = Cache::read('cache_degree2');
} else {
    $cache_degree2 = Cache::read('cache_degree2');
}
//申請
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_sinsei = Cache::read('cache_sinsei')) {
    $cache_sinsei_kari = $sinsei;
    Cache::write('cache_sinsei', $cache_sinsei_kari);
    $cache_sinsei = Cache::read('cache_sinsei');
} else {
    $cache_sinsei = Cache::read('cache_sinsei');
}
//履歴
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_rireki = Cache::read('cache_rireki')) {
    $cache_rireki_kari = $rireki;
    Cache::write('cache_rireki', $cache_rireki_kari);
    $cache_rireki = Cache::read('cache_rireki');
} else {
    $cache_rireki = Cache::read('cache_rireki');
}
//称号一覧
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_degree_data = Cache::read('cache_degree_data')) {
    $cache_degree_data_kari = $degree_data;
    Cache::write('cache_degree_data', $cache_degree_data_kari);
    $cache_degree_data = Cache::read('cache_degree_data');
} else {
    $cache_degree_data = Cache::read('cache_degree_data');
}
$degree = $cache_degree;
$degree2 = $cache_degree2;
$sinsei = $cache_sinsei;
$rireki = $cache_rireki;
$degree_data = $cache_degree_data;
?>
<div class="black-bar margin_b50"><h1>『称号』申請所</h1></div>
<?php
echo "称号の条件が満たした場合に申請すると、称号が付与されます。(取得条件は下記参照)<br />\n";
echo "(例)：<b>問題数が100問超えました。称号「100問出題」の付与をお願い致します。</b><br />\n";
echo "称号付与は機械的な審査では無くすべて手動で行います。称号を手に入れるべく不正を行っていないか、などもチェックしていきます。<br />\n";

if(!empty(AuthComponent::user('id'))){
    echo "<b>" . $this->Form->error('Mail.message') . "</b>";
    echo $this->Form->create(null,array('type'=>'post','url'=>'./index'));
    echo "<table class=\"mondai_table\">\n";
    echo "<tr><td>" . $this->Form->text('Mail.message',array('placeholder'=>'(例)：問題数が100問超えました。称号「100問出題」の付与をお願い致します。')) . "</td></tr>";
    echo "<tr><td><center><input type=\"submit\" value=\"申請する\" /></center></td></tr>\n";
    echo "</table></form>\n";
}
echo "<br />\n";

if (!empty($eroor)){
    echo "<Font Color=\"#ff0000\"><b>すでに取得しています。</b></Font><br />";
}
echo "マイページから<b>能力</b>に「★称号付与権」を付けると称号付与が行えます。<br /><br />";
if(!empty(AuthComponent::user('id'))){
    if(AuthComponent::user('degree_sub') == DEFINE_degreeGrant){
        echo "称号付与を行った場合、称号を付与した者の名前が「称号取得者の履歴に表示されます。<br />";
        echo "<b>付与した後は必ず「称号取得者の履歴」を見て正しく付与されたか確認してください。</b><br />";
        echo "「称号取得者の履歴」にて称号の取り消しも行うことができます。間違えた場合にご活用ください。<br />";
        echo $this->Form->create(null,array('type'=>'post','url'=>'./index'));
        echo "<table class=\"mondai_table\">\n";
        echo "<tr><td>" . $this->Form->text("Degreelink.user_id",array('placeholder'=>'ユーザー番号')) . "</td></tr>";
        echo "<tr><td>" . $this->Form->input('Degreelink.degree_id', array('type'=>'select','options'=>$degree2,'label'=>false,'div'=>false,'empty'=>'選んでください')) . "</td></tr>";
        echo "<tr><td><center><input type=\"submit\" value=\"称号付与\" /></center></td></tr>\n";
        echo "</table></form>\n";
    }
}
echo "<table class=\"mondai_table\">\n";
$color1 = 1;
for($c = 0;$c < count($sinsei);$c++){
    $arr = $sinsei[$c];
    if ($color1 == 1){
        echo "<tr class=\"kage\">";
        $color1 = 2;
    } else {
        echo "<tr>";
        $color1 = 1;
    }
    echo "<td>";
    switch (h($arr['Mail']['flg'])) {
        case '1':
            echo "<span class='red'>";
            break;
        case '2':
            echo "<span class='gray'>";
            break;
    }
    echo "[ユーザー番号:<b>";
    echo h($arr['User']['id']);
    echo "</b>]";
    echo "<a href='" . $this->Html->url('/mondai/profile/' . $arr['User']['id']) . "'>" . h($arr['User']['name']) . "</a>";
    echo "「<b>";
    echo h($arr['Mail']['message']);
    echo "</b>」";
    switch (h($arr['Mail']['flg'])) {
        case '1':
            echo "<b>[未達成]</b></span>";
            break;
        case '2':
            echo "<b>[完了]</b></span>";
            break;
    }
    if(AuthComponent::user('degree_sub') == DEFINE_degreeGrant){
        echo $this->Form->create(null,array('type'=>'post','url'=>'./index'));
        echo $this->Form->hidden('Mail.id', array('value' => $arr['Mail']['id']))."\n";
        switch (h($arr['Mail']['flg'])) {
            case 0:
                echo $this->Form->hidden('Mail.flg', array('value' => 2))."\n";
                echo $this->Form->submit("完了", array('div'=>false, 'label'=>false))."\n";
                echo $this->Form->end()."\n";

                echo $this->Form->create(null,array('type'=>'post','url'=>'./index'));
                echo $this->Form->hidden('Mail.id', array('value' => $arr['Mail']['id']))."\n";
                echo $this->Form->hidden('Mail.flg', array('value' => 1))."\n";
                echo $this->Form->submit("未達成", array('div'=>false, 'label'=>false))."\n";
                break;
            case '1':
                echo $this->Form->hidden('Mail.flg', array('value' => 2))."\n";
                echo $this->Form->submit("完了", array('div'=>false, 'label'=>false))."\n";
                break;
            case '2':
                echo $this->Form->hidden('Mail.flg', array('value' => 1))."\n";
                echo $this->Form->submit("未達成", array('div'=>false, 'label'=>false))."\n";
                break;
        }
        echo $this->Form->end()."\n";
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>\n";

echo "<br /><br />\n";
echo "<div class='black-bar margin_b50'><h1>称号一覧と取得条件</h1></div>\n";
echo "<table class=\"mondai_table\">\n";
$color1 = 1;
for($c = 0;$c < count($degree_data);$c++){
    $arr = $degree_data[$c];
    if ($color1 == 1){
        echo "<tr class=\"kage\">";
        $color1 = 2;
    } else {
        echo "<tr>";
        $color1 = 1;
    }
    echo "<td>";
    echo "[<b>";
    echo "<a href='" . $this->Html->url('/degree/acquirer/'.h($arr['Degree']['id'])) . "'>".h($arr['Degree']['content'])."</a>";
    echo "</b>]";
    echo "</td>";
    echo "<td>";
    echo h($arr['Degree']['condition']);
    echo "</td>";
    echo "</tr>";
}
echo "</table>\n";
echo "※ここに表示されていない、隠し称号も存在します。";

echo "<br /><br />\n";
echo "<div class='black-bar margin_b50'><h1>称号取得者の履歴</h1></div>\n";
echo "<table class=\"mondai_table\">\n";
for($c = 0;$c < count($rireki);$c++){
    $arr = $rireki[$c];
    if ($color1 == 1){
        echo "<tr class=\"kage\">";
        $color1 = 2;
    } else {
        echo "<tr>";
        $color1 = 1;
    }
    echo "<td>";
    if(!empty(AuthComponent::user('id'))){
        if(AuthComponent::user('degree_sub') == DEFINE_degreeGrant){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./index'));
            echo h($arr['User']['name']);
            echo "さんは『";
            echo h($arr['Degree']['content']);
            echo "』の称号を獲得しました。";
            echo $this->Form->hidden('Degreelink.id', array('value' => $arr['Degreelink']['id']))."\n";
            echo $this->Form->hidden('Degreelink.del', array('value' => 1))."\n";
            echo $this->Form->submit("取り消し", array('div'=>false, 'label'=>false))."\n";
            echo $this->Form->end()."\n";
        } else {
            echo h($arr['User']['name']);
            echo "さんは『";
            echo h($arr['Degree']['content']);
            echo "』の称号を獲得しました。";
        }
    } else {
        echo h($arr['User']['name']);
        echo "さんは『";
        echo h($arr['Degree']['content']);
        echo "』の称号を獲得しました。";
    }
    echo "</td>";
    echo "<td>";
    echo "称号付与者「";
    echo h($arr['Degreelink']['addname']);
    echo "」";
    echo "</td>";
    echo "</tr>";
}
echo "</table>\n";
?>
