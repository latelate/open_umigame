<?php
echo $this->Html->image("cindy_nesoberi.png",array('class'=>'img-responsive cindy_nesoberi'));
?>
<div id="footwrap">
    <div id="foothed">
    </div>
    <div id="fw">
    <div id="footer">
        <?php
            echo "<center>";
            echo "<a class=\"text-big2\" href=\"" . $this->Html->url('/main/mail') . "\">問い合わせ</a>　\n";
            echo "<a class=\"text-big2\" href=\"" . $this->Html->url('/main/kiyaku') . "\">利用規約</a>　\n";
            echo "</center>";
            echo "<br />";
            echo "<center>";
            echo "※OPENウミガメは<a class=\"text-big1\" href=\"" . $this->Html->url('http://sui-hei.net/') . "\">開発元の本家サイト「ラテシン」</a>にてソースが公開されています。\n";
            echo "</center>";
        ?>
    </div>
</div>
</div>
