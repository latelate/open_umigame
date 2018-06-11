<?php
        App::import('Vendor', 'include_path');
        App::import('Vendor', 'Services', array('file'=>'Twitter.php'));
class AdminController extends AppController {

    public $name = 'Admin';
    public $uses = array('User','Mondai','Resq','Chat','Soudan','Lobby','Image','Tag','Plan',
    'Mail','Indextag','Degree','Degreelink','Temple','Indextemp','Minimail','Secret','Secretuse');
    public $layout = "suihei";
    public $components = array('Session','Auth','RequestHandler','Cookie');
    public $helpers = array('Session','Html','Text');
    public $paginate = array(
        'Mondai'=> array(
            'page'=>1,
            'conditions'=>array(),
            'fields'=>array('Mondai.id','Mondai.title','Mondai.realtime','Mondai.seikai','Mondai.created',
            'Mondai.modified','Mondai.kaisetu','Mondai.comment','Mondai.stime','Mondai.scount',
            'Mondai.genre','Mondai.textflg','Mondai.guro','Mondai.delete','Mondai.twitter',
            'User.id','User.name'),
            'sort'=>'id',
            'limit'=>40,
            'direction'=>'desc',
            'recursive'=>0
        ),
        'User'=> array(
            'page'=>1,
            'conditions'=>array(),
            'fields'=>array('User.id','User.ip','User.name','User.created','User.modified'),
            'sort'=>'id',
            'limit'=>40,
            'direction'=>'desc',
            'recursive'=>0
        ),
        'Resq'=> array(
            'page'=>1,
            'conditions'=>array(),
            'fields'=>array('Resq.id','Resq.user_id','Resq.mondai_id','Resq.content','Resq.answer','Resq.hint',
                                    'Resq.ediqcont','Resq.ediacont','Resq.created','Resq.modified','User.name'),
            'sort'=>'id',
            'limit'=>40,
            'direction'=>'desc',
            'recursive'=>1
        ),
        'Degreelink'=> array(
            'page'=>1,
            'conditions'=>array(),
            'fields'=>array('Degreelink.id','Degreelink.user_id','Degreelink.degree_id','Degree.id',
            'Degree.content','User.id','User.password','User.name','User.degree'),
            'sort'=>'',
            'limit'=>80,
            'direction'=>'asc',
            'recursive'=>1
        ),
        'Mail'=> array(
            'page'=>1,
            'conditions'=>array('NOT' => array('Mail.kind' => "称号申請")),
            'sort'=>'',
            'limit'=>10,
            'direction'=>'asc',
            'recursive'=>1
        ),
    );

    function index(){

        //管理人認証
        switch (AuthComponent::user('flg')) {
            case null:
                throw new NotFoundException();
                break;
            case '1':
                throw new NotFoundException();
                break;
        }
        //問い合わせ表示
        $this->set('maildata',$this->Paginate('Mail'));
    }

