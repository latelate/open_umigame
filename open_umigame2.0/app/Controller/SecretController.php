<?php
class SecretController extends AppController {

    public $name = 'Secret';
    public $uses = array('Secret','User','Secretroom','Secretuse','Favorite');
    public $layout ="suihei";
    public $components = array('Auth','RequestHandler');
    public $helpers = array('Js','Cache');
    public $cacheAction = array(
    );
    function index(){
        //*ナビゲーションフラグ
        $naviflg = "secret";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "chat";
        $this->set("subnaviflg",$subnaviflg);
        //

        //お気に入り削除
        if (!empty($this->data['Favorite']['del'])){
            $this->Favorite->set($this->data);
            if ($this->Favorite->validates()){
                $data = $this->data;
                if (!empty($data['Favorite']['del'])){
                    if (!empty(AuthComponent::user('id'))){
                        $this->Favorite->delete($data['Favorite']['id']);
                        Cache::delete('cache_secret_fav_data_'.AuthComponent::user('id'));
                        $this->redirect('/secret');
                    }
                }
            }
        }
        //お気に入り
        if (!empty(AuthComponent::user('id'))){
            $secret_fav_data = $this->Favorite->find('all',array(
                'fields' => array('Favorite.id','Favorite.user_id','Favorite.secretid','Favorite.title','User.id','User.name'),
                'conditions' => array(
                    'Favorite.user_id' => AuthComponent::user('id')),
                            'recursive' => '0'
                )
            );
            $this->set("secret_fav_data",$secret_fav_data);
        }
        //作った部屋表示
        if (!empty(AuthComponent::user('id'))){
            $secret_data = $this->Secretroom->find('all',array(
                'fields' => array('Secretroom.id','Secretroom.user_id','Secretroom.secretid','Secretroom.title'),
                'conditions' => array(
                    'Secretroom.user_id' => AuthComponent::user('id')),
                    'recursive' => '0'
                )
            );
            $this->set("secret_data",$secret_data);
        }
        //公開された部屋
        $this->paginate = array(
            'Secretroom'=> array(
                'page'=>1,
                'conditions'=>array(
                    'Secretroom.open' => '2'
                ),
                'fields' => array('Secretroom.id','Secretroom.user_id','Secretroom.secretid','Secretroom.title','Secretroom.open'),
                'sort'=>'id',
                'direction'=>'desc',
                'limit'=>20,
                'recursive'=>2
            ),
        );
        $this->set("open_data",$this->Paginate('Secretroom'));

        //入室
        if (!empty($this->data)){
            $this->Secretroom->set($this->data);
            $data = $this->data;
            if (!empty($data['Secretroom']['secretid'])){
                //暗号化
                $angou = openssl_encrypt($data['Secretroom']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
                $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
                $this->redirect('/secret/show/' . $angou);
            }
        }

    }
    function add(){
        //*ナビゲーションフラグ
        $naviflg = "secret";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "secretadd";
        $this->set("subnaviflg",$subnaviflg);
        //

        //チャット作成
        if (!empty($this->data)){
            $this->Secretroom->set($this->data);
            if ($this->Secretroom->validates()){
                $data = $this->data;
                if (!empty($data['Secretroom']['secretid'])){
                    if (!empty(AuthComponent::user('id'))){
                        $data['Secretroom']['user_id'] = AuthComponent::user('id');
                        $data['Secretroom']['secretid'] = h($data['Secretroom']['secretid']);
                        $data['Secretroom']['title'] = $data['Secretroom']['title'];
                        $this->Secretroom->save($data);
                        Cache::delete('cache_secret_data_'.AuthComponent::user('id'));
                        $message = h($data['Secretroom']['secretid']);
                        $this->set("message",$message);
                    }
                }
            }
        }

    }
    function show($param){

        $param_moto = $param;
        $this->set('param',urlencode($param));


        //openssl
        $param = str_replace(array('_','-', '.'), array('+', '/', '='), $param);
        $param = openssl_decrypt($param, 'AES-128-ECB', DEFINE_secretkey);

        //*ナビゲーションフラグ
        $naviflg = "secret";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "secretshow";
        $this->set("subnaviflg",$subnaviflg);
        //

        //リファラー取得layoutsのbodyチェック
        $rr = $this->referer();
        $this->set('rr',urldecode($rr));

        //ルーム表示
        $roomdata = $this->Secretroom->find('first',array(
                'fields' => array('Secretroom.id','Secretroom.user_id','Secretroom.secretid',
                        'Secretroom.title','Secretroom.content','Secretroom.editflg','Secretroom.open',
                        'Secretroom.nanashiflg','Secretroom.created','Secretroom.modified','User.name'),
                'conditions' => array(
                        'Secretroom.secretid' => urldecode($param)
                ),
                'recursive' => '0'
        )
        );
        $this->set('roomdata',$roomdata);
        if(!empty($roomdata)){//キーに該当するルームが存在しているかどうか
            $read = $roomdata['Secretroom']['id'];
            $nanashiflg = $roomdata['Secretroom']['nanashiflg'];
            $title = $roomdata['Secretroom']['title'];

            //入室者表示
            $data3 = $this->Secretuse->find('all',array(
                    'fields' => array(),
                    'conditions' => array(
                            'Secretuse.room_id' => $roomdata['Secretroom']['id']
                    ),
                    'recursive' => '0'
            )
            );
            $this->set('data3',$data3);

            //暗号化
            $param = openssl_encrypt($param, 'AES-128-ECB', DEFINE_secretkey);
            $param = str_replace(array('+', '/', '='), array('_', '-', '.'), $param);

            //公開
            if (!empty($this->data['Secretroom']['flg'])){
                $postdata = $this->data;
                if (!empty($postdata['Secretroom']['open']) and AuthComponent::user('id') == $roomdata['Secretroom']['user_id']){
                    $this->Secretroom->create();
                    $this->Secretroom->id = $roomdata['Secretroom']['id'];
                    $save['Secretroom']['open'] = $postdata['Secretroom']['open'];
                    $this->Secretroom->save($save);
                    Cache::delete('cache_roomdata_'.$param_moto);
                    $this->redirect('show/' . $param);
                }
            }
            //入室してるかどうか
            if (!empty(AuthComponent::user('id'))){
                $in_flg = $this->Secretuse->find('first',array(
                        'conditions' => array(
                                'Secretuse.user_id' => AuthComponent::user('id'),
                                'Secretuse.room_id' => $roomdata['Secretroom']['id']
                        ),
                        'recursive' => '-1'
                )
                );
                $this->set('in_flg_data',$in_flg);
            }

            //お気に入りのsave
            if (!empty($this->data)){
                $this->Favorite->set($this->data);
                if ($this->Favorite->validates()){
                    $postdata = $this->data;
                    if (!empty($postdata['Favorite']['secretid'])){
                        $secret_fav_data = $this->Favorite->find('first',array(
                            'fields' => array('Favorite.id','Favorite.user_id','Favorite.secretid','Favorite.title','User.id','User.name'),
                            'conditions' => array(
                                'Favorite.user_id' => $postdata['Favorite']['user_id'],
                                'Favorite.user2_id' => $roomdata['Secretroom']['user_id'],
                                'Favorite.secretid' => $postdata['Favorite']['secretid']
                            ),
                            'recursive' => '0'
                            )
                        );
                        if(empty($secret_fav_data)){
                            $save['Favorite']['user_id'] = $postdata['Favorite']['user_id'];
                            $save['Favorite']['user2_id'] = $roomdata['Secretroom']['user_id'];
                            $save['Favorite']['secretid'] = $postdata['Favorite']['secretid'];
                            $save['Favorite']['title'] = $postdata['Favorite']['title'];
                            $this->Favorite->save($save);
                            Cache::delete('cache_secret_fav_data_'.AuthComponent::user('id'));
                        }
                        $this->redirect('show/' . $param);
                    }
                }
            }
            //発言のsave
            if (!empty($this->data)){
                $this->Secret->set($this->data);
                if ($this->Secret->validates()){
                    $postdata = $this->data;
                    if (!empty($postdata['Secret']['content'])){
                        if (!empty(AuthComponent::user('id'))){
                                if (!empty($in_flg)){//すでに入室しているかどうか
                                $save['Secret']['user_id'] = AuthComponent::user('id');
                                $save['Secret']['room_id'] = $roomdata['Secretroom']['id'];
                                $save['Secret']['content'] = $postdata['Secret']['content'];
                                $save['Secret']['nanashi'] = $in_flg['Secretuse']['nanashi'];
                                $this->Secret->save($save);
                                $this->Secretuse->id = $in_flg['Secretuse']['id'];
                                $this->Secretuse->save($save);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }


            //入室/退室のsave
            if (!empty($this->data)){
                $this->Secretuse->set($this->data);
                if ($this->Secretuse->validates()){
                    $postdata = $this->data;
                    if (!empty($postdata['Secretuse']['flg'])){
                        if (!empty(AuthComponent::user('id'))){
                            if ($postdata['Secretuse']['flg'] == 1){
                                if (empty($in_flg)){//すでに入室しているかどうか
                                    $save['Secretuse']['user_id'] = AuthComponent::user('id');
                                    $save['Secretuse']['room_id'] = $roomdata['Secretroom']['id'];
                                    if ($nanashiflg == 1){
                                        $save['Secretuse']['nanashi'] = $postdata['Secretuse']['nanashi'];
                                    }
                                    $this->Secretuse->save($save);
                                    $save['Secret']['user_id'] = AuthComponent::user('id');
                                    $save['Secret']['room_id'] = $roomdata['Secretroom']['id'];
                                    $save['Secret']['flg'] = $postdata['Secretuse']['flg'];
                                    if ($nanashiflg == 1){
                                        $save['Secret']['nanashi'] = $postdata['Secretuse']['nanashi'];
                                    }
                                    $this->Secret->save($save);
                                    Cache::delete('cache_in_flg_'.AuthComponent::user('id'));
                                    Cache::delete('cache_data3_'.$param_moto);
                                    $this->redirect('show/' . $param);
                                }
                            } elseif ($postdata['Secretuse']['flg'] == 2) {
                                $this->Secretuse->delete($in_flg['Secretuse']['id']);
                                $save['Secret']['user_id'] = AuthComponent::user('id');
                                $save['Secret']['room_id'] = $roomdata['Secretroom']['id'];
                                $save['Secret']['flg'] = $postdata['Secretuse']['flg'];
                                $save['Secret']['nanashi'] = $in_flg['Secretuse']['nanashi'];
                                $this->Secret->save($save);
                                Cache::delete('cache_in_flg_'.AuthComponent::user('id'));
                                Cache::delete('cache_data3_'.$param_moto);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }

            //タイトルのsave
            if (!empty($this->data)){
                $this->Secretroom->set($this->data);
                if ($this->Secretroom->validates()){
                    $data = $this->data;
                    if (!empty($data['Secretroom']['title'])){
                        if (!empty(AuthComponent::user('id'))){
                            $this->Secretroom->id = $read;
                            $save['Secretroom']['title'] = $data['Secretroom']['title'];
                            $this->Secretroom->save($save);
                            Cache::delete('cache_roomdata_'.$param_moto);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
            //説明文のsave
            if (!empty($this->data)){
                $this->Secretroom->set($this->data);
                if ($this->Secretroom->validates()){
                    $data = $this->data;
                    if (!empty($data['Secretroom']['content'])){
                        if (!empty(AuthComponent::user('id'))){
                            $this->Secretroom->id = $read;
                            $save['Secretroom']['content'] = $data['Secretroom']['content'];
                            $this->Secretroom->save($save);
                            Cache::delete('cache_roomdata_'.$param_moto);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
            //編集flg
            if (!empty($this->data)){
                $this->Secretroom->set($this->data);
                if ($this->Secretroom->validates()){
                    $data = $this->data;
                    if (!empty($data['Secretroom']['editflg'])){
                        if (!empty(AuthComponent::user('id'))){
                            $this->Secretroom->id = $read;
                            $save['Secretroom']['editflg'] = $data['Secretroom']['editflg'];
                            $this->Secretroom->save($save);
                            Cache::delete('cache_roomdata_'.$param_moto);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
            //名無しflg
            if (!empty($this->data)){
                $this->Secretroom->set($this->data);
                if ($this->Secretroom->validates()){
                    $data = $this->data;
                    if (!empty($data['Secretroom']['nanashiflg'])){
                        if (!empty(AuthComponent::user('id'))){
                            $this->Secretroom->id = $read;
                            $save['Secretroom']['nanashiflg'] = $data['Secretroom']['nanashiflg'];
                            $this->Secretroom->save($save);
                            Cache::delete('cache_roomdata_'.$param_moto);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
            $this->paginate = array(
                    'Secret'=> array(
                                    'page'=>1,
                            'conditions' => array(
                                    'Secret.room_id' => $roomdata['Secretroom']['id']
                            ),
                            'fields'=>array('Secret.id','Secret.room_id','Secret.user_id','Secret.content',
                                    'Secret.editcont','Secret.edit','Secret.flg','Secret.hour',
                                    'Secret.nanashi','Secret.created','User.id','User.name','User.degree','User.degreeid'
                            ),
                            'order'=>array('Secret.created'=>'desc'),
                            'limit'=>80,
                            'recursive'=>1
                            ),
            );
            $this->set("data2",$this->Paginate('Secret'));


            $this->Secretroom->id = $read;
            $this->data =  $this->Secretroom->read();
            $this->set("secretjs","secretjs");
            $this->set('title_for_layout', "" . h($title) . "");
        }

    }
    function edit($param){
        //*ナビゲーションフラグ
        $naviflg = "secret";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "secretedit";
        $this->set("subnaviflg",$subnaviflg);
        //
        $data = $this->Secret->find('first',array(
                'conditions' => array(
                    'Secret.id' => $param)
            )
        );
        $data2 = $this->Secretroom->find('first',array(
                'conditions' => array(
                    'Secretroom.id' => $data['Secret']['room_id']),
                        'recursive' => '0'
            )
        );

        if (!empty($this->data)){
            if (!empty($this->data['Secret']['content']) or !empty($this->data['Secret']['editcont'])){
                if($data['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $this->Secret->id = $param;
                    if (!empty($this->data['Secret']['content'])){
                        $save['Secret']['editcont'] = $data['Secret']['content'];
                    } elseif(!empty($this->data['Secret']['editcont'])){
                        $save['Secret']['editcont'] = $data['Secret']['editcont'];
                    }
                    $save['Secret']['edit'] = 1;
                    $this->Secret->save($save);
                }
            }
            //暗号化
            $angou = openssl_encrypt($data2['Secretroom']['secretid'], 'AES-128-ECB', DEFINE_secretkey);
            $angou = str_replace(array('+', '/', '='), array('_', '-', '.'), $angou);
            $this->redirect('/secret/show/' . $angou);
        } else {
            $this->data = $this->Secret->find('first',array(
                'conditions' => array(
                    'Secret.id' => $param)
            )
            );
            $this->set('param',$param);
            $this->set('data',$this->data);
            $this->set('data2',$data2);
        }
    }
    function beforeFilter(){
        $this->Auth->allow('index','show','add');
        $this->Auth->authError = " ";
    }
}
?>
