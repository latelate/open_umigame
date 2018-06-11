<?php
class Secretroom extends AppModel {

    public $name = 'Secretroom';
    public $order = array('Secretroom.created DESC');
    public $validate = array(
        'secretid' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '部屋IDは空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => '部屋IDが未入力です'
            ),
            'rule3' => array('rule' => 'isUnique',
                'message' => 'この部屋IDは使われています。'
            ),
            array(
                'rule' => array('custom', '/^[一-龠あ-んア-ンーヽヾ^0-9a-zA-Z０-９Ａ-ｚ_-]+$/u',),
                    'message' => '使えない文字が含まれています。漢字ひらカナ全角半角英数が使えます。'
            )
        ),
        'title' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '部屋名は空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => '部屋名が未入力です'
            ),
        ),
        'content' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '部屋の説明は空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => '部屋の説明が未入力です'
            ),
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
    public $hasMany = array(
        "Secret" => array(
            'className' => 'Secret',
            'conditions' => '',
            'order' => 'Secret.created ASC',
            'dependent' => false,
            'limit' => 0,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'room_id'
        )
    );
}
?>
