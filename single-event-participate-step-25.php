    <!-- Banner -->
    <!-- for desktop -->

    <?php

    $tax=array();



    foreach (get_terms('user_source', array('hide_empty' => false, 'orderby' => 'ID', 'order' => 'asc')) as $term)
    {
        if($term->parent==0){
            $tax[$term->term_id]=$term;
        }
        else{
            $tax[$term->parent]->isparent=1;

            $child=$tax[$term->parent]->child;
            $child[$term->term_id]=$term;
            $tax[$term->parent]->child=$child;


        }
    };

    if(ICL_LANGUAGE_CODE=='en')
        unset($tax[829]);
    unset($tax[988]);
    ?>

    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop')['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad')['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone')['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-32 mt-md-7 pb-48 pb-md-7 sign-up page-collect">
        <div class="row align-items-center">
            <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
                <img src="<?=get_field('logo')['url']?>" alt="">
            </div>
            <div class="col-md-12 offset-md-2">
                <h3 class="color-silver text-left mb-4" style="padding-left:1.25rem !important;font-size:1.5rem;font-weight:500;">
                    <?php  if(ICL_LANGUAGE_CODE=='en'):?>
                        Where did you get to know us?
                    <?php else:?>
                    您是从什么渠道知道我们竞赛的?
                    <?php endif;?>

                </h3>
                <form method="post" accept-charset="UTF-8">
                    <div class="form-group">
                        <ul>
                            <?php foreach($tax as $v):?>
                            <?php if($v->isparent!=1):?>
                                <li class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ybp_collect[]"   value="<?=$v->term_id;?>" id="<?=$v->slug?>">
                                    <label class="form-check-label" for="<?=$v->slug?>">
                                        <?=$v->name;?>
                                    </label>
                                </li>
                             <?php else:?>

                                    <li>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="<?=$v->slug?>" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <?=$v->name;?>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="<?=$v->slug?>">
                                                <?php foreach($v->child as $v1):?>
                                                <div class="dropdown-item">
                                                    <input class="form-check-input" type="checkbox" name="ybp_collect[]"  value="<?=$v1->term_id;?>" id="<?=$v1->slug?>">
                                                    <label class="form-check-label" for="<?=$v1->slug?>">
                                                        <?=$v1->name;?>
                                                    </label>
                                                </div>
                                                <?php endforeach;?>


                                            </div>
                                        </div>
                                    </li>
                            <?php endif;?>
                            <?php endforeach;?>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" name="ybp_collect[]" value="0" id="other">
                                <label class="form-check-label" for="other">


                                    <?php  if(ICL_LANGUAGE_CODE=='en'):?>
                                       Others
                                    <?php else:?>
                                        其他
                                    <?php endif;?>
                                </label>
                            </li>
                            <li>

                                <div class="input-group ybp_other">
                                    <?php  if(ICL_LANGUAGE_CODE=='en'):?>
                                        <input type="text"  name="ybp_other" class="form-control" placeholder="Others">
                                    <?php else:?>
                                        <input type="text"  name="ybp_other" class="form-control" placeholder="其他渠道">
                                    <?php endif;?>

                                </div>

                            </li>
                        </ul>

                    </div>

                    <button type="submit" name="participate" value="step-3" class="btn btn-lg btn-secondary btn-block"><?=__('下一步', 'young-bird')?></button>
                </form>
            </div>
        </div>
    </div>

    <script>

        $(function(){

            $(".page-collect form").submit(function(e){
                if($("#other").is(":checked")){
                    console.log("break");
                    var YesVal = $("input[name='ybp_other']").val()
                    if(YesVal){
                        // alert("Submit seccess");
                    }
                    else{
                        $("input[name='ybp_other']").addClass("collect_need")
                        <?php  if(ICL_LANGUAGE_CODE=='en'):?>
                        $("input[name='ybp_other']").attr('placeholder','Please fill in the blank');

                        <?php else:?>
                        $("input[name='ybp_other']").attr('placeholder','请填写其他选项');
                     ;
                        <?php endif;?>
                        e.preventDefault();
                    }
                }
                else{
                    // alert("Submit prevented");
                }
            });

        })

    </script>


