<?php
class AppController extends Controller {

    public $uses = array('Mondai','User','Resq','Chat','Soudan','Lobby','Degree','Minimail');
    public $helpers = array('Html','Form','Js');
    public $components = array('Auth','Session','Cookie','RequestHandler');

    function beforeRender(){
        $this->Cookie->domain = 'domain.com';
        //ミニメール未読
        if (!empty(AuthComponent::user('id'))){
            $newmail = $this->Minimail->find('count',array(
                    'conditions' => array(
                            'Minimail.to' => AuthComponent::user('id'),
                            'Minimail.midoku' => 1,
                    ),
                    'recursive' => '1'
            )
            );
            $this->set('newmail',$newmail);
        }


        //アクセス規制　ユーザーID
        if (!empty(AuthComponent::user('id'))){
            $k1 = "arashiUP2";
            if ($k1 == AuthComponent::user('username')){
                $this->cakeError('error404');
            }
        }
        //アクセス規制　IP
        $ip = $this->RequestHandler->getClientIP();
        //一人目
        $kk1 = preg_match('/^36.3./', $ip);
        if ($kk1 == 1){
            $this->cakeError('error404');
        }
    }
}
?>
