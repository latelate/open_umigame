<?php
echo "<div id=\"edit_tag\">";
    echo "    ".$this->Form->create(null,array('type'=>'post','url'=>'./edit_tag/' . h($param)))."\n";
    echo "        ".$this->Form->text("Tag.name",array("size" => "10"))."\n";
    echo $this->Form->error('Tag.name');
    echo "<input type=\"submit\" value=\"タグ作成\" />";
    echo "全角20文字まで、半角60文字まで。";
    echo "    ".$this->Form->end()."\n";
    for($ta = 0;$ta < count($tags);$ta++){
        $arr = $tags[$ta]['Tag'];
        echo "    ".$this->Form->create(null,array('type'=>'post','url'=>'./edit_tag/' . h($param)))."\n";
        echo "        ".$this->Form->hidden("Tag.delete",array("value" => h($arr['id'])))."\n";
        echo $this->Form->hidden('Tag.name', array('value' => $arr['name']))."\n";
        echo "<input type=\"submit\" value=\"削除\" />";
        echo "<a href='" . $this->Html->url('/mondai/tag/' . urlencode($arr['name'])) . "'>" . h($arr['name']) . "</a>";
        echo "    ".$this->Form->end()."\n";
    }
echo "</div>";
?>
