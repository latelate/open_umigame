<?php
App::import('Vendor', 'OAuth/OAuthClient');
config('app');
class MondaiController extends AppController {

    public $name = 'Mondai';
    public $uses = array('Mondai','User','Resq','Chat','Soudan','Lobby',
                    'Tag','Plan','Temple','Indextemp','Indextag','Degree',
                    'Degreelink','Minimail','Secret','Secretuse','Img',
    );

    public $layout ="suihei";
    public $components = array('Session','Auth','RequestHandler','Cookie');
    public $helpers = array('Session','Html','Text','Cache','Js','UploadPack.Upload');
    public $cacheAction = array(
        //'tag'=> '1 hour',
    );
    public $paginate = array(
        'Mondai'=> array(
            'page'=>1,
            'conditions'=>array('NOT' => array('Mondai.delete' => 4)),
            'fields'=>array('Mondai.id','Mondai.title','Mondai.realtime','Mondai.seikai',
            'Mondai.created','Mondai.modified','Mondai.endtime','Mondai.kaisetu',
            'Mondai.comment','Mondai.stime','Mondai.scount','Mondai.genre','Mondai.textflg',
            'Mondai.itijinanashi','Mondai.yami','Mondai.delete','Mondai.twitter',
            'User.id','User.name','User.degree','User.degree_sub','User.degreeid'),
            'order'=>array(),
            'limit'=>20,
            'recursive'=>1
        ),
        'User'=> array(
            'page'=>1,
            'conditions'=>array('NOT' => array('User.profile' => null)),
            'fields'=>array('User.id','User.name','User.profile','User.degree','User.degreeid','User.created'),
            'sort'=>'id',
            'limit'=>40,
            'direction'=>'desc',
            'recursive'=>1
        ),
        'Lobby'=> array(
            'page'=>1,
            'conditions'=>array(),
            'fields'=>array('Lobby.id','Lobby.user_id','Lobby.content','Lobby.nanashiflg',
                'Lobby.created','User.id','User.name','User.degree','User.flg','User.degreeid'),
            'sort'=>'created',
            'limit'=>10,
            'direction'=>'desc',
            'recursive'=>1
        ),
        'Indextemp'=> array(
            'page'=>1,
            'conditions'=>array('NOT' => array('Mondai.delete' => 2)),
            'fields' => array('Indextemp.id','Indextemp.mondai_id','Indextemp.user_id',
            'Indextemp.count','Indextemp.created','Mondai.id','Mondai.seikai',
            'Mondai.comment','Mondai.title','Mondai.content','Mondai.kaisetu','Mondai.created',
            'Mondai.genre','Mondai.yami','Mondai.itijinanashi',
            'User.id','User.name'),
            'order'=>array('Indextemp.count'=>'desc'),
            'limit'=>5,
            'recursive'=>1
        ),
        'Indextag'=> array(
            'page'=>1,
            'conditions'=>array('Indextag.count >=' => '1'),
            'fields'=>array('Indextag.name','Indextag.count'),
            'order'=>array('Indextag.count'=>'desc'),
            'limit'=>30,
            'direction'=>'desc',
            'recursive'=>1
        ),
    );
    function lobby(){
        //*ナビゲーションフラグ
        $naviflg = "lobby";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "lobby";
        $this->set("subnaviflg",$subnaviflg);
        //
        //シンディの発言指定
        $cindy_speech = "ここはロビー！気軽にロビチャで発言してみよう～";
        $this->set('cindy_speech', $cindy_speech);

        //昨日の問題投稿数
        $kinou = date("Y-m-d",strtotime("-1 day"));
        $kinoumondai = $this->Mondai->find( 'count', array(
                'conditions' => array(
                        'Mondai.created BETWEEN ? AND ?' => array($kinou." 00:00:00", $kinou." 23:59:59")
                ),
                'recursive' => '0',
                'limit' => 1
        ));
        $this->set("kinoumondai",$kinoumondai);

        //ロビーチャット
        $this->set('lobbylist',$this->Paginate('Lobby'));

        //告知表示
        $plan = $this->Plan->find('all', array(
                'order' => array(
                        'Plan.plantime' => 'asc'
                )
        ));
        $this->set('plan',$plan);
        //新着ブックマーク表示
        $newtemp = $this->Temple->find('all', array(
                'order' => array(
                        'Temple.modified' => 'desc'
                ),
                'limit' => 20
        ));
        $this->set('newtemp',$newtemp);


        //告知save
        if (!empty($this->data['Plan']['content'])){
            $this->Plan->set($this->data);
            if ($this->Plan->validates()){
                $data = $this->data;
                if (!empty($data['Plan']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        $save['Plan']['plantime'] = $data['Plan']['plantime'];
                        $save['Plan']['content'] = $data['Plan']['content'];
                        $save['Plan']['user_id'] = AuthComponent::user('id');
                        //連続投稿防止
                        Cache::write('Plan-renzoku-check', $save['Plan']['content']);
                        if (Cache::read('Plan-renzoku') != Cache::read('Plan-renzoku-check')){
                            $this->Plan->save($save);
                            Cache::write('Plan-renzoku', $save['Plan']['content']);
                        }
                        Cache::delete('cache_plan');
                        $this->redirect('/mondai/lobby');
                    }
                }
            }
        }
        //告知削除
        if (!empty($this->data['Plan']['del'])){
            $this->Plan->set($this->data);
            if ($this->Plan->validates()){
                $data = $this->data;
                if (!empty($data['Plan']['del'])){
                    if (!empty(AuthComponent::user('id'))){
                        $this->Plan->delete($data['Plan']['id']);
                        Cache::delete('cache_plan');
                        $this->redirect('/mondai/lobby');
                    }
                }
            }
        }

        //ロビチャ発言
        if (!empty($this->data['Lobby']['content'])){
            $this->Lobby->set($this->data);
            if ($this->Lobby->validates()){
                $data = $this->data;
                if (!empty($data['Lobby']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        $save['Lobby']['content'] = $data['Lobby']['content'];
                        $save['Lobby']['user_id'] = AuthComponent::user('id');
                        $save['Lobby']['nanashiflg'] = "1";
                        //連続投稿防止
                        Cache::write('lobby-renzoku-check', $save['Lobby']['content']);
                        if (Cache::read('lobby-renzoku') != Cache::read('lobby-renzoku-check')){
                            $this->Lobby->save($save);
                            Cache::write('lobby-renzoku', $save['Lobby']['content']);
                        }
                        $this->redirect('/mondai/lobby');
                    }
                }
            }
        }

        //ロビチャ削除
        if (!empty($this->data)){
            $this->Lobby->set($this->data);
            if ($this->Lobby->validates()){
                $data = $this->data;
                if (!empty($data['Lobby']['del'])){
                    if (!empty(AuthComponent::user('id'))){
                        if (AuthComponent::user('id') == $data['Lobby']['useid']){
                            $this->Lobby->delete($data['Lobby']['id']);
                            $this->redirect('/mondai/lobby');
                        }
                    }
                }
            }
        }

    }

    function index(){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondai";
        $this->set("subnaviflg",$subnaviflg);
        //

        //問題数
        if(! $check_mondaicount = Cache::read('mondaicount')) {
            $mondaicount_kari = $this->Mondai->find('count');
            Cache::set(Array('duration' => '+60 seconds'));
            Cache::write('mondaicount', $mondaicount_kari);
        }

        //標準ソート
        $order = array(
            'Mondai.seikai' => 'asc',
            'Mondai.endtime' => 'desc'
        );
        $this->Mondai->setOrder($order);

        $this->set('mondailist',$this->Paginate('Mondai'));
    }

