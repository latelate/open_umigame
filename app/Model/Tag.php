<?php
class Tag extends AppModel {

    public $name = 'Tag';
    public $order = 'Tag.id ASC';
    public $validate = array(
        'name' => array(
            array(
                'rule' => array('maxLengthJP','20'),
                'message' => '文章が長すぎます。字数制限は20文字までです。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => '評価点数が未入力です。'
            ),
        ),
    );
    public $belongsTo = array(
        'Mondai' => array(
            'className' => 'Mondai',
            'foreignKey' => 'mondai_id',
            'conditions' => '',
            'order' => ''
        )
    );
}
?>
