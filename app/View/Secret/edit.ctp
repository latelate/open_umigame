<?php
echo "<div class=\"black-bar margin_b50\"><h1>編集</h1></div>";
if($data['User']['id'] == AuthComponent::user('id')){
    if ($data['Secret']['flg'] != 1){
        //暗号化
        $angou = openssl_encrypt($data2['Secretroom']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
        $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
        echo "<a href=\"" . $this->Html->url('/secret/show/' . h($angou)) . "\">※編集しないで戻る</a><br />";
        echo $this->Form->create(null,array('type'=>'post','url'=>'./edit/' . h($param)));
        echo "<table class='mondai_table'>";
        echo "<tr><td>";
        echo "質問編集";
        echo "</td><td>";
        if(empty(h($data['Secret']['edit']))){
            echo $this->Form->textarea('Secret.content',array("cols" => "50","rows" => "5"));
        } else {
            echo $this->Form->textarea('Secret.editcont',array("cols" => "50","rows" => "5"));
        }
        echo $this->Form->error('Secret.content');
        echo $this->Form->input('id', array('type'=>'hidden'));
        echo "<div class=\"submit\"><input type=\"submit\" value=\"編集\" /></div></td></tr>\n";
        echo "</table></form>\n";
    } else {
        echo "質問が締切られた場合は編集できません。";
    }
} else {
    echo "質問が締切られた場合は編集できません。";
}

?>
