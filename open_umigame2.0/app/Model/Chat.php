<?php
class Chat extends AppModel {

    public $name = 'Chat';
    public $order = 'Chat.id ASC';
    public $validate = array(
        'zatudan' => array(
            array(
                'rule' => array('maxLengthJP','300'),
                'message' => '文章が長すぎます。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => '未入力です。'
            ),
        ),
         'soudan' => array(
            array(
                'rule' => array('maxLengthJP','300'),
                'message' => '文章が長すぎます。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => '未入力です。'
            ),
        ),
    );
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
