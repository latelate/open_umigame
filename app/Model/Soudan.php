<?php
class Soudan extends AppModel {

    public $name = 'Soudan';
    public $order = 'Soudan.id DESC';
    public $validate = array(
        'content' => array(
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
                    'Soudan.secret' => 'asc',
                    //'Mondai.created' => 'desc'
            );
            array_push($queryData['order'],$this->order);
            $this->order = array();
        }
        return $queryData;
    }
}
?>
