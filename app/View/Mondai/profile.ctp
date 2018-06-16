<?php
if (!empty($data)){
?>
<div class="black-bar margin_b50"><h1><?php echo h($data["User"]["name"])?>さんのプロフィール</h1></div>
<table class="mondai_table">
    <tr>
        <th>
        </th>
        <td title="content">
            <?php
            echo "取得した称号：";
            //称号
            for($d = 0;$d < count($degree);$d++){
              echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $degree[$d]['Degree']['urlid']) . "'>[" .  $degree[$d]['Degree']['content'] . "]</a>";
            }
            ?>
            <?php
            if(!empty(AuthComponent::user('id'))){
                if ($data["User"]["id"] != AuthComponent::user('id')){
                    echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)))."\n";
                    echo $this->Form->hidden('Minimail.frm', array('value' => AuthComponent::user('id')))."\n";
                    echo $this->Form->hidden('Minimail.to', array('value' => h($param)))."\n";
                    echo $this->Form->textarea("Minimail.content",array("cols" => "50","rows" => "5",'placeholder'=>'ミニメールの内容はコチラに書きましょう。'))."\n";
                    echo $this->Form->error('Minimail.content')."<br />\n";
                    echo $this->Form->submit("ミニメールを送る", array('div'=>false, 'label'=>false))."\n";
                    echo $this->Form->end()."\n";
                }
            }
            ?>
        </td>
    </tr>
</table>
<?php

    //イイ味ネ！
    echo "<br />";
    echo "<h2>".h($data["User"]["name"])."さんのブックマーク</h2>";
    echo "<div id=\"mondai-pagination\" class=\"pagination\">";
    $options = array(
        'tag'=>'span class="pagi"',
        'modulus'=>5,
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
    echo "<table class=\"mondai_table\">";
    echo "<tr>";
    echo "<th>" . $this->Paginator->sort('User.name','出題者順') . "</th>";
    echo "<th>タイトル</th>";
    echo "<th>" . $this->Paginator->sort('Mondai.genre','ジャンル別') . "</th>";
    echo "<th>" . $this->Paginator->sort('Mondai.created','日付順') . "</th>";
    echo "<th>制限</th>";
    echo "<th>操作</th>";
    echo "</tr>";
    $color1 = 1;
    for($i = 0;$i < count($iine);$i++){
        $arr = $iine[$i];
        if ($color1 == 1){
            echo "<tr>";
        } else {
            echo "<tr class=\"kage\">";
        }
        echo "<td width=\"120px\">";
        if(!empty($arr['User']['name'])){
            echo "<b><a href='" .$this->Html->url('/mondai/profile/'.$arr['User']['id'])."'>".h($arr['User']['name'])."</a></b>";
            if (!empty($arr['User']['degree'])){
                echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $arr['User']['degreeid']) . "'>[" .  h($arr['User']['degree']) . "]</a>";
            }
        } else {
            echo "<b>不明</b>";
        }
        echo "</td>";
        echo "<td>";
        if ($arr['Mondai']['delete'] == 2){
            echo "<b>非公開</b>";
        } else {
            echo "<a href='" . $this->Html->url('/mondai/show/' . $arr['Mondai']['id']) . "'>" . h($arr['Mondai']['title']) . "</a>";
            if (!empty($arr['Image']['0']['mondai_id'])){
                echo "<Font Color=\"#787878\">[<b>挿絵あり！</b>]</Font>";
            }
        }
        if (!empty($arr['Mondai']['comment'])){
            echo "<Font Color=\"#787878\">[" . h($arr['Mondai']['comment']) . "]</Font>";
        }
        //殿堂入り
        if (!empty($arr['Indextemp']['0']['count'])){
            echo "<Font Color=\"#787878\">" . h($arr['Indextemp']['0']['count']) . "票</Font>";
        }
        echo "</td>";
        if ($arr['Mondai']['genre'] == 1) {
            echo "<td>【ウミガメ】</td>";
        } elseif ($arr['Mondai']['genre'] == 2) {
            echo "<td>【20の扉】</td>";
        } elseif ($arr['Mondai']['genre'] == 3) {
            echo "<td>【亀夫君】</td>";
        } elseif ($arr['Mondai']['genre'] == 4) {
            echo "<td>【新・形式】</td>";
        } else {
            echo "<td>ノージャンル</td>";
        }
        echo "<td width=\"85px\">" . trim($this->Html->dfj($arr['Mondai']['created']),20) . "</td>";
        echo "<td width=\"80px\">";
        if (!empty($arr['Mondai']['stime'])){
            switch ($arr['Mondai']['stime']) {
                case '+30 minute':
                    echo "30分";
                    break;
                case '+1 hour':
                    echo "1時間";
                    break;
                case '+1 day':
                    echo "1日";
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
            echo $arr['Mondai']['scount'] . "回まで";
        }
        echo "</td>";
        echo "<td>";
        if ($param == AuthComponent::user('id')){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)));
            echo $this->Form->hidden('Temple.id', array('value' => $arr['Temple']['id']))."\n";
            echo $this->Form->hidden('Temple.mondai_id', array('value' => $arr['Temple']['mondai_id']))."\n";
            echo $this->Form->hidden('Temple.del', array('value' => 1))."\n";
            echo $this->Form->submit("外す", array('div'=>false, 'label'=>false))."\n";
            echo $this->Form->end()."\n";
        }
        echo "</td>";
        echo "</tr>";
        if ($color1 == 1){
            echo "<tr>";
            $color1 = 2;
        } else {
            echo "<tr class=\"kage\">";
            $color1 = 1;
        }
        echo "<td colspan='6'>";
        if(!empty($arr['Temple']['comment'])){
            echo "コメント「<b>".nl2br(h($arr['Temple']['comment']))."</b>」";
        } else {
            echo "コメント「」";
        }
        //pr($this->data);
        if ($param == AuthComponent::user('id')){
            echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)));
            echo $this->Form->hidden('Temple.id', array('value' => $arr['Temple']['id']))."\n";
            echo $this->Form->hidden('Temple.mondai_id', array('value' => $arr['Temple']['mondai_id']))."\n";
            echo $this->Form->textarea("Temple.comment",array("cols" => "50","rows" => "5",'value' => $arr['Temple']['comment'],'placeholder'=>'ブクマにコメントしてみましょう。'))."\n";
            echo $this->Form->hidden('Temple.comment_flg', array('value' => 1))."\n";
            echo $this->Form->submit("ブクマにコメントする", array('div'=>false, 'label'=>false))."\n";
            echo $this->Form->end()."\n";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo $this->Paginator->counter(array(
        'format' => '合計 %pages% ページ中の %page% ページ目です。
                総問題数 %count% のうち、  %start% 行目から %end% 行目までの %current% 行を表示しています。'
    ));
