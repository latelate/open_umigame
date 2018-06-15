<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico',true) ?>" />
        <?php echo $this->Html->charset()."\n";?>
        <meta name="google-site-verification" content="" />
        <meta name="viewport" content="width=device-width">
        <title><?php echo DEFINE_sitetitle; ?></title>
        <meta name="description" content="当サイトは全員参加型の「ウミガメのスープ」出題サイトです。出題者の考えた問題に、YES/NOで答えられる質問をし謎を解き明かしていきます。水平思考で謎を解き、物語の真相を解明しましょう。" />
        <meta name="keywords" content="ウミガメのスープ,ウミガメ,スープ,水平思考,推理ゲーム" />
        <meta http-equiv="content-script-type" content="text/javascript" />
        <meta http-equiv="content-style-type" content="text/css" />
        <?php
        echo $this->Html->script('common.js', true) ."\n";
        echo $this->Html->script('jquery.mangaviewer.js', true) ."\n";
        echo $this->fetch('script');
        ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/css/drawer.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/js/drawer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <?php echo $this->Html->script('masonry.pkgd.min') ."\n";?>
        <?php //echo $this->Html->script('imagesloaded.pkgd.min') ."\n";?>

        <?php echo $this->Html->css('import'); ?>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
        $(function() {
          // テキストボックスにフォーカス時、フォームの背景色を変化
          $('input,textarea')
            .focus(function(e) {
              $('.focus').css('display', 'none');
            })
            .focusout(function(e) {
              $('.focus').css('display', 'block');
            });
        });
            $(document).ready(function(){
                function displayVals() {
                    var singleValues = $("input[class=continent]:checked").val()
                    var defined = 0;
                    if(singleValues == 2){
                        $(".zikan").css("display","");
                        $(".situ").css("display","");
                        $(".kaigyo").css("display","none");
                    }else if(singleValues == 3){
                        $(".zikan").css("display","");
                        $(".situ").css("display","none");
                        $(".kaigyo").css("display","none");
                    }else if(singleValues == 4){
                        $(".zikan").css("display","");
                        $(".situ").css("display","");
                        $(".kaigyo").css("display","");
                    }else if(singleValues == 5){
                        $(".zikan").css("display","");
                        $(".situ").css("display","");
                        $(".kaigyo").css("display","");
                    }else{
                        $(".zikan").css("display","");
                        $(".situ").css("display","none");
                        $(".kaigyo").css("display","none");
                    }
                }
                $('input[class="continent"]:radio').change(displayVals);
                displayVals();
            });
            //一番上へスクロール
            $(function(){
                var topBtn=$('a[href^=#wrap]');
                topBtn.hide();

                //◇ボタンの表示設定
                $(window).scroll(function(){
                  if($(this).scrollTop()>80){
                    //---- 画面を80pxスクロールしたら、ボタンを表示する
                    topBtn.fadeIn();
                  }else{
                    //---- 画面が80pxより上なら、ボタンを表示しない
                    topBtn.fadeOut();
                  }
                });
                $('a[href^=#wrap]').click(function() {
                  var speed = 400; // ミリ秒で記述
                  var href= $(this).attr("href");
                  var target = $(href == "#" || href == "" ? 'html' : href);
                  var position = target.offset().top;
                  $('body,html').animate({scrollTop:position}, speed, 'swing');
                  return false;
                });
            });
            <!--
            //タグ編集
            $(function(){
                $("#edit_tag button").click(function(){
                    $("#edit_tag").load("<?php echo $this->Html->url('/mondai/edit_tag/'.h($param)); ?> #edit_tag");
                    return false;
                })
            });
            // -->
        </script>
        <?php
        //ブックマーク
        if (!empty($templejs)){
            echo "<script type=\"text/javascript\">\n";
            echo "<!--\n";
            foreach( $data as $key => $val ){
                echo "$(function(){\n";
                echo "$(\".open" . h($key) . "\").click(function(){\n";
                echo "$(\"#slideBox" . h($key) . "\").slideToggle(\"slow\");\n";
                echo "});\n";
                echo "});\n";
            }
            echo "// -->\n";
            echo "</script>\n";
            echo "<style type=\"text/css\">\n";
            foreach( $data as $key => $val ){
                echo ".open" . h($key) . "{\n";
                echo "     background: #797159;\n";
                echo "     color: #fff;\n";
                echo "     cursor: pointer;\n";
                echo "     padding: 10px\n";
                echo "}\n";
                echo "#slideBox" . h($key) . "{\n";
                echo "     padding: 10px;\n";
                echo "     border: 1px #ccc solid;\n";
                echo "     display:none;\n";
                echo "}\n";
            }
            echo "</style>\n";
        } elseif(!empty($mvsjs)) {
            echo "<script type=\"text/javascript\">\n";
            echo "<!--\n";
            foreach( $data3 as $key => $val ){
                echo "$(function(){\n";
                echo "$(\".open" . h($key) . "\").click(function(){\n";
                echo "$(\"#slideBox" . h($key) . "\").slideToggle(\"slow\");\n";
                echo "});\n";
                echo "});\n";
            }
            echo "$(function(){\n";
            echo "$(\".open999\").click(function(){\n";
            echo "$(\"#slideBox999\").slideToggle(\"slow\");\n";
            echo "});\n";
            echo "});\n";
            echo "// -->\n";
            echo "</script>\n";
            echo "<style type=\"text/css\">\n";
            foreach( $data3 as $key => $val ){
                echo ".open" . h($key) . "{\n";
                echo "     background: #797159;\n";
                echo "     color: #fff;\n";
                echo "     cursor: pointer;\n";
                echo "     padding: 10px\n";
                echo "}\n";
                echo "#slideBox" . h($key) . "{\n";
                echo "     padding: 10px;\n";
                echo "     border: 1px #ccc solid;\n";
                echo "     display:none;\n";
                echo "}\n";
            }
            echo ".open999{\n";
            echo "     background: #797159;\n";
            echo "     color: #fff;\n";
            echo "     cursor: pointer;\n";
            echo "     padding: 10px\n";
            echo "}\n";
            echo "#slideBox999{\n";
            echo "     padding: 10px;\n";
            echo "     border: 1px #ccc solid;\n";
            echo "     display:none;\n";
            echo "}\n";
            echo "</style>\n";
        } elseif(!empty($secretjs)) {
            echo "<script type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "$(function(){\n";
            echo "$(\".open1\").click(function(){\n";
            echo "$(\"#slideBox1\").slideToggle(\"slow\");\n";
            echo "});\n";
            echo "});\n";
            echo "$(function(){\n";
            echo "$(\".open2\").click(function(){\n";
            echo "$(\"#slideBox2\").slideToggle(\"slow\");\n";
            echo "});\n";
            echo "});\n";
            echo "// -->\n";
            echo "</script>\n";
            echo "<style type=\"text/css\">\n";
            echo ".open1{\n";
            echo "     background: #797159;\n";
            echo "     color: #fff;\n";
            echo "     cursor: pointer;\n";
            echo "     padding: 10px\n";
            echo "}\n";
            echo "#slideBox1{\n";
            echo "     display:none;\n";
            echo "}\n";
            echo ".open2{\n";
            echo "     background: #797159;\n";
            echo "     color: #fff;\n";
            echo "     cursor: pointer;\n";
            echo "     padding: 10px\n";
            echo "}\n";
            echo "#slideBox2{\n";
            echo "     display:none;\n";
            echo "}\n";
            echo "</style>\n";
        }
        ?>
    </head>
    <?php
    if (empty($param)){
        $param = 'param_no';
    }
    if (empty($rr)){
        $rr = 'rr_no';
    }
    if ($rr == '/mondai/show/' . $param){
        echo "<body onload=\"ScrollHalfHeight();display();document.getElementById('btnSubmit').disabled=fales;\" onunload='clearTimeout(tid)' class=\"drawer drawer--right\">\n";
    } else {
        echo "<body onload=\"display();document.getElementById('btnSubmit').disabled=fales;\" onunload='clearTimeout(tid)' class=\"drawer drawer--right\">\n";
    }
    ?>
	<main role="main" class="main">
        <?php
        if ($naviflg == "home" and $subnaviflg == "home"){//トップならカーテン表示
            echo "<div id=\"wrap\" class=\"curtain\">";
        } else {
            echo "<div id=\"wrap\">";
        }
        echo $this->element('header')."\n";
        echo "<div id=\"content\">\n";
            echo $content_for_layout."\n";
        echo "</div>\n";
        echo $this->element('footer')."\n";
        ?>
    </div>

    </main>
    <script type="text/javascript">
        <!--
          $(document).ready(function() {
               $('.drawer').drawer();
          });
        // -->
    </script>
    <?php
        echo "<div id=\"top\"><a href='" . $this->Html->url('#wrap') . "'>".$this->Html->image("key.png",array('class'=>'img-responsive'))."</a></div>";
    ?>
    </body>
</html>
