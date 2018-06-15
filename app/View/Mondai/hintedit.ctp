<div class="black-bar margin_b50"><h1>編集</h1></div>
<a href="<?php echo $this->Html->url('/mondai/show/' . h($data2['Mondai']['id']));?>">※編集しないで戻る</a><br />
<?php
if ($data2['Mondai']['seikai'] != 2){
    if($data2['User']['id'] == AuthComponent::user('id')){
        echo $this->Form->create(null,array('type'=>'post','url'=>'./hintedit/' . h($param)));
        echo "<table class='mondai_table'>";
        echo "<tr><td>";
        echo "ヒント編集";
        echo "</td><td>";
        echo $this->Form->hidden('id');
        if (empty($data['Chat']['editcont'])){
            echo $this->Form->hidden('Chat.hint');
            echo $this->Form->textarea('Chat.hint',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Chat.hint');
        } else {
            echo $this->Form->hidden('Chat.editcont');
            echo $this->Form->textarea('Chat.editcont',array("cols" => "50","rows" => "5"));
            echo $this->Form->error('Chat.editcont');
        }
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo "<div class=\"submit\"><input type=\"submit\" value=\"編集\" /></div></td></tr>\n";
        echo "</table></form>\n";
    }
} else {
    echo "質問が締切られた場合は編集できません。";
}
?>
