<?php
echo "<div class=\"gaku\">\n";
Cache::set(Array('duration' => '+300 seconds'));
if(! $cache_kinou = Cache::read('cache_kinou')) {
    $cache_kinou_kari = $kinoumondai;
    Cache::write('cache_kinou', $cache_kinou_kari);
    $cache_kinou = Cache::read('cache_kinou');
} else {
    $cache_kinou = Cache::read('cache_kinou');
}

Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_plan = Cache::read('cache_plan')) {
    $cache_plan_kari = $plan;
    Cache::write('cache_plan', $cache_plan_kari);
    $cache_plan = Cache::read('cache_plan');
} else {
    $cache_plan = Cache::read('cache_plan');
}
Cache::set(Array('duration' => '+10 seconds'));
if(! $cache_newtemp = Cache::read('cache_newtemp')) {
    $cache_newtemp_kari = $newtemp;
    Cache::write('cache_newtemp', $cache_newtemp_kari);
    $cache_newtemp = Cache::read('cache_newtemp');
} else {
    $cache_newtemp = Cache::read('cache_newtemp');
}

echo "<marquee>";
echo "<b>昨日の問題投稿数は".$cache_kinou."問です。</b>";
echo "管理者の一言「".DEFINE_hitokoto."」";
echo "</marquee>";
echo "</div>\n";
//左側
echo "<div class=\"l lobby_l\">\n";
    //出題予定告知チャット
    echo "<div class=\"gakudake kokutichat\">\n";
        echo "<h3>いろいろ告知チャット</h3>";
        echo "<table class=\"mondai_table_w\">\n";
            if(!empty($_SESSION['Auth']['User'])){
                $array_week = array("日","月","火","水","木","金","土");
                echo "<tr>\n";
                echo "<td>\n";
                echo $this->Form->create(null,array('type'=>'post','url'=>'./lobby'));
                echo $this->Form->text("Plan.content",array('placeholder'=>'予定を告知しましょう。','class'=>'formjquery'));
                echo $this->Form->input('Plan.plantime', array('type'=>'select','options'=>array(
                date("Y-m-d")=>$this->Html->koj(date("Y-m-d")) . "(" . $array_week[date("w")] . ")",
                date("Y-m-d",strtotime('+1 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+1 day'))) . "(" . $array_week[date("w",strtotime('+1 day'))] . ")",
                date("Y-m-d",strtotime('+2 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+2 day'))) . "(" . $array_week[date("w",strtotime('+2 day'))] . ")",
                date("Y-m-d",strtotime('+3 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+3 day'))) . "(" . $array_week[date("w",strtotime('+3 day'))] . ")",
                date("Y-m-d",strtotime('+4 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+4 day'))) . "(" . $array_week[date("w",strtotime('+4 day'))] . ")",
                date("Y-m-d",strtotime('+5 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+5 day'))) . "(" . $array_week[date("w",strtotime('+5 day'))] . ")",
                date("Y-m-d",strtotime('+6 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+6 day'))) . "(" . $array_week[date("w",strtotime('+6 day'))] . ")",
                date("Y-m-d",strtotime('+7 day'))=>$this->Html->koj(date("Y-m-d",strtotime('+7 day'))) . "(" . $array_week[date("w",strtotime('+7 day'))] . ")",
                ),'label'=>false,'div'=>false,'empty'=>'選んでください'));
                echo $this->Form->submit("告知する", array('div'=>false, 'label'=>false))."\n";
                echo $this->Form->end()."\n";
                echo "</td>\n";
                echo "</tr>\n";
            }
            for($k = 0;$k < count($cache_plan);$k++){
                $arr = $cache_plan[$k]['Plan'];
                if (!empty($arr['content'])){
                    echo "<tr>\n";
                    echo "<td>\n";
                    echo "<div class=\"hankaku\">";
                    if (AuthComponent::user('id') == $arr['user_id']){
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./lobby'));
                    }
                    echo "<Font Size=\"3\">\n";
                    echo "<a href='" . $this->Html->url('/mondai/profile/' . $cache_plan[$k]['User']['id']) . "'>" . $this->Text->truncate(h($cache_plan[$k]['User']['name']),10) . "</a></Font>\n";
                    if (!empty($cache_plan[$k]['User']['degree'])){
                        echo "<Font Color=\"#666666\">[" .  h($cache_plan[$k]['User']['degree']) . "]</Font>\n";
                    }
                    echo "＞＞";
                    echo "<Font Color=\"#999966\">\n";
                    echo "<b>";
                    $array_week = array("日","月","火","水","木","金","土");
                    echo $this->Html->dlo(h($arr['plantime']));
                    echo "(" . $array_week[$this->Html->www(h($arr['plantime']))] . ")";
                    echo "</b>";
                    echo h($arr['content']);
                    echo "</Font>\n";
                    if (AuthComponent::user('id') == $arr['user_id']){
                        echo $this->Form->hidden('Plan.id', array('value' => $arr['id']))."\n";
                        echo $this->Form->hidden('Plan.del', array('value' => 1))."\n";
                        echo $this->Form->submit("削除", array('div'=>false, 'label'=>false))."\n";
                        echo $this->Form->end()."\n";
                    }
                    echo "</div>";
                    echo "</td>\n";
                    echo "</tr>\n";
                }
            }
        echo "</table>\n";
    echo "</div>\n";

    //新着ブックマーク
    echo "<div class=\"gakudake kokutichat\">\n";
        echo "<h3>新着ブックマーク＆コメント</h3>";
        echo "<table class=\"mondai_table_w\">\n";
            for($k = 0;$k < count($cache_newtemp);$k++){
                $arr = $cache_newtemp[$k]['Temple'];
                echo "<tr>\n";
                echo "<td>\n";
                echo "<div class=\"hankaku\">";
                echo "<Font Size=\"3\">\n";
                echo "<a href='" . $this->Html->url('/mondai/profile/' . $arr['add_user_id']) . "'>" . $this->Text->truncate(h($arr['name']),30) . "</a></Font>\n";
                echo "さんが[";
                echo "<a href='" . $this->Html->url('/mondai/show/' . h($cache_newtemp[$k]['Mondai']['id'])) . "'>" . $this->Text->truncate(h($cache_newtemp[$k]['Mondai']['title']),20) . "</a></Font>\n";
                echo "]をブックマークしました。<br />";
                if (!empty($arr['comment'])){
                    echo "<Font Color=\"#999966\">\n";
                    echo "「<b>";
                    echo $this->Text->truncate(h($arr['comment']),100);
                    echo "</b>」";
                    echo "</Font>\n";
                }
                echo "</div>";
                echo "</td>\n";
                echo "</tr>\n";
            }
        echo "</table>\n";
    echo "</div>\n";
