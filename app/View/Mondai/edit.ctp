<div class="black-bar margin_b50"><h1>編集</h1></div>
<a href="<?php echo $this->Html->url('/mondai/show/' . h($data2['Mondai']['id']));?>">※編集しないで戻る</a><br />
<?php
if ($data2['Mondai']['seikai'] != 2){
    if($data['User']['id'] == AuthComponent::user('id')){
        echo $this->Form->create(null,array('type'=>'post','url'=>'./edit/' . h($param)));
        echo "<table class='mondai_table'>";
        echo "<tr><td>";
        echo "質問編集";
        echo "</td><td>";
        if (empty($data['Resq']['ediqcont'])){
            echo $this->Form->textarea('Resq.content',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Resq.content');
        } else {
            echo $this->Form->textarea('Resq.ediqcont',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Resq.ediqcont');
        }
        if ($data2['Mondai']['textflg'] != 2){
            echo "    ".$this->Form->checkbox("Resq.textq",array('checked'=>false,'value'=>1))."長文にするならチェック\n";
        }
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo "<div class=\"submit\"><input type=\"submit\" value=\"編集\" /></div></td></tr>\n";
        echo "</table></form>\n";
    }
    if($data2['User']['id'] == AuthComponent::user('id')){
        echo $this->Form->create(null,array('type'=>'post','url'=>'./edit/' . h($param)));
        echo "<table class='mondai_table'>";
        echo "<tr><td>";
        echo "回答編集";
        echo "</td><td>";
        if (empty($data['Resq']['ediacont'])){
            echo $this->Form->textarea('Resq.answer',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Resq.answer');
        } else {
            echo $this->Form->textarea('Resq.ediacont',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Resq.ediacont');
        }
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo "<div class=\"submit\"><input type=\"submit\" value=\"編集\" /></div></td></tr>\n";
        echo "</table></form>\n";
    }
} else {
    echo "質問が締切られた場合は編集できません。";
}
?>
