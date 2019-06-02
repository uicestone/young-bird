<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-23
 * Time: 0:27
 * Template Name: answer
 */


   /* if($user->ID===0)
        return;*/


$current_url = home_url(add_query_arg(array()));
if( !current_user_can( 'manage_options' ) ) {
    return ;
}
$my_post=0;
$id=$_GET['id'];
if(isset($_POST['answer'])){

   add_post_meta($_POST['pid'],'answer_user',get_current_user_id());
   add_post_meta($_POST['pid'],'answer',$_POST['answer_detail']);
   $post=get_post($_POST['pid']);
  $mail=get_post_meta($_POST['pid'],'mail',true);


    $message= __('问题', 'young-bird').':'.get_post_meta($_POST['pid'],'question',true).' '.__('答案', 'young-bird').':'.get_post_meta($_POST['pid'],'answer',true);
        //$message=__('问题', 'young-bird').':';
    wp_mail($mail,
        __('您的问题已被回答', 'young-bird') ,
        $message,
        array('Content-Type: text/html; charset=UTF-8', 'Cc: ' . get_option('recruitment_cc_email'))
    );
    send_message($post->post_author, 'qa', array('question' => get_post_meta($_POST['pid'],'question',true),'answer'=>get_post_meta($_POST['pid'],'answer',true)));
    $post=get_post($_GET['id']);
    $post->post_status='publish';
    wp_update_post($post);
    header('Location: https://www.youngbirdplan.com.cn/wp-admin/edit.php?post_type=qaa' );

}



?>



<!-- Banner -->
<!-- for desktop -->
<?php






get_header(); ?>
<!-- Banner -->

<div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
    <div class="container">
        <h1>回答 <br></h1>
    </div>
</div>
<!-- Body -->
<div class="container mt-7 pb-7 sign-up">
    <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-center align-items-center logo">
            <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12 offset-md-2">

            <form method="POST" accept-charset="UTF-8">

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="input-group input-group-lg">
                                <div class="quanestion col-md-24">问题：<?php print get_post_meta($id,'question',true);?></div>
                                <input type="text"  name="answer_detail" required class="form-control" placeholder="回答">
                                <input type="hidden"  name="pid" required class="form-control" value="<?php print $id;?>">
                            </div>
                        </div>
                    </div>
                </div>



                <button type="submit" name="answer"  value="answer" class="btn btn-lg btn-secondary btn-block"><?=__('保存', 'young-bird')?></button>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
?>