<?php
class Lobby extends AppModel {

    public $name = 'Lobby';
    public $order = 'Lobby.created DESC';
    public $validate = array(
        'content' => array(
            array(
                'rule' => 'notBlank',
                'message' => '告知文を入れてください。'
            ),
        ),
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
