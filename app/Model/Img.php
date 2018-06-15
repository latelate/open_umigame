<?php
class Img extends AppModel {

    public $name = 'Img';
    public $order = 'Img.created ASC';

    var $actsAs = array(
        'UploadPack.Upload' => array(
            //画像保存用のフィールド名。「_file_name」は書かない
            'img' => array(
                'path' => ':webroot/img/img_sashie/:id/:style_:basename.:extension',
                //stylesでサイズ指定
                'styles' => array(
                    'thumb' => '350h',
                )
            )
        )
    );

    var $validate = array(
        'img' => array(
            //○○キロバイト以下のファイルでアップロードしてください。
            'maxSize' => array(
                'rule' => array('attachmentMaxSize', 1048576),
                'message' => '1MB以下のファイルでアップロードしてください'
            ),
            //○○キロバイト以上のファイルでアップロードしてください。(あまりにも小さいファイルはアップロードさせない)
            'minSize' => array(
                'rule' => array('attachmentMinSize', 1024),
                'message' => '1KB以上のファイルでアップロードしてください'
            ),
            'img' => array(
                'rule' => array('attachmentContentType', array('image/jpeg', 'image/png')),
                'message' => 'jpgとpngファイルのみアップロードできます。'
            )
        )
    );
}
?>
