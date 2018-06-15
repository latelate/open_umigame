<div class="black-bar margin_b50"><h1>新規登録</h1></div>
<table><tr>
    <td class="img-h2"><?php echo $this->Html->image("h2.png"); ?></td>
    <td class="text-big3">ご利用にあたっての注意事項</td>
</tr></table>
<div class="hukidasi hukidasi-p">
    <div class="f-h">
        <?php echo $this->Html->image("f-h.png",array('class'=>'img-responsive')); ?>
    </div>
    <div class="hukidasi_box">
        <table><tr>
            <td class="img-h3"><?php echo $this->Html->image("h3.png"); ?></td>
            <td class="text-big2">OPENウミガメは鯖ごとにそれぞれ運営者が異なり、各所のルール・マナーも様々です。</td>
        </tr></table>
        <div class="hukidasi hukidasi-p">
            <div class="f-h">
                <?php echo $this->Html->image("f-h.png",array('class'=>'img-responsive')); ?>
            </div>
            <div class="hukidasi_box">
                〇〇鯖では"しても良い"ルールが、△△鯖では"してはいけない"ルールということもあり得ます。<br />
                プレイする場合は<b>必ず</b>ルール説明ページでローカルルール等を把握しましょう。<br />
                <br />
                <b><a href="<?php echo $this->Html->url('http://sui-hei.net/main/rule') ?>">ラテシン</a>にてプログラムのソースを公開しているので、どなたでもウミガメのスープ投稿サイトを運営することができます。</b><br />
                <br />
            </div>
        </div>
    </div>
</div>
<?php
echo "<div class=\"border\">\n";
echo $this->Form->error('User.name');
echo $this->Form->error('User.username');
echo $this->Form->error('User.password_vali');
echo $this->Form->create(null,array('type'=>'post','url'=>'./add'));
echo "<table>\n";
echo "<tr><td>" . $this->Form->text('User.name',array('placeholder'=>'ニックネームを記入してください。')) . "例：<b>水平太郎☆</b></td></tr>";
echo "<tr><td>" . $this->Form->text('User.username',array("style" => "ime-mode:disabled",'placeholder'=>'ユーザーIDを記入してください。')) . "例：<b>rate555</b></td></tr>";
echo "<tr><td>" . $this->Form->password('User.password_vali',array('placeholder'=>'パスワードを記入してください。')) . "例：<b>s3uihe3i</b></td></tr>";
echo "<tr><td><center><input type=\"submit\" value=\"新規登録する\" /></center></td></tr>\n";
echo "</table></form>\n";
echo "<b>パスワードを忘れた場合、本人確認ができないため再発行はできません。必ず忘れないようにメモしてください。</b><br />";
echo "当webサイト利用する場合は、<a href=\"" . $this->Html->url('/main/kiyaku') . "\">利用規約</a>に同意したものとします。";
echo "</div>\n";
?>
