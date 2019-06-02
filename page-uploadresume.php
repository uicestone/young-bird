<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-23
 * Time: 0:27
 * Template Name: ajaxjianli
 */


$file = $_FILES['file'];

if ( !empty( $file ) ) {
    // 获取上传目录信息

    $wp_upload_dir = wp_upload_dir();

    // 将上传的图片文件移动到上传目录
    $basename   = $file['name'];
    $filename   = $wp_upload_dir['path'] . '/' . $basename;
    $re         = rename( $file['tmp_name'], $filename );
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $basename,
        'post_mime_type' => $file['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    $attach_id  = wp_insert_attachment( $attachment, $filename );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    $re = array(
        'code'=>0,
        'msg'=>'上传成功',
        'data'=>array(
            'src'=>wp_get_attachment_url( $attach_id ),
            'title'=>''
        )
    );
    $output='<div id="'.$attach_id.'">'.$attach_id.'</div>';
    echo $output;
}
?>