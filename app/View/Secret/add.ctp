<div class="black-bar margin_b50"><h1>チャットルーム作成</h1></div>
<?php
echo "<div class=\"border\">";
if(!empty(AuthComponent::user('id'))){
    echo $this->Form->create(null,array('type'=>'post','url'=>'./add'))."\n";
    echo "<br />" . $this->Form->text("Secretroom.secretid",array('placeholder'=>'ルームキーを記入してください。'))."\n";
    echo "<Font Color=\"#ff0000\"><b>" . $this->Form->error('Secretroom.secretid') . "</b></Font>";
    echo "<br />";
    echo "<br />" . $this->Form->text("Secretroom.title",array('placeholder'=>'部屋タイトルを記入してください。'))."\n";
    echo $this->Form->error('Secretroom.title');
    echo "<br />";
    echo "<br />" . $this->Form->textarea("Secretroom.content",array('placeholder'=>'部屋の説明、自由欄。'))."\n";
    echo "<br />";
    echo "<center>".$this->Form->submit("部屋を作成する", array('label'=>false))."</center>\n";
    echo $this->Form->end()."\n";
}
if (!empty($message)){
    //暗号化
    $message = openssl_encrypt($message, 'AES-128-ECB', DEFINE_secretkey);
    $message = str_replace(array('+', '/', '='), array('_', '-', '.'), $message);
    echo "<center><span class=\"text-big3\">部屋が作成されました。さっそく<a href=\"" . $this->Html->url('/secret/show/'.urldecode($message)) . "\">入室</a>しよう！</span><br />";
}

echo "</div>";
echo "<div class=\"clear\"></div>";
?>
