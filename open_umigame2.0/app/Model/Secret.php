<?php
class Secret extends AppModel {

    public $name = 'Secret';
    public $order = array('Secret.created DESC');
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
