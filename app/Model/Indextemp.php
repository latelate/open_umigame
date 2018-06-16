<?php
class Indextemp extends AppModel {

    public $name = 'Indextemp';
    public $order = 'Indextemp.created ASC';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'order' => ''
        ),
        'Mondai' => array(
            'className' => 'Mondai',
            'foreignKey' => 'mondai_id',
            'conditions' => '',
            'order' => ''
        )
    );
}
?>
