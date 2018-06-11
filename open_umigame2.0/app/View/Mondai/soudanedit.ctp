<div class="black-bar margin_b50"><h1>編集</h1></div>
<a href="<?php echo $this->Html->url('/mondai/show/' . h($data2['Mondai']['id']));?>">※編集しないで戻る</a><br />
<?php
if($data['User']['id'] == AuthComponent::user('id')){
    echo $this->Form->create(null,array('type'=>'post','url'=>'./soudanedit/' . h($param)));
    echo "<table class='mondai_table'>";
    echo "<tr><td>";
    echo "相談チャット編集";
    echo "</td><td>";
    echo $this->Form->hidden('id');
    if (empty($data['Soudan']['editcont'])){
        echo $this->Form->hidden('Soudan.content');
        echo $this->Form->textarea('Soudan.content',array("cols" => "50","rows" => "5"));
        echo $this->Form->error('Soudan.content');
    } else {
        echo $this->Form->hidden('Soudan.editcont');
        echo $this->Form->textarea('Soudan.editcont',array("cols" => "50","rows" => "5"));
        echo $this->Form->error('Soudan.editcont');
    }
    echo $this->Form->input('id', array('type'=>'hidden'));
    echo "<div class=\"submit\"><input type=\"submit\" value=\"編集\" /></div></td></tr>\n";
    echo "</table></form>\n";
}
?>
