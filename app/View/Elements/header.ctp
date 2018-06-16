<?php
echo "<div class=\"hedline-wrap\">\n";
    echo "<div class=\"hedline\">\n";
        echo "<div class=\"hedline-text\">\n";
            echo "OPENウミガメ2.0『<span>".DEFINE_sitename."</span>』";
            echo "<div class=\"r\">";

            Cache::set(Array('duration' => '+60 seconds'));
            if (!empty(AuthComponent::user('id'))){
            if(! $cache_newmail = Cache::read('cache_newmail_'.AuthComponent::user('id'))) {
                $cache_newmail_kari = $newmail;
                Cache::write('cache_newmail_'.AuthComponent::user('id'), $cache_newmail_kari);
                $cache_newmail = Cache::read('cache_newmail_'.AuthComponent::user('id'));
            } else {
                $cache_newmail = Cache::read('cache_newmail_'.AuthComponent::user('id'));
            }
                if(! $cache_newmail == 0) {
                    echo "<a href=\"" . $this->Html->url('/mondai/inbox/' . h(AuthComponent::user('id'))) . "\">";
                    echo "[新着ミニメール";
                    echo h($cache_newmail) . "件";
                    echo "]";
                    echo "</a>　\n";
                }
            }

            echo "ようこそ、ウミガメのスープ出題サイトへ！";
            if (!empty(AuthComponent::user('id'))){
                echo "　<a href=\"" . $this->Html->url('/mondai/profile/' . h(AuthComponent::user('id'))) . "\">";
                echo h(AuthComponent::user('name'));
                if(!empty(AuthComponent::user('degree'))){
                    echo "[" .  h(AuthComponent::user('degree')) . "]";
                }
                echo "</a>　";
            } else {
                echo "<b>　ゲスト　</b>";
            }
            echo "さん";
            echo "<span class=\"spNone-s\"><br /></span>\n";
            if (!empty(AuthComponent::user('id'))){
            } else {
                echo "　";
                echo "<a href=\"" . $this->Html->url('/users/login') . "\">ログイン</a>";
                echo "　";
                echo "<a href=\"" . $this->Html->url('/users/add') . "\">新規登録</a>";
            }
            echo "</div>\n";
        echo "</div>\n";
        echo "<div class=\"clear\"></div>\n";
    echo "</div>\n";
