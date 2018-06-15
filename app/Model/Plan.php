<?php
class Plan extends AppModel {

    public $name = 'Plan';
    public $order = 'Plan.plantime ASC';
    public $validate = array(
        'content' => array(
            array(
                'rule' => 'notBlank',
                'message' => '告知文を入れてください。'
            ),
        ),
        'plantime' => array(
            array(
                'rule' => 'notBlank',
                'message' => '告知時刻を設定してください。'
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
