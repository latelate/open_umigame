<?php
if ($param == AuthComponent::user('id')){
    echo "<div class=\"black-bar\">";
    echo "<h1>あなたの問題の新着ブックマーク</h1>";
    echo "</div>";
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
    echo "<table class=\"mondai_table\">";
    echo "<tr>";
    echo "<th>ブックマークしたユーザー</th>";
    echo "<th>タイトル</th>";
    echo "<th>ジャンル</th>";
    echo "<th>ブクマした日付</th>";
    echo "</tr>";
    $color1 = 1;
    for($i = 0;$i < count($mytemple);$i++){
        $arr = $mytemple[$i];
        if ($color1 == 1){
            echo "<tr>";
        } else {
            echo "<tr class=\"kage\">";
        }
        echo "<td>";
        if(!empty($arr['Temple']['name'])){
            echo "<b><a href='" .$this->Html->url('/mondai/profile/'.$arr['Temple']['add_user_id'])."'>".h($arr['Temple']['name'])."</a></b>";
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
        echo "<td>" . trim($this->Html->dfj($arr['Temple']['created']),20) . "</td>";
        echo "</tr>";
        if ($color1 == 1){
            echo "<tr>";
            $color1 = 2;
        } else {
            echo "<tr class=\"kage\">";
            $color1 = 1;
        }
        echo "<td colspan='4'>";
        if(!empty($arr['Temple']['comment'])){
            echo "コメント「<b>".nl2br(h($arr['Temple']['comment']))."</b>」";
        } else {
            echo "コメント「」";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo $this->Paginator->counter(array(
        'format' => '合計 %pages% ページ中の %page% ページ目です。
                総問題数 %count% のうち、  %start% 行目から %end% 行目までの %current% 行を表示しています。'
    ));

}
?>
