<?php
class Favorite extends AppModel {

    public $name = 'Favorite';
    public $order = 'Favorite.id ASC';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user2_id',
            'conditions' => '',
            'order' => ''
        )
);
}
?>
