<?php
class User extends AppModel {

    public $name = 'User';
    public $validate = array(
        'username' => array(
            array(
                'rule' => array('alphaNumeric'),
                'message' => '半角英数字で入力してください。'
            ),
            array(
                'rule' => array('maxLengthJP','20'),
                'message' => 'ユーザーIDは半角英数字20文字以内にしてください。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => 'IDが未入力です。'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'このIDは使われています。'
            ),
        ),
        'name' => array(
            array(
                'rule' => array('maxLengthJP','10'),
                'message' => 'ニックネームは10文字以内にしてください。'
            ),
            array(
                'rule' => 'notBlank',
                'message' => 'ニックネームが未入力です。'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'このニックネームは使われています。'
            ),
        ),
        'password_vali' => array(
                'rule' => 'notBlank',
                'message' => 'パスワードが未入力です。'
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
                    //'User.name' => 'asc',
                    'User.modified' => 'desc'
            );
            array_push($queryData['order'],$this->order);
            $this->order = array();
        }
        return $queryData;
    }

}
?>
