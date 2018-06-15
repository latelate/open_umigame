<?php
class Resq extends AppModel {

    public $name = 'Resq';
    public $order = 'Resq.id ASC';
    public $validate = array(
        'content' => array(
            array(
                'rule' => array('maxLengthJP','300'),
                'message' => '文章が長すぎます。字数制限は300文字までです。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => '質問が未入力です。'
            ),
            array(
                'rule' => array('space_only'),
                'message' => '空白以外の文字もご記入下さい'
            ),
        ),
        'answer' => array(
            array(
                'rule' => array('maxLengthJP','300'),
                'message' => '文章が長すぎます。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => '回答が未入力です。'
            ),
            array(
                'rule' => array('space_only'),
                'message' => '空白以外の文字もご記入下さい'
            ),
        ),
        'hint' => array(
            array(
                'rule' => array('maxLengthJP','300'),
                'message' => '文章が長すぎます。'
            ),
            array(
                'rule' => array('space_only'),
                'message' => '空白以外の文字もご記入下さい'
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
    // デフォルトのソート条件は何もなし
    //public $order = array();

    function setOrder($order) {
        //controllerから渡された$orderを変数に持っておく
        $this->order = $order;
    }

    function beforeFind($queryData) {
        // 実行中のfindの種別が'count'以外だった場合のみ、
        // ソート条件を追加し、$orderを初期化する
        if ($this->findQueryType != 'count' ){
            $this->order = array(
                    //'User.modified' => 'desc'
            );
            array_push($queryData['order'],$this->order);
            $this->order = array();
        }
        return $queryData;
    }

}
?>
