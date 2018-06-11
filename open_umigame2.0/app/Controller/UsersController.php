<?php
class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User','Mondai');
    public $layout ="suihei";
    public $components = array('Auth','RequestHandler','Cookie');
    public $helpers = array('Js');

    public function login() {
        //*ナビゲーションフラグ
        $naviflg = "home";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "login";
        $this->set("subnaviflg",$subnaviflg);
        //
        //ここから先はautoRedirect が false にセットされている時、つまり beforeFilter でだけ動作

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect('/mondai');
            }
        }
    }

    public function logout(){
        $this->Auth->logout();
        $cookie = $this->Cookie->read('Auth.User');
        $r = $this->referer();
        if ($r == "/mondai"){
            $this->redirect('/mondai');
        } elseif ($r == "/") {
            $this->redirect('/');
        } else {
            $this->redirect('/');
        }
    }

    public function add(){
        //*ナビゲーションフラグ
        $naviflg = "home";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "useadd";
        $this->set("subnaviflg",$subnaviflg);
        //
        if (!empty($this->data)){
            if ($this->data) {
                $this->User->set($this->data);
                if ($this->User->validates()){
                    $data = $this->data;
                    $this->User->create();
                    $data['User']['ip'] = $this->RequestHandler->getClientIP();
                    $data['User']['password'] = $this->Auth->password( $this->data['User']['password_vali']);
                    $this->User->save($data);
                    $this->Session->setFlash('登録しました！さっそくログインしよう！', 'default', array('class' => 'f-message'));
                    $this->redirect('/users/login');
                    //$this->set("kanryou","登録完了");
                }
            }
        }
    }

    public function beforeFilter(){
        $this->Auth->autoRedirect = false;
        $this->Auth->allow('login','logout','add');
        $this->Auth->authError = " ";
    }
}
?>