?>
<table class="mondai_table">
    <tr>
        <th title="title">
            自己紹介
        </th>
        <td title="content">
            <?php
            if (!empty(AuthComponent::user('id'))){
                //称号変更
                if ($data["User"]["id"] == AuthComponent::user('id')){
                    if (count($degree2) > 1){
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)))."\n";
                        echo $this->Form->input('User.degree', array('type'=>'select','options'=>$degree2,'label'=>false,'div'=>false,'empty'=>'選んでください'));
                        echo $this->Form->submit("称号を変更", array('div'=>false, 'label'=>false))."\n";
                        echo $this->Form->error('User.degree');
                        echo $this->Form->end()."\n";
                    }
                }
                //サブ称号変更
                if ($data["User"]["id"] == AuthComponent::user('id')){
                    if (count($degree2) > 1){
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)))."\n";
                        echo $this->Form->input('User.degree_sub', array('type'=>'select','options'=>$degree2,'label'=>false,'div'=>false,'empty'=>'選んでください'));
                        echo $this->Form->submit("能力を付与", array('div'=>false, 'label'=>false))."\n";
                        echo $this->Form->error('User.degree_sub');
                        echo $this->Form->end()."\n";
                    }
                }
                echo "現在の能力：<b>" . h($data["User"]['degree_sub'])."</b>";
                echo "<br /><br />";
                if ($data["User"]["id"] == AuthComponent::user('id')){
                    echo "<b><a href=\"" . $this->Html->url('/users/logout') . "\">ログアウトする</a></b>";
                    echo "<br /><br />";
                }
            }
            echo "登録日：<b>".$this->Html->dateFormat(h($data["User"]['created']))."</b>\n";
            echo "<br />";
            echo "問題数：". h($mondaicount);
            echo "<br />";
            echo "質問数：" . h($rescount);
            echo "<br />";
            echo "良い質問数：" . h($nicecount);
            echo "<br />";
            echo "「正解！」数：" . h($facount);
            echo "<br />";
            echo "チャット発言数：" . h($secount);
            echo "<br />";
            echo "<br />";
            if(!empty(AuthComponent::user('id'))){
                if ($data["User"]["id"] == AuthComponent::user('id')){
                        echo $this->Form->create(null,array('type'=>'post','url'=>'./profile/' . h($param)))."\n";
                        echo "    ".$this->Form->textarea("User.profile",array("cols" => "50","rows" => "5",'placeholder'=>'プロフィールを書いてみましょう。'))."\n";
                        echo $this->Form->error('User.profile');
                        echo "    ".$this->Form->submit("編集する")."\n";
                        echo $this->Form->end()."\n";
                }
            }
            if (!empty($data["User"]["profile"])){
                echo nl2br(h($data["User"]["profile"]));
            }
            ?>
        </td>
    </tr>
</table>
<?php
} else {
?>
<div class="black-bar margin_b50"><h1>プロフィール情報がありません。</h1></div>
<?php
}
 ?>
