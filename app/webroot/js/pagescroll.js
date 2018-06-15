
/*  /_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/

    +++ Page Scroller 2 +++

    LastModified : 2005-09/09

    Powered by kerry
    http://202.248.69.143/~goma/

    動作ブラウザ :: IE4+ , Gecko , Opera7+

    /_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/


* Usage

    @ 基本

    特に何ということはしません。普通に記述します。ただ、以下の段階で
    きちんと通常通りに動作していなければスクリプトもまた動きません。

    <a href="#foo"> 移動元 </a>
    .
    .
    .
    <a name="foo">  移動先 </a>

    後は適当な場所で外部ファイルを読み込むだけ ;)

    <script type="text/javascript" src="ps2.js"> </script>


    もしスクリプトの設定を変更させる場合は↑の後に↓

    <script type="text/javascript"><!-- // 以後 type 属性、コメント等は割愛

    ps2.scrollLength   = 8;
    ps2.scrollSpeed    = 10;
    ps2.clickCheck     = 0;
    ps2.init();

    // -->
    </script>








    @ 細かい設定

    * 任意の要素のみに適用させる
        外部ファイルを読み込むとスクリプトはアンカを探しそれら全てに
        スクリプトを反映させようとします。しかしこれでは都合が悪く、任意の
        要素で利用したい場合もあるかと思われます。そういった場合には以下の
        記述を追加します。


        <script src="ps2.js"></script>
        <script>
                // ゼロを代入するとイベントを監視しなくなる
                ps2.clickCheck = 0;
        </script>

        <!-- *
             * スクロールを適用させたい各要素へ以下を書き足す
             * onclick="return ps2.scroller(this)"
             * これが無いものに関しては何も起こらなくなる
             * -->
        <a href="#foo" onclick="return ps2.scroller(this)"> 移動元 </a>
        .
        .
        <a name="foo"> 移動先 </a>

        <!-- *
             * 仕込み対象が A 要素以外の場合は第2引数へ event という文字列、
             * 第3引数へ移動先の A 要素の name 属性の値を入れる。
             * 値は A href に書く時と同じ。'#foo' でも 'foo' でもどちらでも。
             * onclick="return ps2.scroller(this, event, '#foo')"
             * 尚、第3引数のみ 'クヲート' で括る。
             * -->
        <button onclick="return ps2.scroller(this, event, 'foo')"> 移動元 </button>



    * 重いページ
        スクリプトはページ読み込み完了後から反映されます。その為、重いページ
        だと最初のうちは何も起きません。こういった場合には BODY 間の A 要素
        が出きった場所又は BODY 閉じタグ直前に以下の記述をします。こうするこ
        とでページの読み込み完了を待たずしてスクロールが適用されます。


        <script src="ps2.js"></script>
        <script>
                ps2.init();　// <- コレがポイント
        </script>
        </body>


    * 1つの外部ファイルでページ毎に設定を変更する

        <script src="ps2.js"></script>
        <script>

        // ::: 以下の3つは初期設定からの変更ができます ::: //


        // スクロールさせる距離の間隔
        // 1～100 ( 単位 % ) 推奨値 5～10
        ps2.scrollLength   = 8;     // number


        // スクロールさせる時間の間隔
        // 推奨値 10～100 ( 1000 = 1秒 )
        ps2.scrollSpeed    = 15;    // number


        // リンクの監視 ( 1 -> Yes, 0 -> No )
        ps2.clickCheck     = 0;     // bool

        </script>

    /_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/ */




