<?php
class Degreelink extends AppModel {

    public $name = 'Degreelink';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'fields' => array('User.id','User.name'),
            'foreignKey' => 'user_id',
            'conditions' => '',
            'order' => ''
        ),
        'Degree' => array(
            'className' => 'Degree',
            'fields' => array('Degree.id','Degree.content'),
            'foreignKey' => 'degree_id',
            'conditions' => '',
            'order' => ''
        ),
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
                    'User.name' => 'desc',
            );
            array_push($queryData['order'],$this->order);
            $this->order = array();
        }
        return $queryData;
    }
}
?>
