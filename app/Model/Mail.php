<?php
class Mail extends AppModel {

    public $name = 'Mail';
    public $order = 'Mail.id DESC';
    public $validate = array(
        'message' => array(
            'rule' => 'notBlank',
            'message' => 'メッセージが未入力です。'
        )
    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'order' => ''
        )
    );
}
?>