    function show($param){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondaishow";
        $this->set("subnaviflg",$subnaviflg);
        //

        $this->set('param',$param);
        //リファラー取得layoutsのbodyチェック
        $rr = $this->referer();
        $this->set('rr',$rr);

        //問題文の表示
        $data = $this->Mondai->find('first',array(
                'fields' => array('Mondai.id','Mondai.title','Mondai.content','Mondai.genre','Mondai.comment',
                    'Mondai.kaisetu','Mondai.stime','Mondai.timelog','Mondai.scount','Mondai.seikai',
                    'Mondai.realtime','Mondai.summary','Mondai.itijinanashi','Mondai.yami','Mondai.nanashi',
                    'Mondai.delete','Mondai.created','Mondai.modified',
                    'Mondai.textflg','User.id','User.name','User.degree','User.degreeid'
                    ),
                    'conditions' => array(
                        'Mondai.id' => $param
                    ),
                    'recursive' => '1'
                )
        );
        $mondaiuser = $data['User']['id'];
        $mondainanashi = $data['Mondai']['nanashi'];
        $mondaiseikai = $data['Mondai']['seikai'];
        $title = $data['Mondai']['title'];
        $this->set('data',$data);

        //挿絵アップ
        if (!empty($this->data['Img']['flg'])){
            if (!empty($this->data['Img']['img']['name'])){
                if (strlen($this->data['Img']['img']['name']) == mb_strlen($this->data['Img']['img']['name'])) {
                    $data = $this->data;
                    $this->data['Img']['mondai_id'] = $param;
                    if ($this->Mondai->validates()){
                        if ($this->Img->save($this->data)) {
                            $this->redirect('show/' . $param);
                        }
                    }
                } else {
                  $error = "ファイル名に日本語は使えません。";
                  $this->set('imgerror',$error);
                }
            }
        }
        //挿絵削除
        if (!empty($this->data['Img']['delete'])) {
            if ($this->data['Img']['mondai_id'] == $param){
                // file delete
                unlink(IMAGES."img_sashie".DS.$this->data['Img']['id'].DS."thumb_".$this->data['Img']['img_file_name']);
                unlink(IMAGES."img_sashie".DS.$this->data['Img']['id'].DS."original_".$this->data['Img']['img_file_name']);
                rmdir(IMAGES."img_sashie".DS.$this->data['Img']['id']);
                $this->Img->delete($this->data['Img']['id']);
                $this->redirect('show/' . $param);
            }
        }
        //挿絵の表示（問題文）
        $sasie = $this->Img->find('first',array(
                'conditions' => array(
                        'Img.mondai_id' => $param,
                        'Img.flg' => '1')
        )
        );
        $this->set("sasie",$sasie);
        //挿絵の表示（解説）
        $sasie2 = $this->Img->find('first',array(
                'conditions' => array(
                        'Img.mondai_id' => $param,
                        'Img.flg' => '2')
        )
        );
        $this->set("sasie2",$sasie2);

        //出題者コメント
        if (!empty($this->data['Mondai']['comment'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['comment'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($param == $data['Mondai']['idc'] and $mondaiuser == AuthComponent::user('id')){
                            $this->Mondai->id = $data['Mondai']['idc'];
                            $save['Mondai']['comment'] = $data['Mondai']['comment'];
                            //連続投稿防止
                            Cache::write('MondaiComment-renzoku-check', $save['Mondai']['comment']);
                            if (Cache::read('MondaiComment-renzoku') != Cache::read('MondaiComment-renzoku-check')){
                                $this->Mondai->save($save);
                                Cache::write('MondaiComment-renzoku', $save['Mondai']['comment']);
                            }
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //公開・非公開
        if (!empty($this->data['Mondai']['delete'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['delete'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Mondai']['delete'] == 4){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['delete'] = 4;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['delete'] == 2){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['delete'] = 2;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['delete'] == 1){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['delete'] = 1;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //闇スープ
        if (!empty($this->data['Mondai']['yami'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['yami'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Mondai']['yami'] == 2){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['yami'] = 2;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['yami'] == 1){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['yami'] = 1;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //一時的名無し
        if (!empty($this->data['Mondai']['itijinanashi'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['itijinanashi'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Mondai']['itijinanashi'] == 2){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['itijinanashi'] = 2;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['itijinanashi'] == 1){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['itijinanashi'] = 1;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //
        //名無し許可
        if (!empty($this->data['Mondai']['nanashi'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['nanashi'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Mondai']['nanashi'] == 2){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['nanashi'] = 2;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['nanashi'] == 1){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['nanashi'] = 1;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //長文許可
        if (!empty($this->data['Mondai']['textflg'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['textflg'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Mondai']['textflg'] == 2){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['textflg'] = 1;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                        if ($data['Mondai']['textflg'] == 1){
                            if ($param == $data['Mondai']['idh'] and $mondaiuser == AuthComponent::user('id')){
                                $this->Mondai->id = $data['Mondai']['idh'];
                                $save['Mondai']['textflg'] = null;
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //質問レスのsave
        if (!empty($this->data['Resq']['content'])){
            $this->Resq->set($this->data);
            if ($this->Resq->validates()){
                $data = $this->data;
                if (!empty($data['Resq']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        $save['Resq']['user_id'] = AuthComponent::user('id');
                        $save['Resq']['mondai_id'] = $param;
                        $save['Resq']['content'] = $data['Resq']['content'];
                        //Resqをsave
                        //連続投稿防止
                        Cache::write('Resq-renzoku-check', $save['Resq']['content']);
                        if (Cache::read('Resq-renzoku') != Cache::read('Resq-renzoku-check')){
                            $this->Resq->save($save);

                            //user IPの追加
                            $this->User->id = AuthComponent::user('id');
                            $save['User']['ip'] = $this->RequestHandler->getClientIP();
                            $this->User->save($save);
                            Cache::delete('cache_data2_'.$param);

                            Cache::write('Resq-renzoku', $save['Resq']['content']);
                        }
                        $this->redirect('show/' . $param);
                    }
                }
            }
        }
        //回答レスのsave
        if (!empty($this->data)){
            $this->Resq->set($this->data);
            if ($this->Resq->validates()){
                $data = $this->data;
                if (!empty(AuthComponent::user('id'))){
                    if ($mondaiuser == AuthComponent::user('id')){
                        foreach ( $data as $key => $val ) {
                            $save = array();
                            if (!empty($data[$key]['Resq']['answer'])){
                                $this->Resq->id = $data[$key]['Resq']['id'];
                                $save['Resq']['ansflg'] = 1;
                                $save['Resq']['answer'] = $data[$key]['Resq']['answer'];
                                $this->Resq->data  = null;
                                $this->Resq->save($save);
                                $re = "ok";
                            }
                            if (isset($data[$key]['Resq']['fa'])){
                                $this->Resq->id = $data[$key]['Resq']['id'];
                                $save['Resq']['fa'] = $data[$key]['Resq']['fa'];
                                $this->Resq->data  = null;
                                $this->Resq->save($save);
                                $re = "ok";
                            }
                            if (isset($data[$key]['Resq']['nice'])){
                                $this->Resq->id = $data[$key]['Resq']['id'];
                                $save['Resq']['nice'] = $data[$key]['Resq']['nice'];
                                $this->Resq->data  = null;
                                $this->Resq->save($save);
                                $re = "ok";
                            }
                        }
                        if (!empty($re)){
                            Cache::delete('cache_data2_'.$param);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //質問締切
        if (!empty($this->data['Mondai']['seikai'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['seikai'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($mondaiuser == AuthComponent::user('id')){
                            if ($data['Mondai']['seikai'] == 2){
                                $this->Mondai->id = $param;
                                $save['Mondai']['seikai'] = 2;
                                $save['Mondai']['endtime'] = date("Y-m-d H:i:s");
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //解答レスのsave
        if (!empty($this->data['Chat']['tuuka']) and !empty($this->data['Chat']['kaitou'])){
            $this->Chat->set($this->data);
            if ($this->Chat->validates()){
                $data = $this->data;
                if (!empty($data['Chat']['tuuka'])){
                    if(!empty($data['Chat']['kaitou'])){
                        if (!empty(AuthComponent::user('id'))){
                            $save['Chat']['user_id'] = AuthComponent::user('id');
                            $save['Chat']['mondai_id'] = $param;
                            $save['Chat']['tuuka'] = $data['Chat']['tuuka'];
                            $save['Chat']['kaitou'] = $data['Chat']['kaitou'];
                            $this->Chat->save($save);
                            Cache::delete('cache_data3_'.$param);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //ヒントのsave
        if (!empty($this->data['Chat']['tuuka']) and !empty($this->data['Chat']['hint'])){
            $this->Chat->set($this->data);
            if ($this->Chat->validates()){
                $data = $this->data;
                if (!empty($data['Chat']['tuuka'])){
                    if(!empty($data['Chat']['hint'])){
                        if (!empty(AuthComponent::user('id'))){
                            if ($mondaiuser == AuthComponent::user('id')){
                                $save['Chat']['user_id'] = AuthComponent::user('id');
                                $save['Chat']['mondai_id'] = $param;
                                $save['Chat']['tuuka'] = $data['Chat']['tuuka'];
                                $save['Chat']['hint'] = $data['Chat']['hint'];
                                //連続投稿防止
                                Cache::write('Chat-renzoku-check', $save['Chat']['hint']);
                                if (Cache::read('Chat-renzoku') != Cache::read('Chat-renzoku-check')){
                                    $this->Chat->save($save);
                                    Cache::write('Chat-renzoku', $save['Chat']['hint']);
                                }
                                Cache::delete('cache_data3_'.$param);
                                $this->redirect('show/' . $param);
                            }
                        }
                    }
                }
            }
        }
        //現在回答中のsave
        if (!empty($this->data['Mondai']['realtime'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['realtime'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($mondaiuser == AuthComponent::user('id')){
                            $this->Mondai->id = $param;
                            $save['Mondai']['realtime'] = date("Y-m-d H:i:s");
                            $this->Mondai->save($save);
                            Cache::delete('cache_data_'.$param);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //解説のsave
        if (!empty($this->data['Mondai']['kaisetu'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['kaisetu'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($mondaiuser == AuthComponent::user('id')){
                            if ($mondaiseikai == 1){
                                $save['Mondai']['kaisetu'] = $data['Mondai']['kaisetu'];
                                $this->Mondai->save($save);
                                Cache::delete('cache_data_'.$param);
                            }
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //相談レスのsave
        if (!empty($this->data['Soudan']['content'])){
            $this->Soudan->set($this->data);
            if ($this->Soudan->validates()){
                $data = $this->data;
                if (!empty($data['Soudan']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        $save['Soudan']['user_id'] = AuthComponent::user('id');
                        $save['Soudan']['mondai_id'] = $param;
                        $save['Soudan']['content'] = $data['Soudan']['content'];
                        if ($mondainanashi == 2){
                            $save['Soudan']['nanashiflg'] = $data['Soudan']['nanashiflg'];
                        }
                        //連続投稿防止
                        Cache::write('Soudan-renzoku-check', $save['Soudan']['content']);
                        if (Cache::read('Soudan-renzoku') != Cache::read('Soudan-renzoku-check')){
                            $this->Soudan->save($save);
                            Cache::write('Soudan-renzoku', $save['Soudan']['content']);
                        }
                        Cache::delete('cache_data4_'.$param);
                        $this->redirect('show/' . $param);
                    }
                }
            }
        }
        //まとメモ帳のsave
        if (!empty($this->data['Mondai']['summary'])){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['summary'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($mondaiuser == AuthComponent::user('id')){
                            $this->Mondai->id = $param;
                            $save['Mondai']['summary'] = $data['Mondai']['summary'];
                            $this->Mondai->save($save);
                            Cache::delete('cache_data_'.$param);
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //ブックマーク追加
        if (!empty($this->data['Temple']['mondai_id'])){
            $this->Temple->set($this->data);
            if ($this->Temple->validates()){
                $data = $this->data;
                if (!empty($data['Temple']['mondai_id'])){
                    if (!empty(AuthComponent::user('id'))){
                        $temple = $this->Temple->find('all',array(
                            'conditions' => array(
                                'Temple.mondai_id' => $data['Temple']['mondai_id'])
                            )
                        );
                        $taj = 1;
                        foreach( $temple as $key => $val ){
                            if (!empty($temple)){
                                if ($temple[$key]['Temple']['name'] == AuthComponent::user('name')){
                                    $taj = 2;
                                    $templetajyuu[$data['Temple']['mondai_id']] = "すでにブックマークしています。";
                                    $this->set("templetajyuu",$templetajyuu);
                                }
                            }
                        }
                        if ($taj == 1){
                            //Templeのsave
                            $save['Temple']['mondai_id'] = $data['Temple']['mondai_id'];
                            $save['Temple']['user_id'] = $data['Temple']['user_id'];
                            $save['Temple']['name'] = AuthComponent::user('name');
                            $save['Temple']['add_user_id'] = AuthComponent::user('id');
                            $this->Temple->save($save);
                            //Indextempのsave
                            $index = $this->Indextemp->find('first',array(
                                'conditions' => array(
                                    'Indextemp.mondai_id' => $data['Temple']['mondai_id'],
                                    ),
                                    'recursive' => '-1'
                                )
                            );
                            if (empty($index)){
                                $save2['Indextemp']['mondai_id'] = $data['Temple']['mondai_id'];
                                $save2['Indextemp']['user_id'] = $data['Temple']['user_id'];
                                $save2['Indextemp']['count'] = 1;
                                $this->Indextemp->save($save2);
                            } else {
                                $this->Indextemp->id = $index['Indextemp']['id'];
                                $save2['Indextemp']['mondai_id'] = $data['Temple']['mondai_id'];
                                $save2['Indextemp']['user_id'] = $data['Temple']['user_id'];
                                $save2['Indextemp']['count'] = $index['Indextemp']['count']+1;
                                $this->Indextemp->save($save2);

                            }
                            $this->redirect('show/' . $param);
                        }
                    }
                }
            }
        }
        //--------------------------------表示--------------------------------//
        //問題の前後リンク
        $this->set ( 'neighbors', $this->Mondai->find( 'neighbors', array (
                'fields' => array('Mondai.id','Mondai.title'),
                'field'=>'id',
                'value'=>$param
        ) ) );
        //タグの表示
        $tags = $this->Tag->find('all',array(
            'conditions' => array(
                'Tag.mondai_id' => $param)
            )
        );
        $this->set("tags",$tags);
        //質問の表示
        $data2 = $this->Resq->find('all',array(
                'fields' => array('Resq.id','Resq.user_id','Resq.mondai_id',
                        'Resq.content','Resq.answer','Resq.hint',
                        'Resq.check','Resq.radio','Resq.editq',
                        'Resq.edita','Resq.ediqcont','Resq.ediacont',
                        'Resq.ansflg','Resq.fa','Resq.nice','Resq.textq',
                        'Resq.created','Resq.modified',
                        'User.id','User.name','User.degree','User.degreeid'
                    ),
                'conditions' => array(
                        'Resq.mondai_id' => $param),
                'recursive' => '0'
            )
        );
        $this->set('data2',$data2);
        //解答レスの表示
        $data3 = $this->Chat->find('all',array(
                'fields' => array('Chat.id','Chat.admin','Chat.mondai_id',
                        'Chat.kaitou','Chat.hint','Chat.edit','Chat.editcont',
                        'Chat.i','Chat.created','User.id','User.name'),
                'conditions' => array(
                        'Chat.mondai_id' => $param)
        )
        );
        $this->set("data3",$data3);
        //相談レスの表示
        $data4 = $this->Soudan->find('all',array(
                'fields' => array('Soudan.id','Soudan.user_id','Soudan.mondai_id',
                        'Soudan.edit','Soudan.editcont',
                        'Soudan.secret','Soudan.nanashiflg',
                        'Soudan.content','Soudan.created',
                        'User.id','User.name','User.flg','User.degree','User.degreeid'),
                'conditions' => array(
                        'Soudan.mondai_id' => $param),
                'recursive' => '0'
        )
        );
        $this->set("data4",$data4);

        $this->Mondai->id = $param;
        $this->data =  $this->Mondai->read();
        $this->set('title_for_layout', "" . h($title) . "");

    }
    function search(){
        //*ナビゲーションフラグ
        $naviflg = "search";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "search";
        $this->set("subnaviflg",$subnaviflg);
        //
        //検索
        if (!empty($this->data)){
            $this->Mondai->set($this->data);
            if ($this->Mondai->validates()){
                $data = $this->data;
                if (!empty($data['Mondai']['keyword'])){
                    $keyword = $data['Mondai']['keyword'];
                    $cate = $data['Mondai']['cate'];
                    $condition = array();
                    // 新規キーワード
                    // 変数を文字列に変換する
                    $new_data = strval($data['Mondai']['keyword']);
                    // 全角スペースを半角スペースに変換
                    $new_data = mb_convert_kana($new_data, "s");
                    // 左右の半角スペースを削除
                    $new_data = trim($new_data);
                    // 半角スペースの重複を、半角スペースに置き換える
                    $new_data = preg_replace("/ +/", ' ', $new_data);
                    $keyword = $new_data;
                    // 半角スペースごとに区切る
                    $new_data = explode(' ', $new_data);
                    switch ($data['Mondai']['cate']) {
                        case 'name':
                            foreach ( $new_data as $key => $val ) {
                                $or[$key] =  array("User.name like" => '%' . $val . '%');
                            }
                            $condition = array("and"=>$or);
                            break;
                        case 'content':
                            foreach ( $new_data as $key => $val ) {
                                $or[$key] =  array("Mondai.content like" => '%' . $val . '%');
                            }
                            $condition = array("and"=>$or);
                            break;
                        case 'kaisetu':
                            foreach ( $new_data as $key => $val ) {
                                $or[$key] =  array("Mondai.kaisetu like" => '%' . $val . '%');
                            }
                            $condition = array("and"=>$or);
                            break;
                        case 'title':
                            foreach ( $new_data as $key => $val ) {
                                $or[$key] =  array("Mondai.title like" => '%' . $val . '%');
                            }
                            $condition = array("and"=>$or);
                            break;
                    }
                    $searchword = array( "keyword" => urlencode( $keyword ),
                                 "cate" => urlencode( $cate )
                    );
                    $this->set('searchword', $searchword);
                    $this->set('condition', $condition);
                    //未解決の解説検索対策
                    $taisaku = $this->Paginate($condition);
                    foreach( $taisaku as $key => $val ){
                        if ($taisaku[$key]['Mondai']['seikai'] == 1){
                            unset($taisaku[$key]);
                        }
                    }
                    $taisaku = array_merge($taisaku);
                    $this->set('data', $taisaku);
                    $data["Mondai"]["keyword"] = $keyword;
                    $data["Mondai"]["cate"] = $cate;
                    $this->data = $data;
                } else {
                    $searchword = array();
                    $this->set('searchword', $searchword);
                    $this->set('data', $this->Paginate('Mondai'));
                }
            } else {
                $searchword = array();
                $this->set('searchword', $searchword);
                $this->set('data', $this->Paginate('Mondai'));
            }
        } elseif(count($this->passedArgs)) {
            if (!empty($this->passedArgs['keyword'])){
                $keyword = urldecode($this->passedArgs['keyword']);
                $cate = $this->passedArgs['cate'];
                $condition = array();
                // 新規キーワード
                // 変数を文字列に変換する
                $new_data = strval($keyword);
                // 全角スペースを半角スペースに変換
                $new_data = mb_convert_kana($new_data, "s");
                // 左右の半角スペースを削除
                $new_data = trim($new_data);
                // 半角スペースの重複を、半角スペースに置き換える
                $new_data = preg_replace("/ +/", ' ', $new_data);
                $keyword = $new_data;
                // 半角スペースごとに区切る
                $new_data = explode(' ', $new_data);
                switch ($this->passedArgs['cate']) {
                    case 'name':
                        foreach ( $new_data as $key => $val ) {
                            $or[$key] =  array("User.name like" => '%' . $val . '%');
                        }
                        $condition = array("and"=>$or);
                        break;
                    case 'content':
                        foreach ( $new_data as $key => $val ) {
                            $or[$key] =  array("Mondai.content like" => '%' . $val . '%');
                        }
                        $condition = array("and"=>$or);
                        break;
                    case 'kaisetu':
                        foreach ( $new_data as $key => $val ) {
                            $or[$key] =  array("Mondai.kaisetu like" => '%' . $val . '%');
                        }
                        $condition = array("and"=>$or);
                        break;
                    case 'title':
                        foreach ( $new_data as $key => $val ) {
                            $or[$key] =  array("Mondai.title like" => '%' . $val . '%');
                        }
                        $condition = array("and"=>$or);
                        break;
                }
                $searchword = array( "keyword" => urlencode( $keyword ),
                             "cate" => urlencode( $cate )
                );
                $this->set('searchword', $searchword);
                    //未解決の解説検索対策
                    $taisaku = $this->Paginate($condition);
                    foreach( $taisaku as $key => $val ){
                        if ($taisaku[$key]['Mondai']['seikai'] == 1){
                            unset($taisaku[$key]);
                        }
                    }
                    $taisaku = array_merge($taisaku);
                    $this->set('data', $taisaku);
                $data["Mondai"]["keyword"] = $keyword;
                $data["Mondai"]["cate"] = $cate;
                $this->data = $data;
            } else {
                $searchword = array();
                $this->set('searchword', $searchword);
                $this->set('data', $this->Paginate('Mondai'));
            }
        } else {
            $searchword = array();
            $this->set('searchword', $searchword);
            $this->set('data', $this->Paginate('Mondai'));
        }
    }
    function add(){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondaiadd";
        $this->set("subnaviflg",$subnaviflg);
        //

        if (!empty($this->data)){
            $data = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.user_id' => AuthComponent::user('id'))
            )
            );
            //投稿規制されてるかどうか
            $kisei = 0;
            if (AuthComponent::user('kisei') == 1){
                $kisei = 1;
            }

            //ジャンル制御
            $genre = array();
            $genre['1'] = 1;
            $genre['2'] = 2;
            $genre['3'] = 3;
            $genre['4'] = 4;

            $addtime = date("Y-m-d H:i:s",strtotime("-10 minute"));
            $this->Mondai->set($this->data);

            if ($this->Mondai->validates()){
                if (!empty($this->data['Mondai']['content'])
                                 and !empty($this->data['Mondai']['title'])
                                 and !empty($this->data['Mondai']['kaisetu'])
                                 and !empty($this->data['Mondai']['genre'])
                                 and !empty(AuthComponent::user('id'))
                                 and preg_match("/[1-5]/", $this->data['Mondai']['genre'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($this->data['Mondai']['genre'] == $genre['1']
                                        or $this->data['Mondai']['genre'] == $genre['2']
                                        or $this->data['Mondai']['genre'] == $genre['3']
                                        or $this->data['Mondai']['genre'] == $genre['4']){
                            if ($kisei == 0){//投稿規制されてるかどうか
                                if ($data['Mondai']['created'] < $addtime){//１０分連続投稿規制
                                    $data = $this->data;
                                    if (!empty($data['Mondai']['mode'])){//確認画面通過前
                                        if ($data['Mondai']['mode']=='confirm'){//確認画面通過前
                                            $this->set('form', $this->params['form']);
                                            $this->set('data', $this->params['data']);
                                            $this->render("confirm");
                                        }
                                    } else {//確認画面通過後
                                        if (!empty($data['Mondai']['stime'])){
                                            $data['Mondai']['timelog'] = date("Y-m-d H:i:s",strtotime($data['Mondai']['stime']));
                                        }
                                        $data['Mondai']['user_id'] = AuthComponent::user('id');
                                        if ($data['Mondai']['stime'] == 'nosetup'){//設定しない
                                            $data['Mondai']['stime'] = null;
                                            $data['Mondai']['timelog'] = null;
                                        }
                                        if ($data['Mondai']['scount'] == 'nosetup'){//設定しない
                                            $data['Mondai']['scount'] = null;
                                        }
                                        switch ($data['Mondai']['genre']) {
                                            case '1':
                                                $data['Mondai']['scount'] = null;
                                                $data['Mondai']['textflg'] = null;
                                                break;
                                            case '2':
                                                $data['Mondai']['textflg'] = null;
                                                break;
                                            case '3':
                                                $data['Mondai']['scount'] = null;
                                                $data['Mondai']['textflg'] = null;
                                                $data['Mondai']['supervise'] = 2;
                                                break;
                                            case '4':
                                                break;
                                            case '5':
                                                break;
                                        }
                                        $save = $data['Mondai'];
                                        $this->Mondai->save($save);

                                        $bot_data = $this->Mondai->find('first',array(
                                                'conditions' => array('Mondai.id' => $this->Mondai->getLastInsertID()),
                                                'fields' => array('Mondai.id','Mondai.title','Mondai.content','Mondai.comment',
                                                'Mondai.genre','Mondai.twitter','Mondai.created','User.name',
                                                'Mondai.scount','Mondai.stime','Mondai.yami','Mondai.itijinanashi'),
                                                'recursive' => '-1'
                                            )
                                        );

                                        $tweet_text = null;
                                        if ($bot_data['Mondai']['itijinanashi'] == 2) {//一時的名無し
                                            $tweet_text = $tweet_text."名無しさんによる";
                                        } else {
                                            $tweet_text = $tweet_text."[".$bot_data['User']['name']."]さんによる";
                                        }
                                        $mondaicount = $this->Mondai->find('count');
                                        $tweet_text = $tweet_text.$mondaicount."杯目のスープ！\n";
                                        if (!empty($bot_data['Mondai']['comment'])) {
                                            $tweet_text = $tweet_text."コメント「".$bot_data['Mondai']['comment']."」";
                                        }
                                        $tweet_text = $tweet_text."\n\n";
                                        switch ($bot_data['Mondai']['genre']) {
                                            case '1':
                                                $tweet_text = $tweet_text. "【ウミガメ】";
                                                break;
                                            case '2':
                                                $tweet_text = $tweet_text. "【20の扉】";
                                                break;
                                            case '3':
                                                $tweet_text = $tweet_text. "【亀夫君】";
                                                break;
                                            case '4':
                                                $tweet_text = $tweet_text. "【新・形式】";
                                                break;
                                        }
                                        if (empty($bot_data['Mondai']['stime']) and empty($bot_data['Mondai']['scount'])){
                                            $tweet_text = $tweet_text. "[制限なし]";
                                        }
                                        //制限
                                        if (!empty($bot_data['Mondai']['stime']) or !empty($bot_data['Mondai']['scount'])){
                                            $tweet_text = $tweet_text."[";
                                        }
                                        if (!empty($bot_data['Mondai']['stime'])) {
                                            $tweet_text = $tweet_text. "時間制限が";
                                            switch ($bot_data['Mondai']['stime']) {
                                                case '+30 minute':
                                                    $tweet_text = $tweet_text. "30分";
                                                    break;
                                                case '+1 hour':
                                                    $tweet_text = $tweet_text. "1時間";
                                                    break;
                                                case '+3 hour':
                                                    $tweet_text = $tweet_text. "3時間";
                                                    break;
                                                case '+6 hour':
                                                    $tweet_text = $tweet_text. "6時間";
                                                    break;
                                                case '+12 hour':
                                                    $tweet_text = $tweet_text. "12時間";
                                                    break;
                                                case '+1 day':
                                                    $tweet_text = $tweet_text. "1日";
                                                    break;
                                                case '+3 day':
                                                    $tweet_text = $tweet_text. "3日";
                                                    break;
                                                case '+7 day':
                                                    $tweet_text = $tweet_text. "1週間";
                                                    break;
                                            }
                                        }
                                        if (!empty($bot_data['Mondai']['stime']) and !empty($bot_data['Mondai']['scount'])){
                                            $tweet_text = $tweet_text. "：";
                                        }
                                        if (!empty($bot_data['Mondai']['scount'])) {
                                            $tweet_text = $tweet_text. "".$bot_data['Mondai']['scount'] . "回の質問制限";
                                        }
                                        if (!empty($bot_data['Mondai']['stime']) or !empty($bot_data['Mondai']['scount'])){
                                            $tweet_text = $tweet_text. "]";
                                        }
                                        if ($bot_data['Mondai']['yami'] == 2) {
                                            $tweet_text = $tweet_text. "[闇スープ]";
                                        }
                                        $tweet_text = $tweet_text. "\n\nOPENウミガメ2.0「".DEFINE_sitename."」問題URL：".
                                        "https://late-late.jp/mondai/show/" . h($bot_data['Mondai']['id']).
                                        "\n\n#ウミガメのスープ";

                                        $jpg = "img/bf.jpg";
                                        $afjpg= "img/af.jpg";
                                        $font = "font/SourceHanSerif-Bold.otf";

                                        $image = imagecreatefromjpeg($jpg);
                                        $color = imagecolorallocate($image, 243,235,162);
                                        $titleCount = mb_strlen(h($bot_data['Mondai']['title']), "UTF-8" );//文字数カウント
                                        if( $titleCount > 20 ){
                                            imagettftext($image, 20, 0, 25, 60, $color, $font, $bot_data['Mondai']['title']);
                                        } else {
                                            imagettftext($image, 35, 0, 25, 70, $color, $font, $bot_data['Mondai']['title']);
                                        }
                                        imagejpeg($image, "img/af.jpg", 100);

                                        $text = str_replace(array("\r", "\n"), '', $bot_data['Mondai']['content']);
                                        $returnText = $text;
                                        $text_len = mb_strlen($text, "utf-8");
                                        $insert_len = mb_strlen("\n", "utf-8");
                                        $contentCount = mb_strlen(h($bot_data['Mondai']['content']), "UTF-8" );//文字数カウント
                                        if( $contentCount > 800 ){//800~
                                            $num = 90;
                                        } elseif( $contentCount > 400 ) {//400~800
                                            $num = 62;
                                        } elseif( $contentCount > 300 ) {//300~400S
                                            $num = 50;
                                        } elseif( $contentCount > 200 ) {//200~300
                                            $num = 40;
                                        } elseif( $contentCount > 100 ) {//100~200
                                            $num = 35;
                                        } elseif( $contentCount > 60 ) {//60~100
                                            $num = 33;
                                        } else {//1~50
                                            $num = 30;
                                        }
                                        for($i=0; ($i+1)*$num<$text_len; $i++) {
                                            $current_num = $num+$i*($insert_len+$num);
                                            $returnText = preg_replace("/^.{0,$current_num}+\K/us", "\n", $returnText);
                                        }
                                        $jpg = "img/af.jpg";
                                        $image = imagecreatefromjpeg($jpg);
                                        $color = imagecolorallocate($image, 0,0,0);
                                        $font = "font/SourceHanSerif-ExtraLight.otf";
                                        if( $contentCount > 800 ){//800~
                                            imagettftext($image, 8, 0, 30, 140, $color, $font, $returnText);
                                        } elseif( $contentCount > 400 ) {//400~800
                                            imagettftext($image, 12, 0, 30, 140, $color, $font, $returnText);
                                        } elseif( $contentCount > 300 ) {//300~400
                                            imagettftext($image, 14, 0, 30, 150, $color, $font, $returnText);
                                        } elseif( $contentCount > 200 ) {//200~300
                                            imagettftext($image, 18, 0, 30, 160, $color, $font, $returnText);
                                        } elseif( $contentCount > 100 ) {//100~200
                                            imagettftext($image, 20, 0, 30, 160, $color, $font, $returnText);
                                        } elseif( $contentCount > 60 ) {//60~100
                                            imagettftext($image, 22, 0, 30, 260, $color, $font, $returnText);
                                        } else {//1~50
                                            imagettftext($image, 25, 0, 30, 270, $color, $font, $returnText);
                                        }
                                        imagejpeg($image, "img/af.jpg", 100);

                                        $client = new OAuthClient(
                                            DEFINE_consumer_key, // アプリケーションのConsumer key
                                            DEFINE_consumer_secret // アプリケーションのConsumer secret
                                        );
                                        $client->postMultipartFormData(
                                            DEFINE_access_token,    // アプリケーションのaccess token
                                            DEFINE_access_token_secret,   // アプリケーションのaccess token secret
                                            'https://api.twitter.com/1.1/statuses/update_with_media.json',
                                            array(
                                                'media[]' => 'img/af.jpg'
                                            ),
                                            array(
                                                'status' => $tweet_text
                                            )
                                        );


                                        // TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください
                                        $this->Mondai->id = $this->Mondai->getLastInsertID();
                                        $save['Mondai']['twitter'] = '1';
                                        $this->Mondai->save($save);

                                        $this->redirect('/mondai/show/'.$this->Mondai->getLastInsertID());
                                    }
                                } else {//１０分連続投稿規制
                                    $tajyuu = 1;
                                    $this->set('tajyuu',$tajyuu);
                                }
                            } else {//投稿規制されてるかどうか
                                $this->set('kisei',$kisei);
                            }
                        } else {//ジャンル操作を行っていないか。
                            $janru = 1;
                            $this->set('janru',$janru);
                        }
                    }
                } else {//エラー
                    $era = 1;
                    $this->set('era',$era);
                }
            }
        }

    }
    function confirm(){
    }
    function edit($param){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondaiedit";
        $this->set("subnaviflg",$subnaviflg);
        //
        $data = $this->Resq->find('first',array(
                'conditions' => array(
                    'Resq.id' => $param)
            )
        );
        $data2 = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.id' => $data['Resq']['mondai_id']),
                        'recursive' => '0'
            )
        );

        if (!empty($this->data)){
            if (!empty($this->data['Resq']['ediqcont'])){
                if($data['User']['id'] == AuthComponent::user('id') and empty($data['Resq']['answer'])){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $this->Resq->id = $param;
                    $save['Resq']['ediqcont'] = $data['Resq']['ediqcont'];
                    if ($data2['Mondai']['textflg'] != 2){
                        $save['Resq']['textq'] = $data['Resq']['textq'];
                    }
                    $save['Resq']['editq'] = '1';
                    $this->Resq->save($save);
                }
            } elseif(!empty($this->data['Resq']['content'])){
                if($data['User']['id'] == AuthComponent::user('id') and empty($data['Resq']['answer'])){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $this->Resq->id = $param;
                    $save['Resq']['ediqcont'] = $data['Resq']['content'];
                    if ($data2['Mondai']['textflg'] != 2){
                        $save['Resq']['textq'] = $data['Resq']['textq'];
                    }
                    $save['Resq']['editq'] = '1';
                    $this->Resq->save($save);
                }
            }
            if (!empty($this->data['Resq']['ediacont'])){
                if($data2['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Resq']['ediacont'] = $data['Resq']['ediacont'];
                    $this->Resq->id = $param;
                    $save['Resq']['edita'] = '1';
                    $this->Resq->save($save);
                }
            } elseif(!empty($this->data['Resq']['answer'])){
                if($data2['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Resq']['ediacont'] = $data['Resq']['answer'];
                    $this->Resq->id = $param;
                    $save['Resq']['edita'] = '1';
                    $this->Resq->save($save);
                }
            }
            Cache::delete('cache_data2_'.h($data2['Mondai']['id']));
            $this->redirect('/mondai/show/' . h($data2['Mondai']['id']));
        } else {
            $this->data = $this->Resq->find('first',array(
                'conditions' => array(
                    'Resq.id' => $param)
            )
            );
            $this->set('param',$param);
            $this->set('data',$this->data);
            $this->set('data2',$data2);
        }
    }

    function soudanedit($param){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondaiedit";
        $this->set("subnaviflg",$subnaviflg);
        //
        $data = $this->Soudan->find('first',array(
                'conditions' => array(
                    'Soudan.id' => $param)
            )
        );
        $data2 = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.id' => $data['Soudan']['mondai_id']),
                        'recursive' => '0'
            )
        );

        if (!empty($this->data)){
            if (!empty($this->data['Soudan']['editcont'])){
                if($data['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Soudan']['editcont'] = $data['Soudan']['editcont'];
                    $this->Soudan->id = $param;
                    $save['Soudan']['edit'] = '1';
                    $this->Soudan->save($save);
                }
            } elseif(!empty($this->data['Soudan']['content'])){
                if($data['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Soudan']['editcont'] = $data['Soudan']['content'];
                    $this->Soudan->id = $param;
                    $save['Soudan']['edit'] = '1';
                    $this->Soudan->save($save);
                }
            }
            Cache::delete('cache_data4_'.$param);
            $this->redirect('/mondai/show/' . h($data2['Mondai']['id']));
        } else {
            $data = $this->Soudan->find('first',array(
                'conditions' => array(
                    'Soudan.id' => $param)
            )
            );
            $this->set('param',$param);
            $this->Soudan->id = $param;
            $this->data = $this->Soudan->read();
            $this->set('data',$data);
            $this->set('data2',$data2);
        }
    }
    function hintedit($param){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mondaiedit";
        $this->set("subnaviflg",$subnaviflg);
        //
        $data = $this->Chat->find('first',array(
                'conditions' => array(
                    'Chat.id' => $param)
            )
        );
        $data2 = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.id' => $data['Chat']['mondai_id']),
                        'recursive' => '0'
            )
        );

        if (!empty($this->data)){
            if (!empty($this->data['Chat']['editcont'])){
                if($data2['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Chat']['editcont'] = $data['Chat']['editcont'];
                    $this->Chat->id = $param;
                    $save['Chat']['edit'] = '1';
                    $this->Chat->save($save);
                }
            } elseif(!empty($this->data['Chat']['hint'])){
                if($data2['User']['id'] == AuthComponent::user('id')){
                    $this->set('data',$this->data);
                    $data = $this->data;
                    $save['Chat']['editcont'] = $data['Chat']['hint'];
                    $this->Chat->id = $param;
                    $save['Chat']['edit'] = '1';
                    $this->Chat->save($save);
                }
            }
            $this->redirect('/mondai/show/' . h($data2['Mondai']['id']));
        } else {
            $data = $this->Chat->find('first',array(
                'conditions' => array(
                    'Chat.id' => $param)
            )
            );
            $this->set('param',$param);
            $this->Chat->id = $param;
            $this->data = $this->Chat->read();
            $this->set('data',$data);
            $this->set('data2',$data2);
        }
    }
    function twitter($param){
        $data = $this->Mondai->find('first',array(
                'conditions' => array(
                    'Mondai.id' => $param)
            )
        );
        $this->set('param',$param);
        $this->set('data',$data);
    }
    function tag($param){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "taga";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);
        //標準ソート
        $order = array(
                    'Mondai.seikai' => 'asc',
                    'Mondai.created' => 'desc'
        );
        $this->Mondai->setOrder($order);
        //
        $this->paginate = array(
            'Tag'=> array(
                'page'=>1,
                'fields'=>array('Mondai.id','Mondai.title','Mondai.genre','Mondai.created',
                'Mondai.delete','Mondai.seikai','Mondai.scount','Mondai.stime','Mondai.yami',
                'Mondai.itijinanashi','Mondai.comment',),
                'conditions'=>array(
                    'Tag.name' => urldecode($param)
                ),
                'sort'=>'id',
                'direction'=>'desc',
                'limit'=>20,
                'recursive'=>0
            ),
        );
        $this->set("data2",$this->Paginate('Tag'));
    }

    function tag_search(){
        //*ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "tag_search";
        $this->set("subnaviflg",$subnaviflg);
        //

        //検索
        if (!empty($this->data)){
            $this->Indextag->set($this->data);
            if ($this->Indextag->validates()){
                $data = $this->data;
                if (!empty($data['Indextag']['keyword'])){
                    $keyword = $data['Indextag']['keyword'];
                    $condition = array();
                    // 新規キーワード
                    // 変数を文字列に変換する
                    $new_data = strval($data['Indextag']['keyword']);
                    // 全角スペースを半角スペースに変換
                    $new_data = mb_convert_kana($new_data, "s");
                    // 左右の半角スペースを削除
                    $new_data = trim($new_data);
                    // 半角スペースの重複を、半角スペースに置き換える
                    $new_data = preg_replace("/ +/", ' ', $new_data);
                    $keyword = $new_data;
                    // 半角スペースごとに区切る
                    $new_data = explode(' ', $new_data);
                    foreach ( $new_data as $key => $val ) {
                        $or[$key] =  array("Indextag.name like" => '%' . $val . '%');
                    }
                    $condition = array("and"=>$or);
                    $searchword = array( "keyword" => urlencode( $keyword ));
                    $this->set('searchword', $searchword);
                    $this->set('condition', $condition);
                    $this->set('data', $this->Paginate('Indextag',$condition));
                    $data["Indextag"]["keyword"] = $keyword;
                    $this->data = $data;
                } else {
                    $searchword = array();
                    $this->set('searchword', $searchword);
                    $this->set('data', $this->Paginate('Indextag'));
                }
            } else {
                $searchword = array();
                $this->set('searchword', $searchword);
                $this->set('data', $this->Paginate('Indextag'));
            }
        } elseif(count($this->passedArgs)) {
            if (!empty($this->passedArgs['keyword'])){
                $keyword = urldecode($this->passedArgs['keyword']);
                $condition = array();
                // 新規キーワード
                // 変数を文字列に変換する
                $new_data = strval($keyword);
                // 全角スペースを半角スペースに変換
                $new_data = mb_convert_kana($new_data, "s");
                // 左右の半角スペースを削除
                $new_data = trim($new_data);
                // 半角スペースの重複を、半角スペースに置き換える
                $new_data = preg_replace("/ +/", ' ', $new_data);
                $keyword = $new_data;
                // 半角スペースごとに区切る
                $new_data = explode(' ', $new_data);
                foreach ( $new_data as $key => $val ) {
                    $or[$key] =  array("Indextag.name like" => '%' . $val . '%');
                }
                $condition = array("and"=>$or);
                $searchword = array( "keyword" => urlencode( $keyword ));
                $this->set('searchword', $searchword);
                $this->set('data', $this->Paginate('Indextag',$condition));
                $data["Indextag"]["keyword"] = $keyword;
                $this->data = $data;
            } else {
                $searchword = array();
                $this->set('searchword', $searchword);
                $this->set('data', $this->Paginate('Indextag'));
            }
        } else {
            $searchword = array();
            $this->set('searchword', $searchword);
            $this->set('data', $this->Paginate('Indextag'));
        }
    }
    function edit_tag($param){
        //タグの表示
        $tags = $this->Tag->find('all',array(
            'conditions' => array(
                'Tag.mondai_id' => $param)
            )
        );
        $this->set('param',$param);
        $this->set("tags",$tags);
        //タグのdel
        if (!empty($this->data)){
            $this->Tag->set($this->data);
                $data = $this->data;
            if (!empty($data['Tag']['delete'])){
                $save = $data;
                $this->Tag->delete($save['Tag']['delete']);
                $index = $this->Indextag->find('first',array(
                    'conditions' => array(
                        'Indextag.name' => urldecode($data['Tag']['name']),
                        ),
                        'recursive' => '-1'
                    )
                );
                if (!empty($index)){
                    $this->Indextag->id = $index['Indextag']['id'];
                    $save2['Indextag']['count'] = $index['Indextag']['count']-1;
                    $this->Indextag->save($save2);

                }
                Cache::delete('cache_tags_'.$param);
                $this->redirect('show/' . $param);
            }
        }
        //タグのsave
        if (!empty($this->data)){
            $this->Tag->set($this->data);
            if ($this->Tag->validates()){
                $data = $this->data;
                if (!empty($data['Tag']['name'])){
                    $save['Tag']['user_id'] = AuthComponent::user('id');
                    $save['Tag']['mondai_id'] = $param;
                    $save['Tag']['name'] = $data['Tag']['name'];
                    $index = $this->Indextag->find('first',array(
                        'conditions' => array(
                            'Indextag.name' => urldecode($data['Tag']['name']),
                            ),
                            'recursive' => '-1'
                        )
                    );
                    if (empty($index)){
                        $save2['Indextag']['name'] = $data['Tag']['name'];
                        $save2['Indextag']['count'] = 1;
                        $this->Indextag->save($save2);
                        $save['Tag']['index_id'] = $this->Indextag->getLastInsertID();
                    } else {
                        $this->Indextag->id = $index['Indextag']['id'];
                        $save2['Indextag']['count'] = $index['Indextag']['count']+1;
                        $this->Indextag->save($save2);
                        $save['Tag']['index_id'] = $index['Indextag']['id'];

                    }
                    $this->Tag->save($save);
                    Cache::delete('cache_tags_'.$param);
                    $this->redirect('show/' . $param);
                }
            }
        }
    }

    function mytemple($param){
        //*ナビゲーションフラグ
        $naviflg = "page";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "mypage";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);
        //
        $this->paginate = array(
            'Temple'=> array(
                'page'=>1,
                'conditions'=>array(
                    'Temple.user_id' => $param
                ),
                'fields' => array('Temple.add_user_id','Temple.name','Temple.created','Temple.comment','Mondai.id','Mondai.title','Mondai.content',
                'Mondai.genre','Mondai.stime','Mondai.timelog','Mondai.scount','Mondai.seikai','Mondai.realtime',
                'Mondai.summary','Mondai.delete','Mondai.created','Mondai.modified','Mondai.yami'),
                'order' => array('Temple.created' => 'desc'),
                'limit'=>20,
                'recursive'=>1
            ),
        );
        $this->set("mytemple",$this->Paginate('Temple'));
    }

    function inbox($param){
        //*ナビゲーションフラグ
        $naviflg = "page";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "inbox";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);

        //受信の表示
        $this->Minimail->bindModel(array(
            'belongsTo' => array(
                'User' => array(
                                'foreignKey' => 'frm',
                                'fields' => array('User.id','User.name'),
                ))),false
            );
        $this->paginate = array(
            'Minimail'=> array(
                'page'=>1,
                'conditions'=>array('Minimail.to' => $param),
                'fields'=>array('Minimail.id','Minimail.frm','Minimail.content','Minimail.midoku','Minimail.created','User.id','User.name'),
                'sort'=>'created',
                'limit'=>40,
                'direction'=>'desc',
                'recursive'=>2
            ),
        );
        $this->set("data",$this->Paginate('Minimail'));

        //ミニメの返信
        if (!empty($this->data)){
            $this->Minimail->set($this->data);
            if ($this->Minimail->validates()){
                $data = $this->data;
                if (!empty($data['Minimail']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        if (AuthComponent::user('id') == $data['Minimail']['frm']){
                            $save['Minimail']['frm'] = $data['Minimail']['frm'];
                            $save['Minimail']['to'] = $data['Minimail']['to'];
                            $save['Minimail']['content'] = $data['Minimail']['content'];
                            $this->Minimail->save($save);
                            $this->redirect('inbox/' . $param);
                        }
                    }
                }
            }
        }

        //未読を既読に
        if (!empty($this->data)){
            $this->Minimail->set($this->data);
            if ($this->Minimail->validates()){
                $data = $this->data;
                if (!empty($data['Minimail']['midoku'])){
                    if (!empty(AuthComponent::user('id'))){
                        if ($data['Minimail']['midoku'] == 2){
                            $this->Minimail->id = $data['Minimail']['id'];
                            $save['Minimail']['midoku'] = 2;
                            $this->Minimail->save($save);
                            Cache::delete('cache_newmail_'.AuthComponent::user('id'));
                            $this->redirect('inbox/' . $param);
                        }
                    }
                }
            }
        }
    }
    function outbox($param){
        //*ナビゲーションフラグ
        $naviflg = "page";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "outbox";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);

        //送信の表示
        $this->Minimail->bindModel(array(
            'belongsTo' => array(
                'User' => array(
                                'foreignKey' => 'to',
                                'fields' => array('User.id','User.name'),
                ))),false
            );

        $this->paginate = array(
            'Minimail'=> array(
                'page'=>1,
                'conditions'=>array('Minimail.frm' => $param),
                'fields'=>array('Minimail.id','Minimail.to','Minimail.content','Minimail.created','User.id','User.name'),
                'sort'=>'created',
                'limit'=>40,
                'direction'=>'desc',
                'recursive'=>2
            ),
        );


        $this->set("data",$this->Paginate('Minimail'));

    }
    function profindex (){
        //*ナビゲーションフラグ
        $naviflg = "lobby";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "profindex";
        $this->set("subnaviflg",$subnaviflg);
        //
        //標準ソート
        $order = array(
                    'User.created' => 'desc'
        );
        $this->User->setOrder($order);
        $this->set('data', $this->Paginate('User'));
    }
    function profile($param){
        //*ナビゲーションフラグ
        $naviflg = "page";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "profile";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);
        //標準ソート
        $order = array(
                    'Mondai.seikai' => 'asc',
                    'Mondai.created' => 'desc'
        );
        $this->Mondai->setOrder($order);
        //タグの表示
        $data = $this->User->find('first',array(
            'conditions' => array(
                'User.id' => $param)
            )
        );
        $this->set("data",$data);

        //称号
        $degree = $this->Degreelink->find('all',array(
            'fields' => array('Degreelink.id','Degreelink.user_id','Degree.content','Degree.urlid'),
            'conditions' => array(
                'Degreelink.user_id' => $param)
            )
        );
        $this->set("degree",$degree);
        //問題数カウント
        $mondaicount = $this->Mondai->find('count',array(
            'conditions' => array(
                'Mondai.user_id' => $param,
            'NOT' => array('Mondai.delete' => 4))
            )
        );
        $this->set("mondaicount",$mondaicount);
        //質問数カウント
        $rescount = $this->Resq->find('count',array(
            'conditions' => array(
                'Resq.user_id' => $param)
            )
        );
        $this->set("rescount",$rescount);
        //良い質問数カウント
        $nicecount = $this->Resq->find('count',array(
            'conditions' => array(
                'Resq.user_id' => $param,
                'Resq.nice' => 1)
            )
        );
        $this->set("nicecount",$nicecount);
        //FA数カウント
        $facount = $this->Resq->find('count',array(
            'conditions' => array(
                'Resq.user_id' => $param,
                'Resq.fa' => 1)
            )
        );
        $this->set("facount",$facount);

        //チャット発言数カウント
        $secount = $this->Secret->find('count',array(
            'conditions' => array(
                'Secret.user_id' => $param)
            )
        );
        $this->set("secount",$secount);

        //ブックマークの表示
        $this->Temple->bindModel(array(
            'belongsTo' => array(
                'User' => array(
                    'foreignKey' => 'user_id',
                    'fields' => array('User.id','User.name')),
                'Mondai' => array(
                    'foreignKey' => 'mondai_id',
                    'fields'=>array('Mondai.id','Mondai.title','Mondai.realtime','Mondai.seikai','Mondai.created','Mondai.modified','Mondai.endtime',
                        'Mondai.kaisetu','Mondai.comment','Mondai.stime','Mondai.scount','Mondai.genre','Mondai.textflg',
                        'Mondai.delete'),
                    ))),false
        );
        if(!empty($data)){
            $this->paginate = array(
                'Temple'=> array(
                    'page'=>1,
                    'conditions'=>array("Temple.name like" => '' . $data['User']['name'] . ''),
                    'fields'=>array(),
                    'sort'=>'created',
                    'limit'=>7,
                    'direction'=>'desc',
                    'recursive'=>1
                ),
            );
        }
        $this->set("iine",$this->Paginate('Temple'));

        //称号
        $degree = $this->Degreelink->find('all',array(
            'fields' => array('Degreelink.id','Degreelink.user_id','Degree.id','Degree.content','Degree.urlid'),
            'conditions' => array(
                'Degreelink.user_id' => AuthComponent::user('id'))
            )
        );
        foreach( $degree as $key => $val ){
            $degree2[$degree[$key]['Degree']['content']] = $degree[$key]['Degree']['content'];
        }
        $degree2['0'] = "表示しない。";
        $this->set("degree2",$degree2);

        //ミニメのsave
        if (!empty($this->data)){
            $this->Minimail->set($this->data);
            if ($this->Minimail->validates()){
                $data = $this->data;
                if (!empty($data['Minimail']['content'])){
                    if (!empty(AuthComponent::user('id'))){
                        if (AuthComponent::user('id') == $data['Minimail']['frm']){
                            $save['Minimail']['frm'] = $data['Minimail']['frm'];
                            $save['Minimail']['to'] = $data['Minimail']['to'];
                            $save['Minimail']['content'] = $data['Minimail']['content'];
                            $this->Minimail->save($save);
                            $this->redirect('profile/' . $param);
                        }
                    }
                }
            }
        }

        //user
        if (!empty(AuthComponent::user('id'))){
            $usefirst = $this->User->find('first',array(
                'conditions' => array(
                    'User.id' => AuthComponent::user('id'))
                )
            );
        }
        //称号変更
        if (!empty($this->data)){
            if (isset($this->data['User']['degree'])){
                $this->User->set($this->data);
                if ($this->User->validates()){
                    if(!empty(AuthComponent::user('id'))){
                        if ($param == AuthComponent::user('id')){
                            if(!empty($this->data['User']['degree'])){
                                $degree3 = $this->Degreelink->find('first',array(
                                    'fields' => array('Degreelink.id','Degreelink.user_id','Degree.id','Degree.content','Degree.urlid'),
                                    'conditions' => array(
                                        'Degreelink.user_id' => AuthComponent::user('id'),
                                        'Degree.content' => $this->data['User']['degree'],
                                    )
                                )
                                );
                                if ($degree3['Degree']['content'] != $this->data['User']['degree']){
                                    $this->data['User']['degree'] = null;
                                }
                                $data = $this->data;
                                $urlid = $this->Degree->find('first',array(
                                    'fields' => array('Degree.urlid'),
                                    'conditions' => array(
                                        'Degree.content' => $data['User']['degree'])
                                    )
                                );
                            } else {
                                $data['User']['degree'] = null;
                                $urlid['Degree']['urlid'] = null;
                            }
                            $this->User->id = AuthComponent::user('id');
                            $save['User']['degree'] = $data['User']['degree'];
                            $save['User']['degreeid'] = $urlid['Degree']['urlid'];
                            $save['User']['password'] = $usefirst['User']['password'];
                            $this->User->save($save);
                            //ユーザ情報更新
                            $auth = AuthComponent::user();
                            $auth['degree'] = $save['User']['degree'];
                            $this->Session->write('Auth.User', $auth);
                        }
                        $this->redirect('profile/' . $param);
                    }
                }
            }
        }
        //サブ称号変更
        if (!empty($this->data)){
            if (isset($this->data['User']['degree_sub'])){
                $this->User->set($this->data);
                if ($this->User->validates()){
                    if(!empty(AuthComponent::user('id'))){
                        if ($param == AuthComponent::user('id')){
                            if(!empty($this->data['User']['degree_sub'])){
                                $degree3 = $this->Degreelink->find('first',array(
                                                'fields' => array('Degreelink.id','Degreelink.user_id','Degree.id','Degree.content','Degree.urlid'),
                                                'conditions' => array(
                                                                'Degreelink.user_id' => AuthComponent::user('id'),
                                                                'Degree.content' => $this->data['User']['degree_sub'],
                                                )
                                )
                                );

                                if ($degree3['Degree']['content'] != $this->data['User']['degree_sub']){
                                    $this->data['User']['degree_sub'] = null;
                                }
                                $data = $this->data;
                            } else {
                                $data['User']['degree_sub'] = null;
                            }
                            $this->User->id = AuthComponent::user('id');
                            $save['User']['degree_sub'] = $data['User']['degree_sub'];
                            $save['User']['password'] = $usefirst['User']['password'];
                            $this->User->save($save);
                            //ユーザ情報更新
                            $auth = AuthComponent::user();
                            $auth['degree_sub'] = $save['User']['degree_sub'];
                            $this->Session->write('Auth.User', $auth);
                        }
                        $this->redirect('profile/' . $param);
                    }
                }
            }
        }
        //プロフ変更のsave
        if (!empty($this->data)){
            $this->User->set($this->data);
            if ($this->User->validates()){
                $data = $this->data;
                if (!empty($data['User']['profile']) and !empty(AuthComponent::user('id'))){
                    if (AuthComponent::user('id') == $param){
                        $this->User->id = $param;
                        $save['User']['profile'] = $data['User']['profile'];
                        $save['User']['password'] = $usefirst['User']['password'];
                        $this->User->save($save);
                        $this->redirect('profile/' . $param);
                    }
                }
            }
        }
        //ブックマーク削除
        if (!empty($this->data)){
            $this->Temple->set($this->data);
            if (!empty($this->data['Temple']['del'])){
                if (AuthComponent::user('id') == $param){
                    $data = $this->data;
                    //Indextempのsave
                    $index = $this->Indextemp->find('first',array(
                        'conditions' => array(
                            'Indextemp.mondai_id' => $data['Temple']['mondai_id'],
                            ),
                            'recursive' => '-1'
                        )
                    );
                    if ($index['Indextemp']['count'] > 1){
                        $this->Indextemp->id = $index['Indextemp']['id'];
                        $save2['Indextemp']['mondai_id'] = $data['Temple']['mondai_id'];
                        $save2['Indextemp']['count'] = $index['Indextemp']['count']-1;
                        $this->Indextemp->save($save2);
                    } else {
                        $this->Indextemp->delete($index['Indextemp']['id']);
                    }
                    $this->Temple->delete($data['Temple']['id']);
                    $this->redirect('profile/' . $param);
                }
            }
        }
        //ブックマークコメント編集＆追加
        if (!empty($this->data)){
            $this->Temple->set($this->data);
            if (!empty($this->data['Temple']['comment_flg'])){
                if (AuthComponent::user('id') == $param){
                    $data = $this->data;
                    $temple = $this->Temple->find('first',array(
                        'conditions' => array(
                            'Temple.mondai_id' => $data['Temple']['mondai_id'],
                            'Temple.add_user_id' => AuthComponent::user('id'),
                            ),
                            'recursive' => '-1'
                        )
                    );
                    if (!empty($temple)){
                        $this->Temple->id = $temple['Temple']['id'];
                        $save['Temple']['comment'] = $data['Temple']['comment'];
                        $this->Temple->save($save);
                    }
                    $this->redirect('profile/' . $param);
                }
            }
        }

        $this->data = $data;
    }
    function syutu($param){
        //*ナビゲーションフラグ
        $naviflg = "page";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "syutu";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('param',$param);
        //標準ソート
        $order = array(
                    'Mondai.seikai' => 'asc',
                    'Mondai.created' => 'desc'
        );
        $this->Mondai->setOrder($order);
        //タグの表示
        $data = $this->User->find('first',array(
            'conditions' => array(
                'User.id' => $param)
            )
        );
        $this->set("data",$data);
        //問題表示
        $new_data = $data["User"]["id"];
        $new_data = explode(' ', $new_data);
        foreach ( $new_data as $key => $val ) {
            $or[$key] =  array("User.id like" => '' . $param . '');
        }
        $condition = array("and"=>$or);

        //一時名無しの対策
        $taisaku = $this->Paginate($condition);
        foreach( $taisaku as $key => $val ){
            if ($taisaku[$key]['Mondai']['itijinanashi'] == 2 and $taisaku[$key]['Mondai']['seikai'] == 1){
                unset($taisaku[$key]);
            }
        }
        $taisaku = array_merge($taisaku);
        $this->set('data2', $taisaku);

        $this->set('condition', $condition);

        //称号
        $degree = $this->Degreelink->find('all',array(
            'fields' => array('Degreelink.id','Degreelink.user_id','Degree.content'),
            'conditions' => array(
                'Degreelink.user_id' => $param)
            )
        );
        $this->set('degree', $degree);
    }
    function temple(){
        //ナビゲーションフラグ
        $naviflg = "mondai";
        $this->set("naviflg",$naviflg);
        $subnaviflg = "temple";
        $this->set("subnaviflg",$subnaviflg);
        //
        $this->set('data', $this->Paginate('Indextemp'));
        $this->set("templejs","templejs");
    }

    function beforeFilter(){
        $this->Auth->allow(
        'search',
        'index',
        'show',
        'add',
        'edit',
        'confirm',
        'lobby',
        'tag',
        'tag_search',
        'edit_tag',
        'profindex',
        'profile',
        'inbox',
        'outbox',
        'syutu',
        'temple',
        'login'
        );
    }
}
?>