echo "</div>\n";
//右側
echo "<div class=\"r lobby_r\">\n";
    //ロビーチャット
    echo "<div class=\"gakudake lobbychat\">\n";
        echo "<h2>ロビーチャット</h2>";
        echo "<table class=\"mondai_table_w\">\n";
            if(!empty($_SESSION['Auth']['User'])){
                echo "<tr>\n";
                echo "<td>";
                echo $this->Form->create(null,array('type'=>'post','url'=>'./lobby'));
                echo $this->Form->text("Lobby.content",array('placeholder'=>'自由に書きこんでください','class'=>'formjquery'));
                echo $this->Form->submit("発言する", array('div'=>false, 'label'=>false))."\n";
                echo $this->Form->end()."\n";
                echo "</td>\n";
                echo "</tr>\n";
            }
        echo "</table>\n";
        echo "<div id=\"lobbylist\">\n";
        echo "<div class=\"pagination\">\n";
            $this->Paginator->options();
            $options = array(
                'modulus'=>6
            );
            echo $this->Paginator->first('最初');
            echo $this->Paginator->prev(__('前', true),'最初');
            echo $this->Paginator->numbers($options,array('class'=>'page'));
            echo $this->Paginator->next(__('次', true),'');
        echo "</div>";
        echo "<table class=\"mondai_table_w\">\n";
        for($l = 0;$l < count($lobbylist);$l++){
            $arr2 = $lobbylist[$l]['Lobby'];
            if (!empty($arr2['user_id'])){
                echo "<tr>\n";
                echo "<td>\n";
                echo "<div class=\"hankaku\">";
                if ($arr2['nanashiflg'] == 1){
                    echo "<Font Size=\"3\"><a href='" . $this->Html->url('/mondai/profile/' . $lobbylist[$l]['User']['id']) . "'>" . h($lobbylist[$l]['User']['name']) . "</a></Font>\n";
                    if (!empty($lobbylist[$l]['User']['degree'])){
                        echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $lobbylist[$l]['User']['degreeid']) . "'>[" .  h($lobbylist[$l]['User']['degree']) . "]</a>";
                    }
                } else {
                    echo "<Font Size=\"3\" Color=\"#CCCCCC\">名無しさん</Font>\n";
                }
                echo "＞＞";
                echo "<Font Color=\"#999966\">";
                if ($lobbylist[$l]['User']['flg'] > 2){
                    if ($lobbylist[$l]['User']['id'] == '12600'){
                        echo "<font color=\"#ff0000\">";
                    } else {
                        echo "<font color=\"#ffff80\">";
                    }
                    echo h($arr2['content'])."</font>";
                } else {
                    echo h($arr2['content']);
                }
                echo "<Font Color=\"#666666\">[".$this->Html->dlo(h($arr2['created']))."]</Font>";
                echo "</Font>\n";

                echo "</div>";
                echo "</td>";
                echo "</tr>\n";
            }
        }
        echo "</table>\n";
        echo "</div>\n";
    echo "</div>\n";

echo "</div>\n";
echo "<div class=\"clear\"></div>\n";

 ?>
