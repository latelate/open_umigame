<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {

    function space_only($field=array()){
        foreach($field as $name => $value){}

        if( mb_ereg_match("^(\s|　)+$", $value) ){
            return false;
        }else{
            return true;
        }
    }

    function escapeLikeSentence($str, $before = false, $after = false){
        $result = str_replace('\\', '\\\\', $str); // \ -> \\
        $result = str_replace('%', '\\%', $result); // % -> \%
        $result = str_replace('_', '\\_', $result); // _ -> \_
        return (($before) ? '%' : '').$result.(($after) ? '%' : '');
    }

    //日本語の文字数チェック関数
    function maxLengthJP($wordvalue, $length) {
        //$wordvalueはキーがモデル名の連想配列のためforeachで対応
        //foreach ($wordvalue as $key => $value){
        //	return(mb_strlen($value,mb_detect_encoding($value)) <= $length);
        //}

        //上記よりも、こっちのほうがいいかな。結果は同じだけど。
        $value = array_shift( $wordvalue );
        return(mb_strlen($value,mb_detect_encoding($value)) <= $length);
    }
}