    function degree(){
      //管理人認証
      switch (AuthComponent::user('flg')) {
        case null:
          throw new NotFoundException();
          break;
        case '1':
          throw new NotFoundException();
          break;
      }
      $this->set('data2', $this->Paginate('Degreelink'));
      //新規称号
      if (!empty($this->data)){
        if (!empty($this->data['Degree']['sinki'])){
          $data = $this->data;
          $save['Degree']['urlid'] = uniqid();
          $save['Degree']['content'] = $data['Degree']['content'];
                $save['Degree']['condition'] = $data['Degree']['condition'];
                $save['Degree']['explanation'] = $data['Degree']['explanation'];
                $save['Degree']['genre'] = $data['Degree']['genre'];
                $save['Degree']['sort'] = $data['Degree']['sort'];
                $save['Degree']['closed'] = $data['Degree']['closed'];
                $this->Degree->save($save);
              $this->redirect('/admin/degree');
        }
      }
        //称号
        $degree = $this->Degree->find('all',array(
            'fields' => array('Degree.content','Degree.id')
            )
        );
        foreach( $degree as $key => $val ){
            $degree2[$degree[$key]['Degree']['id']] = $degree[$key]['Degree']['content'];
        }
        $degree2['0'] = "表示しない。";
        $this->set("degree2",$degree2);

        $data = $this->Degree->find('all',array(
          'order'=>'Degree.sort'
            )
          );
        $this->set("data",$data);

      //称号付与
      if (!empty($this->data)){
        if (!empty($this->data['Degreelink']['user_id'])){
          $data = $this->data;
          $save['Degreelink']['user_id'] = $data['Degreelink']['user_id'];
          $save['Degreelink']['degree_id'] = $data['Degreelink']['degree_id'];
          $this->Degreelink->save($save);
          $this->redirect('/admin/degree');
        }
      }
      //称号更新
      if (!empty($this->data)){
        if (!empty($this->data['User']['id'])){
          $data = $this->data;
          $this->User->id = $data['User']['id'];
          $save['User']['degree'] = $data['Degree']['content'];
          $save['User']['password'] = $data['User']['password'];
          $this->User->save($save);
          $this->redirect('/admin/degree');
        }
      }
        //称号順番の更新
        if (!empty($this->data[0]['Degree']['id'])){
          $data = $this->data;
          foreach ( $data as $key => $val ) {
              $save = array();
              if (!empty($data[$key]['Degree']['sort'])){
                  $this->Degree->id = $data[$key]['Degree']['id'];
                  $save['Degree']['sort'] = $data[$key]['Degree']['sort'];
                  $this->Degree->save($save);
                  $re = "ok";
              }
                if (isset($data[$key]['Degree']['new'])){
                  $this->Degree->id = $data[$key]['Degree']['id'];
                  $save['Degree']['new'] = $data[$key]['Degree']['new'];
                  $this->Degree->save($save);
                    $re = "ok";
                }
            }
          if (!empty($re)){
              $this->redirect('/admin/degree');
          }
        }
      //称号編集
      if (!empty($this->data)){
        if (!empty($this->data['Degree']['edit'])){
          $data = $this->data;
          $this->Degree->id = $data['Degree']['id'];
          $save['Degree']['content'] = $data['Degree']['content'];
                $save['Degree']['condition'] = $data['Degree']['condition'];
                $save['Degree']['explanation'] = $data['Degree']['explanation'];
                $save['Degree']['genre'] = $data['Degree']['genre'];
                $save['Degree']['sort'] = $data['Degree']['sort'];
                $save['Degree']['closed'] = $data['Degree']['closed'];
                $this->Degree->save($save);
              $this->redirect('/admin/degree');
        }
      }
        //称号取得履歴
        $rireki = $this->Degreelink->find('all',array(
            'fields'=>array('Degreelink.id','Degreelink.created','User.name','Degree.content'),
            'order'=>array('Degreelink.created'=>'desc'),
            'limit'=>25,
            )
          );
        $this->set('rireki',$rireki);
        //称号取得取り消し
        if (!empty($this->data)){
            $this->Degreelink->set($this->data);
            if ($this->Degreelink->validates()){
                $data = $this->data;
                if (!empty($data['Degreelink']['del'])){
                    $this->Degreelink->delete($data['Degreelink']['id']);
                    $this->redirect('/admin/degree');
                }
            }
        }
    }
    function delete($param){
        //ナビゲーションフラグ
        $naviflg = "delete";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "delete";
        $this->set("subnaviflg",$subnaviflg);
        //
        //管理人認証
        switch (AuthComponent::user('flg')) {
            case null:
                throw new NotFoundException();
                break;
            case '1':
                throw new NotFoundException();
                break;
        }
        if (!empty($param)){
            $data = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.id' => $param)
                )
            );
            $this->set('param',$param);
        }
        if (empty($data)){
            $data['Mondai']['content'] = null;
        }
        $this->set("data",$data);
        if (!empty($this->data)){
            if (!empty(AuthComponent::user('id'))){
                if ($this->data['Mondai']['delete'] == "delete"){
                    $this->Mondai->delete($data['Mondai']['id']);
                    $this->redirect('delete/' . $param);
                }
            }
        }
    }
    function beforeFilter(){
        //*ナビゲーションフラグ
        $naviflg = "admin";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "admin";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->Auth->authError = " ";
    }
}
?>
