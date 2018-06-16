<?php
//App::uses('AppController', 'Controller');
class LateShell extends AppShell {

    public $uses = array('Plan','Secret','Secretuse');

    function cron1day(){
        //毎日00:00に読み込まれるページ　下の文をレンタルサーバーのクロンの設定で実行しましょう
        $plan = $this->Plan->find('all');
        //現在時刻と告知時刻が一致したら削除
        if (!empty($plan)){
            for($k = 0;$k < count($plan);$k++){
                $w = date("Y-m-d 00:00:00",strtotime('-1 day'));
                $d = $plan[$k]['Plan']['plantime'];
                if ($w == $d){
                    $this->Plan->delete($plan[$k]['Plan']['id']);
                }
            }
        }
        //迷宮入り処理
        $labyrinth = $this->Mondai->find( 'all', array(
            'conditions' => array(
                'Mondai.seikai' => 1
            ),
            'recursive' => -1,
        ));
        for($k = 0;$k < count($labyrinth);$k++){//出題から一か月たつと強制解決され、出題者は出題規制がかかります。
            $arr = $labyrinth[$k]['Mondai'];
            $m = date("Y-m-d H:i:s",strtotime('-1 month'));
            $d = $arr['created'];
            if ($m > $d){
                $this->Mondai->id = $arr['id'];
                $save['Mondai']['seikai'] = 3;
                $save['Mondai']['realtime'] = 0;
                $this->Mondai->save($save);

                $this->User->id = $arr['user_id'];
                $save2['User']['kisei'] = 1;
                $this->User->save($save2);
            }
        }
    }
    function cron1hour(){
        $secretuse = $this->Secretuse->find('all');
        if (!empty($secretuse)){
            for($k = 0;$k < count($secretuse);$k++){
                $w = date("Y-m-d H:i:s",strtotime('-1 hour'));
                $d = $secretuse[$k]['Secretuse']['modified'];
                if ($w > $d){
                    $this->Secretuse->delete($secretuse[$k]['Secretuse']['id']);

                    $this->Secret->create();
                    $save['Secret']['room_id'] = $secretuse[$k]['Secretuse']['room_id'];
                    $save['Secret']['user_id'] = $secretuse[$k]['Secretuse']['user_id'];
                    $save['Secret']['nanashi'] = $secretuse[$k]['Secretuse']['nanashi'];
                    $save['Secret']['hour'] = 1;
                    $save['Secret']['flg'] = 2;
                    $this->Secret->save($save);
                }
            }
        }
    }
}
