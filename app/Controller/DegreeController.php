<?php
class DegreeController extends AppController {

    public $name = 'Degree';
    public $uses = array('User','Degree','Degreelink','Mail','Indextemp');
    public $layout ="suihei";
    public $components = array('Session','Auth','RequestHandler','Cookie');
    public $helpers = array('Session','Html','Text','Cache');

    function index(){
        //*ナビゲーションフラグ
        $naviflg = "lobby";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "degree";
        $this->set("subnaviflg",$subnaviflg);
        //

        //称号取得履歴
        $rireki = $this->Degreelink->find('all',array(
            'fields'=>array('Degreelink.id','Degreelink.addname','Degreelink.created','User.name','Degree.content'),
            'order'=>array('Degreelink.created'=>'desc'),
            'limit'=>10,
            )
          );
        $this->set("rireki",$rireki);

        //称号申請一覧
        $sinsei = $this->Mail->find('all',array(
                'conditions' => array(
                        'Mail.kind' => "称号申請",
                ),
                'fields'=>array(),
                'order'=>array('Mail.created'=>'desc'),
                'limit'=>5,
        )
        );
        $this->set("sinsei",$sinsei);

        //称号　選択肢表示
        $degree = $this->Degree->find('all',array(
                    'conditions' => array(
                            'NOT' => array(array('Degree.closed'=> array('2', '1'))
                            )
                    ),
                'fields' => array('Degree.content','Degree.id'),
                'order'=>array(
                        'Degree.content'=>'asc'
                ),
        )
        );
        $this->set("degree",$degree);
        foreach( $degree as $key => $val ){
            $degree2[$degree[$key]['Degree']['id']] = $degree[$key]['Degree']['content'];
        }
        $this->set("degree2",$degree2);

        //称号　表示
        $degree_data = $this->Degree->find('all',array(
                'conditions' => array('Degree.closed' => 0),
                'order'=>array(
                        'Degree.genre'=>'asc',
                        'Degree.sort'=>'asc',
                ),
        )
        );
        $this->set("degree_data",$degree_data);


        //称号取得取り消し
        if (!empty($this->data)){
            $this->Degreelink->set($this->data);
            if (!empty(AuthComponent::user('id'))){
                if ($this->Degreelink->validates()){
                    $data = $this->data;
                    if (!empty($data['Degreelink']['del'])){
                        $this->Degreelink->delete($data['Degreelink']['id']);
                        Cache::delete('cache_rireki');
                        $this->redirect('/degree');
                    }
                }
            }
        }
        //Mailフラグ
        if (!empty($this->data['Mail']['flg'])){
            $this->Mail->set($this->data);
            if (!empty(AuthComponent::user('id'))){
                if ($this->Mail->validates()){
                    $data = $this->data;
                    $this->Mail->id = $data['Mail']['id'];
                    $save['Mail']['flg'] = $data['Mail']['flg'];
                    $this->Mail->save($save);
                    Cache::delete('cache_sinsei');
                    $this->redirect('/degree');
                }
            }
        }

        //称号付与
        if (!empty($this->data['Degreelink']['user_id'])){
            if (empty($this->data['Degreelink']['yuitu'])){//唯一称号じゃなかったら通過
                if (!empty(AuthComponent::user('id'))){
                    $data = $this->data;
                    $check = $this->Degreelink->find('first',array(
                                'conditions' => array(
                                        'Degreelink.user_id' => $data['Degreelink']['user_id'],
                                        'Degreelink.degree_id' => $data['Degreelink']['degree_id'],
                                ),
                    )
                    );
                    if (empty($check)){
                        $save['Degreelink']['user_id'] = $data['Degreelink']['user_id'];
                        $save['Degreelink']['degree_id'] = $data['Degreelink']['degree_id'];
                        $save['Degreelink']['addname'] = AuthComponent::user('name');
                        $this->Degreelink->save($save);
                        Cache::delete('cache_rireki');
                        $this->redirect('/degree');
                    } else {
                        $eroor = "1";
                        $this->set("eroor",$eroor);
                    }
                }
            }
        }

        //称号申請問い合わせ
        if (!empty($this->data)){
            if (!empty(AuthComponent::user('id'))){
                $this->Mail->set($this->data);
                if ($this->Mail->validates()){
                    $data = $this->data;
                    if (!empty($data['Mail']['message'])){
                        $data['Mail']['user_id'] = AuthComponent::user('id');
                        $data['Mail']['kind'] = "称号申請";
                        $this->Mail->save($data);
                        Cache::delete('cache_sinsei');
                        $this->redirect('/degree');
                    }
                }
            }
        }

    }
    function show($param){
      //*ナビゲーションフラグ
      $naviflg = "lobby";
      $this->set("naviflg",$naviflg);
      $subnaviflg = "setumei";
      $this->set("subnaviflg",$subnaviflg);
      //
        $data = $this->Degree->find('first',array(
            'conditions' => array(
                'Degree.urlid' => $param)
            )
        );
      $this->set('data',$data);

    }

    function acquirer($param){
        //*ナビゲーションフラグ
        $naviflg = "lobby";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "acquirer";
        $this->set("subnaviflg",$subnaviflg);
        //
        $title = $this->Degree->find('first',array(
            'conditions' => array(
                'Degree.id' => $param)
            )
        );
        $this->set('title',$title);

        $this->paginate = array(
          'Degreelink'=> array(
              'page'=>1,
              'conditions'=>array(
                  'Degreelink.degree_id' => $param,
              ),
              'fields'=>array('Degreelink.addname','Degreelink.created',
                      'User.id','User.name',
              ),
              'order'=>array(
                      'Degreelink.created'=>'desc',
              ),
              'limit'=>20,
              'recursive'=>2
          ),
        );

        $this->set("data",$this->Paginate('Degreelink'));

    }

    function beforeFilter(){
      $this->Auth->allow(
          'index',
          'show',
          'acquirer'
      );
    }
}
?>
