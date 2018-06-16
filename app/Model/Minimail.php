<?php
class Minimail extends AppModel {

    public $name = 'Minimail';
    public $order = 'Minimail.created DESC';
    public $validate = array(
        'content' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => 'ミニメ本文が未入力です'
            ),
        ),
    );
}
?>
