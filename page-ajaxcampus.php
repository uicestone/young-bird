<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-23
 * Time: 0:27
 * Template Name: ajaxcampus
 */


   /* if($user->ID===0)
        return;*/



$user_applyed=get_posts(array(
    'post_type'=>'campus_apply',
    'author'=>get_current_user_id(),
    'meta_key'=>'campus_id',
    'meta_value'=>$_POST['campusid'],
));

if(isset($_POST['resume'])){
        delete_user_meta(get_current_user_id(),'campus_resume');
        add_user_meta(get_current_user_id(),'campus_resume',$_POST['fid']);
        $data['status']='success';

        $filename=get_attached_file($_POST['fid']);
        $filename=mb_substr($filename,strripos($filename,'/')+1);
        $data['filename']=$filename;



        $data['src']=wp_get_attachment_url(  $_POST['fid'] );
        echo json_encode($data);
        return;
}
if($user_applyed)
    $status=get_post_meta($user_applyed[0]->ID,'status',true);


if($status=='pass') {

    if($_POST['type']=='add') {
        $image_post = get_posts(array(
            'post_type' => 'campusimage',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array('key' => 'campus_id', 'value' => $_POST['campusid']),
                array('key' => 'school_id', 'value' => $_POST['schoolid'])

            )));

        if (empty($image_post)) {
            $image_post = array(
                'post_title' => $name . '申请-' . $_POST['campusid'] . '-' . $_POST['schoolid'],
                'post_content' => $name . '申请-' . $_POST['campusid'] . '-' . $_POST['schoolid'],
                'post_type' => 'campusimage',
                'post_author' => get_current_user_id(),
                'post_status' => 'publish',
                'meta_input' => array('campus_id' => $_POST['campusid'], 'school_id' => $_POST['schoolid'],'competitor_count'=>0,'work_count'=>0),
            );
            $image_post = wp_insert_post($image_post, $wp_error);
        } else {
            $image_post = $image_post[0]->ID;
        }
        add_post_meta($image_post, 'image1', $_POST['fid']);
        $data['status']='success';
        $data['src']=wp_get_attachment_url(  $_POST['fid'] );
        echo json_encode($data);
    }
    else if($_POST['type']=='delete'){
        $image_post = get_posts(array(
            'post_type' => 'campusimage',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array('key' => 'campus_id', 'value' => $_POST['campusid']),
                array('key' => 'school_id', 'value' => $_POST['schoolid'])

            )));
        $image_post = $image_post[0]->ID;

        delete_post_meta($image_post, 'image1', substr($_POST['fid'],2));
        echo json_encode('success');
    }
}

?>