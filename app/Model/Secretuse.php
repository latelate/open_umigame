<?php
class Secretuse extends AppModel {

    public $name = 'Secretuse';
    public $order = 'Secretuse.id ASC';
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
