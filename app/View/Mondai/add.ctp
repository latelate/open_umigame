<?php
echo $this->Html->script('add.js', false) ."\n";
echo "<div class=\"black-bar margin_b50\"><h1>出題する</h1></div>";
?>
<div id='mondai'>
<?php
    if(!empty(AuthComponent::user('id'))){
        if (!empty($tajyuu)){
            echo "<h2><Font Color=\"#ff0000\"><b>【問題Error！】問題投稿してから10分間は投稿できません。(すでに問題が投稿されてる場合もあるので確認してください)</b></Font></h2><br />";
        }
        if (!empty($kisei)){
            echo "<h2><Font Color=\"#ff0000\"><b>【問題Error！】迷宮入りの問題があるので、投稿規制が処置されました。詳しくはルール説明にて。</b></Font></h2><br />";
        }
        echo $this->Form->create(null,array('type'=>'post','url'=>'./add','onsubmit'=>"return disableForm()"))."\n";
        echo "<table class=\"mondai_table padding20\">\n";
        echo $this->Form->hidden("mode",array("value" => "confirm"))."\n";
        $genre = array();
        $genre['1'] = "ウミガメのスープ\n";
        $genre['2'] = "20の扉\n";
        $genre['3'] = "亀夫君問題\n";
        $genre['4'] = "新・形式\n";

        echo "<tr class=\"kage\"><td>\n";
        echo "<b>問題のジャンルを選択※必須</b>";
        echo $this->Form->radio("Mondai.genre",$genre,array('class'=>'continent','legend' => false))."\n";
        echo "<Font Color=\"#ff0000\"><b>" . $this->Form->error('Mondai.genre') . "</b></Font>\n";
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo $this->Form->text('Mondai.title',array("size" => "50",'placeholder'=>'タイトルを入力してください。※必須'))."\n";
        echo "<Font Color=\"#ff0000\"><b>" . $this->Form->error('Mondai.title') . "</b></Font>\n";
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo $this->Form->textarea('Mondai.content',array("cols" => "50","rows" => "5",'placeholder'=>'問題文を入力してください。(編集不可)※必須'));
        echo "<Font Color=\"#ff0000\"><b>" . $this->Form->error('Mondai.content') . "</b></Font>\n";
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo $this->Form->textarea('Mondai.kaisetu',array("cols" => "50","rows" => "5",'placeholder'=>'解説を入力してください。(編集可)※必須'));
        echo "<Font Color=\"#ff0000\"><b>" . $this->Form->error('Mondai.kaisetu') . "</b></Font>\n";
        echo "</td></tr>\n";
        echo "<tr class=\"zikan kage\"><td>\n";
        echo "<b>制限時間を設定(任意)</b>";
        echo $this->Form->radio("Mondai.stime",array(
                            'nosetup'=>'設定しない'."\n",
                            '+30 minute'=>'30分'."\n",
                            '+1 hour'=>'1時間'."\n",
                            '+3 hour'=>'3時間'."\n",
                            '+6 hour'=>'6時間'."\n",
                            '+12 hour'=>'12時間'."\n",
                            '+1 day'=>'1日'."\n",
                            '+3 day'=>'3日'."\n",
                            '+7 day'=>'1週間'."\n"
                            ),array('value'=>'nosetup','legend' => false))."\n";
        echo "<br />";
        echo "30分や1時間などの制限は夜等、人の多い時間帯に設定することをオススメします。";
        echo "</td></tr>\n";
        echo "<tr class=\"situ\"><td>\n";
        echo "<b>質問数制限を設定(任意)</b>";
        echo $this->Form->radio("Mondai.scount",array(
                'nosetup'=>'設定しない'."\n",
                '1'=>'1回'."\n",
                '3'=>'3回'."\n",
                '10'=>'10回'."\n",
                '20'=>'20回'."\n",
                '50'=>'50回'."\n",
                '100'=>'100回'."\n"
            ),array('value'=>'nosetup','legend' => false))."\n";
        echo "</td></tr>\n";
        echo "<tr class=\"kaigyo kage\"><td class=\"kaigyo\">\n";
        echo $this->Form->checkbox("Mondai.textflg",array('checked'=>false,'value'=>1))."改行できる長文質問の使用を許可(出題後変更可)\n";
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo $this->Form->checkbox("Mondai.nanashi",array('checked'=>false,'value'=>2))."ユーザーの発言の名前非公開を許可(出題後変更可)\n";
        echo "</td></tr>\n";
        echo "<tr class=\"kage\"><td>\n";
        echo $this->Form->checkbox("Mondai.itijinanashi",array('checked'=>false,'value'=>2))."解説出すまで名前を非表示に(出題後変更可)\n";
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo $this->Form->checkbox("Mondai.yami",array('checked'=>false,'value'=>2))."闇スープ形式に(出題後変更可)\n";
        echo "</td></tr>\n";
        echo "<tr><td><center><input type=\"submit\" value=\"確認画面へ行く\" /></center></td></tr>\n";
        echo "</table></form>\n";
    } else {
        echo 'ゲストの方は質問できません、ログインまたは登録してください。';
    }
?>
<Font Color="#ff0000">
＜＜注意事項＞＞<br />
エラー文が出た場合、時間制限などが設定できなくなる事がありますので、その時は更新してください。<br />
</Font>
<br />
<br />
</div>
