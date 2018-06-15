<?php
class MainController extends AppController {

    public $name = 'Main';
    public $uses = array('User','Mondai','Mail','Resq','Indextemp');
    public $layout ="suihei";
    public $components = array('Session','Auth','RequestHandler','Cookie','Permissiontag');
    public $helpers = array('Session','Js','Text','Html','Cache');
    public $cacheAction = array(
    );
    function index(){

        //*ナビゲーションフラグ
        $naviflg = "home";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "home";
        $this->set("subnaviflg",$subnaviflg);
        //
        $order = array();
        $this->Mondai->setOrder($order);
        $this->Mondai->recursive = 2;

        //アコーディオンjs
        $this->set("secretjs","secretjs");


        //ブックマークランダム表示
        $temprand = $this->Indextemp->find('all',array(
                'fields' => array('Mondai.id','Mondai.title','Mondai.content','Mondai.genre',
                                    'Mondai.stime','Mondai.timelog','Mondai.scount','Mondai.seikai',
                                    'Mondai.realtime','Mondai.summary','Mondai.delete','Mondai.created','Mondai.modified',
                                    'User.id','User.name','Indextemp.count'),
                'conditions' => array(
                        'Mondai.delete' => 1,
                        'Indextemp.count >=' => '2'
                ),
                'order'=>'rand()',
                'recursive'=>'1',
                'limit'=>'6'
        )
        );
        $this->set('temprand',$temprand);
    }
    function rule(){
        //*ナビゲーションフラグ
        $naviflg = "rule";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "rule";
        $this->set("subnaviflg",$subnaviflg);
        //
        //シンディの発言指定
        $cindy_speech = "私はラテシンのマスコットキャラクターのシンディ！よろしくね";
        $this->set('cindy_speech', $cindy_speech);
    }
    function mail(){
        //*ナビゲーションフラグ
        $naviflg = "home";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mail";
        $this->set("subnaviflg",$subnaviflg);
        //

        if (!empty($this->data)){
            $this->Mail->set($this->data);
            if ($this->Mail->validates()){
                $data = $this->data;
                if (!empty($data['Mail']['message'])){
                    if (empty(AuthComponent::user('id'))){
                        $data['Mail']['user_id'] = '0';
                    } else {
                        $data['Mail']['user_id'] = AuthComponent::user('id');
                    }
                    $this->Mail->save($data);
                    $this->Session->setFlash('送信しました！', 'default', array('class' => 'f-message'));
                    $this->redirect('');
                }
            }
        }
    }
    function maintenance() {
        //*ナビゲーションフラグ
        $naviflg = "home";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "maintenance";
        $this->set("subnaviflg",$subnaviflg);
        //
    }
    function kiyaku(){
        //*ナビゲーションフラグ
        $naviflg = "rule";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "kiyaku";
        $this->set("subnaviflg",$subnaviflg);
        //
    }
    function beforeFilter(){
        $this->Auth->allow(
            'index',
            'rule',
            'mail',
            'maintenance',
            'kiyaku'
        );
    }
}
?>
