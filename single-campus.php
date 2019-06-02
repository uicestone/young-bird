<?php
redirect_login();

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$user=wp_get_current_user();
$status=0;
$participate_fields = ['wechat_number','name', 'sex', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title','phone','bankcard','address','bank'];
foreach ($participate_fields as $field) {
    $$field =  get_user_meta(get_current_user_id(), $field, true);
}
if (isset($_POST['change-school'])){
    $schools=get_post_meta(get_the_ID(),'school',true);

    $schoolsarray=array();
    foreach($schools as $v)
    {
        $school_city=get_post_meta($v,'city',true);

        $cityarray[$school_city]=1;

        if($school_city==$_POST['city']){
            $schoolsarray[$v]=get_post($v);
         //   $schoolsarray[$v]['school']=get_post_meta($v,'school',true);
            $schoolsarray[$v]->pllID=pll_get_post($v,pll_default_language());
        }
    }
    echo json_encode($schoolsarray);
    exit;
}

if (isset($_POST['participate'])) {


    foreach ($participate_fields as $field) {
        if (isset($_POST[$field])) {

            if (!$$field) {
                add_user_meta(get_current_user_id(), $field, $_POST[$field]);
            } else
                update_user_meta(get_current_user_id(), $field, $_POST[$field]);

        }

    }
    $next_step = $_POST['participate'];
    $step=$_POST['participate'];
    if($step=='step-3'){
        $applyed=get_posts(array(
                'post_type'=>'campus_apply',
                'meta_query'=>array(
                    array('key' => 'campus_id', 'value' => $id_dl),
                    array('key' => 'status', 'value' => 'pass'),

                )
        ));
        $applyedschools=array();
        foreach($applyed as $v){

            $applyedschoold_id=get_post_meta($v->ID,'school_id',true);
            foreach($_POST['apply_school'] as $v1){
                if(in_array($v1,$applyedschoold_id)){
                    $applyedschools[]=$v1;
                }
            }
        }

        if(empty($applyedschools)){
            $new_apply=array(
                'post_title'    =>$name.'申请-'.$id_dl,
                'post_type'=>'campus_apply',
                'post_content'  =>$name.'申请-'.$id_dl,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input'=>array('campus_id'=>$id_dl,'status'=>'unaudited','school_id'=>$_POST['apply_school']),

            );
          //  $new_apply=wp_insert_post( $new_apply, $wp_error );
            session_start();
            $_SESSION['new_apply'][$id_dl]=$new_apply;
          //      add_post_meta($new_apply,'school_id',$_POST['apply_school']);
         //   echo $my_post;
        }
        else{


            $string='您申请的<span>';
            foreach($applyedschools as $v){

                $applyed_school=get_post($v);
                $string.=$applyed_school->post_title.',';
            }
            $string=mb_substr($string,0,mb_strlen($string)-1);
            $string.='</span>已经被其他站长占用，请重新进行选择!';
            session_start();
            $_SESSION['applyed_school']=$string;
            header('Location: ' . get_the_permalink() . '?participate=step-2');
            exit;
        }

    }


    if($step=='step-4'){

        $applyed=get_posts(array(
            'post_type'=>'campus_apply',
            'meta_query'=>array(
                array('key' => 'campus_id', 'value' => $id_dl),
                array('key' => 'status', 'value' => 'pass'),

            )
        ));
        $applyedschools=array();
        foreach($applyed as $v){

            $applyedschoold_id=get_post_meta($v->ID,'school_id',true);
            foreach($_POST['apply_school'] as $v1){
                if(in_array($v1,$applyedschoold_id)){
                    $applyedschools[]=$v1;
                }
            }
        }

        if(empty($applyedschools)){
            $new_apply=array(
                'post_title'    =>$name.'申请-'.$id_dl,
                'post_type'=>'campus_apply',
                'post_content'  =>$name.'申请-'.$id_dl,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input'=>array('campus_id'=>$id_dl,'status'=>'unaudited','school_id'=>$_POST['apply_school']),

            );
            $_SESSION['new_apply'][$id_dl]=$new_apply;
            //$new_apply=wp_insert_post( $new_apply, $wp_error );

            //echo $my_post;
        }
        else{


            $string='您申请的<span>';
            foreach($applyedschools as $v){

                $applyed_school=get_post($v);

                $string.=$applyed_school->post_title.',';
            }
            $string=mb_substr($string,0,mb_strlen($string)-1);
            $string.='</span>已经被其他站长占用，请重新进行选择!';

            $_SESSION['applyed_school']=$string;
            header('Location: ' . get_the_permalink() . '?participate=step-3');
            exit;
        }

    }


    if($step=='step-5'){


        $applyed=get_posts(array(
            'post_type'=>'campus_apply',
            'meta_query'=>array(
                array('key' => 'campus_id', 'value' => $id_dl),
                array('key' => 'status', 'value' => 'pass'),

            )
        ));
        $applyedschools=array();
        foreach($applyed as $v){

            $applyedschoold_id=get_post_meta($v->ID,'school_id',true);
            foreach($_POST['apply_school'] as $v1){
                if(in_array($v1,$applyedschoold_id)){
                    $applyedschools[]=$v1;
                }
            }
        }

        if(empty($applyedschools)){
            $new_apply=array(
                'post_title'    =>$name.'申请-'.$id_dl,
                'post_type'=>'campus_apply',
                'post_content'  =>$name.'申请-'.$id_dl,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input'=>array('campus_id'=>$id_dl,'status'=>'unaudited','school_id'=>$_POST['apply_school']),

            );
            //  $new_apply=wp_insert_post( $new_apply, $wp_error );
            session_start();
            $_SESSION['new_apply'][$id_dl]=$new_apply;
            //      add_post_meta($new_apply,'school_id',$_POST['apply_school']);
            //   echo $my_post;
        }
        $applyed=get_posts(array(
            'post_type'=>'campus_apply',
            'meta_query'=>array(
                array('key' => 'campus_id', 'value' => $id_dl),
                array('key' => 'status', 'value' => 'pass'),

            )
        ));
        $applyedschools=array();

        foreach($applyed as $v){

            $applyedschoold_id=get_post_meta($v->ID,'school_id',true);
            foreach($_POST['apply_school'] as $v1){
                if(in_array($v1,$applyedschoold_id)){
                    $applyedschools[]=$v1;
                }
            }
        }

        if(empty($applyedschools)){

            $new_apply=$_SESSION['new_apply'][$id_dl];

            $new_apply=wp_insert_post( $new_apply, $wp_error );
            wp_mail($mail,
                __('收到新的站长申请', 'young-bird') ,
                '收到新的站长申请',
                array('Content-Type: text/html; charset=UTF-8', 'Cc: ' . 'campus@youngbird.com.cn')
            );

            add_user_meta(get_current_user_id(),'campus_head_pre',$id_dl);

            $_SESSION['new_apply'][$id_dl]['post_id']=$new_apply;
            header('Location: ' . get_the_permalink() . '?participate=step-4&appled=1');
            exit;
            //echo $my_post;
        }
        else{


            $string='您申请的<span>';
            foreach($applyedschools as $v){

                $applyed_school=get_post($v);

                $string.=$applyed_school->post_title.',';
            }
            $string=mb_substr($string,0,mb_strlen($string)-1);
            $string.='</span>已经被其他站长占用，请重新进行选择!';
            session_start();
            $_SESSION['applyed_school']=$string;
            header('Location: ' . get_the_permalink() . '?participate=step-3');
            exit;
        }

    }


    header('Location: ' . get_the_permalink() . '?participate=' . $next_step);
    exit;

}


$user_applyed=get_posts(array(
    'post_type'=>'campus_apply',
    'author'=>get_current_user_id(),
    'meta_key'=>'campus_id',
    'meta_value'=>$id_dl,
));


if($user_applyed)
    $status=get_post_meta($user_applyed[0]->ID,'status',true);

if($status==='pass') {

    include(locate_template('single-campus-upload.php'));
    exit;
}

if(get_post_meta($id_dl,'enable',true)==false){
    header('Location: ' .pll_home_url() . 'campus');
    exit;
}
if($status!==0&&!current_user_can( 'manage_options' )&&(!isset($_GET['appled'])))
    exit;
if(isset($_GET['participate'])):
    $step = $_GET['participate'] ?: 'step-1';
    $user = wp_get_current_user();
    if($step=='step-3'){
        if(!isset($_SESSION['new_apply'][$id_dl])) {
            header('Location: ' . get_the_permalink() . '?participate=step-2');
            exit;
        }
    }
    include(locate_template('single-campus-participate-' . $step . '.php'));
else:





    get_header();?>

    <div class="container mt-210 pb-7 user-center-body">
        <form   method="POST" accept-charset="UTF-8">
            <div class="row d-flex justify-content-center flex-column ag_info_container">

                <div class="col-lg-24 col-xl-18 mx-auto p-xs-0 ">
                    <div class="row mx-auto agree-info-container">
                        <div class="col-24">
                            <h2><?=__('站长须知', 'young-bird')?>：</h2>
                            <?php
                                    $xuzhi=94901;
                                if(ICL_LANGUAGE_CODE=='en_US')
                                    $xuzhi=94905;?>
                            <p><?php print get_post($xuzhi)->post_content;?></p>
                        </div>
                    </div>
                </div>
                <div class="agree_box mx-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" required value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1"><?=__('我知晓并同意遵守以上【站长须知】', 'young-bird')?></label>
                    </div>
                </div>
                <div class="row mx-auto justify-content-between agree_conform_box">
                    <div class="d-flex justify-content-between align-items-end third-party">
                        <a href="<?php print pll_home_url();?>/campus" class="btn bnt_nomal btn_back" data-toggle="modal" data-target="#success_hasBack"><?=__('返回', 'young-bird')?></a>
                        <button type="submit"  name="participate" value="step-2" class="btn bnt_nomal btn_conform"><?=__('同意并申请', 'young-bird')?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <?php get_footer(); ?>

    <?php if(isset($_GET['appled'])):?>
    <div class="modal fade" id="warning_has" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?=$_SESSION['applyed_school'];?></p>
                </div>
            </div>
        </div>
    </div>

    <?php unset($_SESSION['applyed_school']);?>

    <script>
        $(function () {
            $(document).ready(function () {
                $('#warning_has').modal();
            });

        });
    </script>
<?php endif;?>



<?php endif;?>
