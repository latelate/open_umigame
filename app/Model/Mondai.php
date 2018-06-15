<?php
class Mondai extends AppModel {

    public $name = 'Mondai';
    public $order = array('Mondai.seikai ASC','Mondai.id DESC');
    public $validate = array(
        'title' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => 'タイトルは空白以外の文字もご記入下さい'
            ),
            "rule2" => array(
                    'rule' => 'notBlank',
                    'message' => 'タイトルが未入力です'
            ),
            "rule3" => array('rule' => array('maxLengthJP','30'),
                    'message' => 'タイトルは30文字以内にしてください。'
            ),
        ),
        'content' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '本文は空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => '本文が未入力です'
            ),
        ),
        'kaisetu' => array(
            "rule1" => array('rule' => array('space_only'),
                    'message' => '解説は空白以外の文字もご記入下さい'
            ),
            "rule2" => array('rule' => 'notBlank',
                    'message' => '解説が未入力です'
            ),
        ),
        'genre' => array(
            'rule' => 'notBlank',
            'message' => '問題のジャンルが未入力です。'
        ),
        'cate' => array(
            'rule' => 'notBlank',
            'message' => 'いずれかにチェックを入れてください。'
        ),
        'keyword' => array(
            'rule' => 'notBlank',
            'message' => '検索キーワードを入れてください。'
        ),
        'comment' => array(
            'rule' => array('maxLengthJP','50'),
            'message' => '一言コメントは50文字以内にしてください。'
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
    public $hasMany = array(
        "Resq" => array(
            'className' => 'Resq',
            'conditions' => '',
            'fields' => array('Resq.mondai_id','Resq.ansflg','Resq.created','Resq.modified'),
            'order' => 'Resq.id ASC',
            'dependent' => true,
            'limit' => 0,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'mondai_id'
        ),
        "Img" => array(
            'className' => 'Img',
            'conditions' => '',
            'fields' => array('Img.mondai_id','Img.img_file_name'),
            'order' => 'Img.id ASC',
            'dependent' => true,
            'limit' => 0,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'mondai_id'
        ),
        "Indextemp" => array(
            'className' => 'Indextemp',
            'conditions' => '',
            'fields' => array('Indextemp.count'),
            'order' => 'Indextemp.id ASC',
            'dependent' => true,
            'limit' => 0,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'mondai_id'
        ),
        "Temple" => array(
            'className' => 'Temple',
            'conditions' => '',
            'fields' => array('Temple.mondai_id'),
            'order' => 'Temple.id ASC',
            'dependent' => true,
            'limit' => 1,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'mondai_id'
        ),
        "Soudan" => array(
            'className' => 'Soudan',
            'conditions' => '',
            'fields' => array('Soudan.mondai_id'),
            'order' => 'Soudan.id ASC',
            'dependent' => true,
            'limit' => 1,
            'exclusive' => true,
            'finderQuery' => '',
            'foreignKey' => 'mondai_id'
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
                    //'Mondai.genre' => 'asc',
                    'Mondai.created' => 'desc'
            );
            array_push($queryData['order'],$this->order);
            $this->order = array();
        }
        return $queryData;
    }
}
?>