ps2 = new function()
{


    // 初期設定 --> START

    this.scrollLength   = 10;   // [ number ] スクロールさせる距離の間隔
                                // 1～100 ( 単位 : % ) 推奨値 5～10

    this.scrollSpeed    = 10;   // [ number ] スクロールさせる時間の間隔
                                // 推奨値 10～100 ( 単位 : 1000 = 1秒 )

    this.clickCheck     = 1;    // [ bool ]
                                // リンクの監視 ( 1 -> Yes, 0 -> No )

    var useMoziHiVer    = 1;    // [ bool ]
                                // 最近の Gecko でも動作させる ( 1 -> Yes, 0 -> No )

                                // 最近の Gecko Engine はレンダリングが重いく
                                // マシンのスペックやスマートスクローリング機能 (FF)
                                // にも影響されスムーズでない場合が多い。
                                // Mozilla 0.6, 1.0, 1.4 はとてもスムーズであるものの
                                // 1.7 とか Firefox 辺りの最近のものになると、、  :(

    // 初期設定 <-- END





    var _this           = this;
    var isIE            = !!(document.all && !window.opera);
    var isDOM           = !!document.getElementById;
    var isMHVer         = navigator.product == "Gecko" &&
                          navigator.productSub > 20040000;
    var ancz            = new Array();
    var f_scroll        = "scroller";
    var initFlag        = false;
    var ancLen          = 0;
    var timeId;
    var winHeight;
    var docHeight;
    var pTopPos;
    var pLeftPos;
    var tgtTopPos;
    var upFlag;
    var isEvent;

    var getAnchorNodes = function()
    {
        var ac = document.anchors;
        if (initFlag || ac.length == ancLen) return;

        for (var i=ancLen; i<ac.length; i++) {
            if (ac[i].name.length > 1) ancz[ac[i].name] = ac[ancLen = i];
        }
    }

    var fPath = function(_p) { return (_p.charAt(0) != "/")? "/"+ _p: _p }

    var getPosition = function()
    {
        if (isIE) { with (document.body)
        {
            winHeight   = clientHeight;
            docHeight   = scrollHeight;
            pTopPos     = scrollTop;
            pLeftPos    = scrollLeft;
        } }
        else
        {
            winHeight   = window.innerHeight;
            docHeight   = document.height || document.body.scrollHeight;
            pTopPos     = window.pageYOffset;
            pLeftPos    = window.pageXOffset;
        }
    }

    this[f_scroll] = function(_node, _e, _hash)
    {
        var targetName;
        var oTarget;

        if (timeId) timeId = clearInterval(timeId);
        if (_hash) targetName = _hash.charAt(0) == "#"? _hash.substr(1): _hash;
        else if (_node && _node.hash) targetName = _node.hash.substr(1);

        if (!targetName) return true;

        getAnchorNodes();
        getPosition();

        oTarget = ancz[targetName];
        if (!oTarget || !docHeight) return true;

        tgtTopPos   = oTarget.offsetTop;
        udFlag      = !!(tgtTopPos < _node.offsetTop);
        timeId      = setInterval( _this.pScrolling, this.scrollSpeed );

        if (_e)
        {
            if (isIE) event.cancelBubble = true;
            else if (_e.stopPropagation) _e.stopPropagation();
        }
        return false;
    }

    if (isIE)
    var getPageTopOffset = new Function(" return document.body.scrollTop ");
    else
    var getPageTopOffset = new Function(" return window.pageYOffset ");


    this.pScrolling = function()
    {
        var tempPTop = getPageTopOffset();
        var endFlag=0;

        if (!udFlag) {
            pTopPos += Math.ceil((tgtTopPos- tempPTop) * (_this.scrollLength/100));
            if (tgtTopPos <= pTopPos) endFlag = 1;
        }
        else {
            pTopPos -= Math.ceil((tempPTop- tgtTopPos)* (_this.scrollLength/100));
            if (tgtTopPos >= pTopPos) endFlag = 1;
        }

        if (endFlag) {
            pTopPos = tgtTopPos;
            timeId  = clearInterval(timeId);
        }
        scrollTo( pLeftPos, pTopPos );
    }

    this.init = function()
    {
        if (initFlag) return;

        getAnchorNodes();
        initFlag = 1;
        autoScroll();

        if (_this.clickCheck) {
        document.onclick = document.onclick? new checkClick: checkClick;
        document.onkeyup = document.onkeyup? new checkClick: checkClick;
        }
    }

    var autoScroll = function()
    {
        var aName = location.hash;
        if (aName.length > 1)
        _this[f_scroll]({
            hash        : aName,
            offsetTop   : getPageTopOffset()
            });
    }

    var checkClick = function(_e)
    {

        if (timeId) timeId = clearInterval(timeId);
        if (_e) {
            _e = _e.target;
            if (_e.nodeType && _e.nodeType != 1) _e = _e.parentNode;
        }
        else
            _e = event.srcElement;


        if (_e && _e.tagName == "A")
        {
            if (_e.hash.length > 1 && fPath(location.pathname) == fPath(_e.pathname) )
                return _this[f_scroll](_e);
            else
                return true;
        }

    }


    if ( !(isIE || isDOM) || (!useMoziHiVer && isMHVer) )
    {
        this[f_scroll]  = new Function(" return true ");
        this.init       = new Function("");
    }

    if (isIE || isDOM)
    {
        if (window.onload) window.onload = new this.init;
        else window.onload = this.init;

        if (window.onerror) window.onerror = new this.init;
        else window.onerror = this.init;
    }
}