echo "</div>\n";
echo "<div class=\"navibar-wrap\">\n";
    echo "<div class=\"navibar\">\n";
        echo "<div class=\"naviline\">\n";
            echo "<div class=\"naviline2\">\n";
                echo "<div class=\"navi_naka\">\n";
                echo "<div class=\"home\">";
                echo "<a href='" . $this->Html->url('/') . "'>".$this->Html->image("open-home.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                echo "<a href='" . $this->Html->url('/mondai/lobby') . "'>".$this->Html->image("navi1-lobby.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                echo "<a href='" . $this->Html->url('/mondai') . "'>".$this->Html->image("navi2-mondai.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                echo "<a href='" . $this->Html->url('/main/rule') . "'>".$this->Html->image("navi3-rule.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                if (!empty(AuthComponent::user('id'))){
                    echo "<a href='" . $this->Html->url('/mondai/profile/'.AuthComponent::user('id')) . "'>".$this->Html->image("navi4-my.png",array('class'=>'img-responsive'))."</a>";
                } else {
                    echo "<a href='" . $this->Html->url('/mondai/profile/0') . "'>".$this->Html->image("navi4-my.png",array('class'=>'img-responsive'))."</a>";
                }
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                echo "<a href='" . $this->Html->url('/mondai/search') . "'>".$this->Html->image("navi8-search.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"pcNone navibox l\">\n";
                echo "<a href='" . $this->Html->url('/secret') . "'>".$this->Html->image("navi9-secret.png",array('class'=>'img-responsive'))."</a>";
                echo "</div>\n";
                echo "<div class=\"cindy\">\n";
                echo $this->Html->image("cindy.png",array('class'=>'img-responsive'));
                echo "</div>\n";
                echo "<div class=\"clear\"></div>\n";
                echo "</div>\n";

                echo "<div class=\"hukidasi r cindy-box\">\n";
                    echo "<div class=\"f-rh\">\n";
                        echo $this->Html->image("f-h.png",array('class'=>'img-responsive'));
                    echo "</div>\n";
                    echo "<div class=\"hukidasi_box clearfix\">\n";
                        echo "<p class=\"align_r\">\n";
                            if (!empty($cindy_speech)){
                                echo $cindy_speech;
                            } else {
                                $key = array_rand(DEFINE_chindy);
                                echo h(DEFINE_chindy[$key]);
                            }
                        echo "</p>";
                    echo "</div>\n";
                echo "</div>\n";

            echo "</div>\n";
        echo "</div>\n";
    echo "</div>\n";
echo "</div>\n";
echo "<div class=\"clear\"></div>\n";
echo "<div class=\"sub-navi pcNone\">\n";
if($naviflg != "admin"){
    //--------------------------------------------------以下「ロビー」ナビ--------
    if ($naviflg == "lobby"){
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "lobby"){//『称号』申請所
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/lobby') . "\">\n";
        }
        echo "ロビー\n";
        if($subnaviflg == "degree"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "degree"){//『称号』申請所
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/degree') . "\">\n";
        }
        echo "『称号』申請所\n";
        if($subnaviflg == "degree"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "setumei"){//『称号』解説
            echo "<div class=\"subnavi2\">\n";
            echo "『称号』解説\n";
            echo "</div>\n";
        }
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "profindex"){//みんなのプロフィール
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/profindex') . "\">\n";
        }
        echo "みんなのプロフィール\n";
        if($subnaviflg == "profindex"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
    }
    //--------------------------------------------------以下「問題」ナビ--------
    if ($naviflg == "mondai"){
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "mondai"){//問題一覧
            echo "<div class=\"subnavi2\">\n";
            echo "\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai') . "\">\n";
        }
        echo "問題一覧\n";
        if($subnaviflg == "mondai"){
            echo "\n";
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if (!empty(AuthComponent::user('id'))){
            if ($subnaviflg == "mondaiadd"){//出題する
                echo "<div class=\"subnavi2\">\n";
            } else {
                echo "<div class=\"subnavi\">\n";
                echo "<a href=\"" . $this->Html->url('/mondai/add') . "\">\n";
            }
            echo "出題する\n";
            if($subnaviflg == "add"){
            } else {
                echo "</a>\n";
            }
            echo "</div>\n";
        }
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "tag"){//タグ
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/tag_search') . "\">\n";
        }
        echo "タグ一覧\n";
        if($subnaviflg == "tag"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "temple"){//殿堂入り
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/temple') . "\">\n";
        }
        echo "みんなのブックマーク\n";
        if($subnaviflg == "temple"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "mondaiedit"){
            if ($subnaviflg == "mondaiedit"){//編集画面
                echo "<div class=\"subnavi2\">\n";
            } else {
                echo "<div class=\"subnavi\">\n";
                echo "<a href=\"" . $this->Html->url('/mondai/show/' . $param) . "\">\n";
            }
            echo "編集画面\n";
            if($subnaviflg == "mondaiedit"){
            } else {
                echo "</a>\n";
            }
            echo "</div>\n";
        }

    }
    //--------------------------------------------------以下「ルール説明」ナビ--------
    if ($naviflg == "rule"){
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "rule"){//ルール説明
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/main/rule') . "\">\n";
        }
        echo "ルール説明\n";
        if($subnaviflg == "rule"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "kiyaku"){//利用規約
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/main/kiyaku') . "\">\n";
        }
        echo "利用規約\n";
        if($subnaviflg == "kiyaku"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
    }
    //--------------------------------------------------以下「マイページ」ナビ--------
    if ($naviflg == "page"){
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "profile"){//プロフィール
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/profile/' . $param) . "\">\n";
        }
        echo "プロフィール\n";
        if($subnaviflg == "profile"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if ($subnaviflg == "syutu"){//出題した問題
            echo "<div class=\"subnavi2\">\n";
        } else {
            echo "<div class=\"subnavi\">\n";
            echo "<a href=\"" . $this->Html->url('/mondai/syutu/' . $param) . "\">\n";
        }
        echo "出題した問題\n";
        if($subnaviflg == "syutu"){
        } else {
            echo "</a>\n";
        }
        echo "</div>\n";
        //現在ページならリンクを外す、divを変える。
        if($param == h(AuthComponent::user('id'))){
            if ($subnaviflg == "inbox"){//プロフィール
                echo "<div class=\"subnavi2\">\n";
            } else {
                echo "<div class=\"subnavi\">\n";
                if (!empty(AuthComponent::user('id'))){
                    echo "<a href=\"" . $this->Html->url('/mondai/inbox/' . h(AuthComponent::user('id'))) . "\">\n";
                } else {
                    echo "<a href=\"" . $this->Html->url('/mondai/inbox/0') . "\">\n";
                }
            }
            echo "ミニメ受信箱\n";
            if($subnaviflg == "inbox"){
            } else {
                echo "</a>\n";
            }
            echo "</div>\n";
        }
        //現在ページならリンクを外す、divを変える。
        if($param == h(AuthComponent::user('id'))){
            if ($subnaviflg == "outbox"){//プロフィール
                echo "<div class=\"subnavi2\">\n";
            } else {
                echo "<div class=\"subnavi\">\n";
                if (!empty(AuthComponent::user('id'))){
                    echo "<a href=\"" . $this->Html->url('/mondai/outbox/' . h(AuthComponent::user('id'))) . "\">\n";
                } else {
                    echo "<a href=\"" . $this->Html->url('/mondai/outbox/0') . "\">\n";
                }
            }
            echo "ミニメ送信箱\n";
            if($subnaviflg == "outbox"){
            } else {
                echo "</a>\n";
            }
            echo "</div>\n";
        }
        //現在ページならリンクを外す、divを変える。
        if($param == h(AuthComponent::user('id'))){
            if ($subnaviflg == "mytemple"){//プロフィール
                echo "<div class=\"subnavi2\">\n";
            } else {
                echo "<div class=\"subnavi\">\n";
                if (!empty(AuthComponent::user('id'))){
                    echo "<a href=\"" . $this->Html->url('/mondai/mytemple/' . h(AuthComponent::user('id'))) . "\">\n";
                } else {
                    echo "<a href=\"" . $this->Html->url('/mondai/mytemple/0') . "\">\n";
                }
            }
            echo "あなたへの新着ブクマ\n";
            if($subnaviflg == "mytemple"){
            } else {
                echo "</a>\n";
            }
            echo "</div>\n";
        }
    }
}
echo "<div class=\"clear\"></div>\n";
echo "</div>\n";


if ($naviflg != "home" and $subnaviflg != "home"){//トップならカーテン表示
}
