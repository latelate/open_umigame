    <div class="black-bar margin_b50"><h1>プロフィールのあるユーザー一覧</h1></div>
<div id="mondai-pagination" class="pagination">
<?php
//pr($data);
$this->Paginator->options(array('url' => 'User'  ));
$options = array(
    'tag'=>'span class="pagi"',
    'modulus'=>19,
    'first'=>'',
    'last'=>'',
    'separator'=>false,
);
echo $this->Paginator->first('最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->prev('＜＜'.__('前', true), array('tag'=>'span class="pagi2"'), '最初',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->numbers($options,array('class'=>'page'));
echo $this->Paginator->next(__('次', true).'＞＞', array('tag'=>'span class="pagi2"'), '最後',array('tag'=>'span class="pagi2"'));
echo $this->Paginator->last('最後',array('tag'=>'span class="pagi2"') );
?>
</div>
<div class="clear margin_b10"></div>
<?php
//pr($data);
echo $this->Paginator->counter(array(
    'format' => 'プロフィールのあるユーザー：%count%人'
));
echo "<br />";
?>
<table class="mondai_table">
<tr><th title="title">出題者</th><th title="title">登録日</th><th>プロフ</th></tr>
<?php
$color1 = 1;
for($i = 0;$i < count($data);$i++){
    $arr = $data[$i];
    if ($color1 == 1){
        echo "<tr>";
        $color1 = 2;
    } else {
        echo "<tr class=\"kage\">";
        $color1 = 1;
    }
    echo "<td>";
    if(!empty($arr['User']['name'])){
        echo "<a href='" . $this->Html->url('/mondai/profile/' . $arr['User']['id']) . "'>" . h($arr['User']['name']) . "</a>";
    }
    //称号
    if(!empty($arr['User']['degree'])){
        echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $arr['User']['degreeid']) . "'>[" .  h($arr['User']['degree']) . "]</a>";
    }
    echo "</td>";
    echo "<td>" . trim($this->Html->dfj($arr['User']['created']),20) . "</td>";
    echo "<td>";
    echo $this->Text->truncate(h($arr['User']['profile']),70);
    echo "</td>";
    echo "</tr>";
}
?>
</table>
