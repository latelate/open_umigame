<div class="black-bar margin_b50"><h1>ミニメ受信箱</h1></div>
<?php
if(empty(AuthComponent::user('id'))){
    ?>
    <table><tr>
        <td class="img-h2"><?php echo $this->Html->image("h2.png"); ?></td>
        <td class="text-big3">ご利用にはログインが必要です。</td>
    </tr></table>
    <?php
} else {
    if ($param == AuthComponent::user('id')){
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
            echo "<td title=\"name\">";
            if(!empty($arr['User']['name'])){
                echo "<center><b><a href='" .$this->Html->url('/mondai/profile/'.$arr['User']['id'])."'>".h($arr['User']['name'])."</a></b></center>";
                if (!empty($arr['User']['degree'])){
                  echo "<a class=\"degree\" href='" . $this->Html->url('/degree/show/' . $arr['User']['degreeid']) . "'>[" .  h($arr['User']['degree']) . "]</a>";
                }
            } else {
                echo "<b>不明</b>";
            }
            echo "</td>";
            echo "<td title=\"content\">";
            echo nl2br(h($arr['Minimail']['content']));
            if(!empty(AuthComponent::user('id'))){
                echo $this->Form->create(null,array('type'=>'post','url'=>'./inbox/' . h($param)))."\n";
                echo $this->Form->hidden('Minimail.frm', array('value' => h($param)))."\n";
                echo $this->Form->hidden('Minimail.to', array('value' => $arr['User']['id']))."\n";
                echo $this->Form->textarea("Minimail.content",array("cols" => "50","rows" => "5",'placeholder'=>'返信はコチラに書きましょう。'))."\n";
                echo $this->Form->error('Minimail.content')."<br />\n";
                echo $this->Form->submit(h($arr['User']['name']) . "に返信する", array('div'=>false, 'label'=>false))."\n";
                echo $this->Form->end()."\n";
            }

            echo "</td>";
            echo "<td title=\"name\">" . $this->Html->df($arr['Minimail']['created']);
            if (!empty(AuthComponent::user('id'))){
                if ($arr['Minimail']['midoku'] == 1){
                    echo $this->Form->create(null,array('type'=>'file','url'=>'./inbox/'.h($param)));
                    echo $this->Form->hidden("Minimail.midoku",array('value'=>false,'value'=>2))."\n";
                    echo $this->Form->hidden('Minimail.id', array('value' => $arr['Minimail']['id']))."\n";
                    echo $this->Form->submit("既読にする", array('class'=>'form-button', 'label'=>false))."\n";
                    echo $this->Form->end()."\n";
                }
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
?>
