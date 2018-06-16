<?php
App::uses('Component', 'Controller');
class PermissiontagComponent extends Component {
    //特定のタグを許可
    function filter_text($text) {
        //マッチパターン
        $patterns = array("/\[b\]\n?(.+?)\[\/b\]\n?/");
        //変換パターン
        $replaces = array('<span style="font-weight: bold">', '</span>');
        //変換処理
        return $result = preg_replace($patterns, $replaces, $text);
    }
}
?>
