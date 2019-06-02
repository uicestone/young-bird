<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2018/12/20
 * Time: 16:42
 */
/*
Template Name: 添加学校
*/


$cert_template_participation_path = get_attached_file(102215);
$filename = 'CERTIFICATE-CAMPUS' .'111' . '.jpg';
$cert_participate = Image::make($cert_template_participation_path);
$cert_participate->text('啊啊啊', 115, 680, function(Font $font) {
    $font->file(FONT_PATH . 'FZSHFW.TTF');
    $font->size(55);
    $font->color('#1D2088');
    $font->align('left');
})->text('AAAAAA', 115, 940, function(Font $font) {
    $font->file(FONT_PATH . 'DINMedium.ttf');
    $font->size(32);
    $font->color('#1D2088');
    $font->align('left');
})->text('啊啊啊', 400, 1115, function(Font $font) {
    $font->file(FONT_PATH . 'FZSHFW.TTF');
    $font->size(34);
    $font->color('#1D2088');
    $font->align('left');
})->save(wp_upload_dir()['path'] . '/' . $filename);
?>


<?php

$current_url = home_url(add_query_arg(array()));
if( !current_user_can( 'manage_options' ) ) {
    return ;
}
$my_post=0;
if(isset($_POST['add-school'])){

    $my_post = array(
        'post_title'    =>$_POST['cschool'],
        'post_type'=>'campus_school',
        'post_content'  =>$_POST['cschool'],
        'post_status'   => 'publish',
        'post_author'   => get_current_user_id(),
        'meta_input'=>array('country'=>$_POST['country'],'city'=>$_POST['city'],'school_name'=>$_POST['cschool']),
    );
    $my_post=wp_insert_post( $my_post, $wp_error );


}



?>



<!-- Banner -->
<!-- for desktop -->
<?php






get_header(); ?>
<!-- Banner -->

    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
        <div class="container">
            <h1>添加学校 <br></h1>
        </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
        <div class="row align-items-center">
            <div class="col-md-10 d-none d-md-flex justify-content-center align-items-center logo">
                <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
            </div>
            <div class="col-md-12 offset-md-2">
                <?php if($my_post>0)
                            echo '添加成功';?>

                <form method="POST" accept-charset="UTF-8">

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-lg">
                                    <input type="text"  name="country" required class="form-control" placeholder="<?=__('国家', 'young-bird')?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-lg">
                                    <input type="text"  name="city" required class="form-control" placeholder="<?=__('城市', 'young-bird')?>">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="text"  name="cschool"  required class="form-control" placeholder="<?=__('学校', 'young-bird')?>">
                        </div>
                    </div>


                    <button type="submit" name="add-school"  value="add-school" class="btn btn-lg btn-secondary btn-block"><?=__('保存', 'young-bird')?></button>
                </form>
            </div>
        </div>
    </div>

<?php get_footer(); ?>