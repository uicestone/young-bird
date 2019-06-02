<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2019-01-24
 * Time: 19:44
 */


$id_dl = pll_get_post(get_the_ID(), pll_default_language());

$like_posts = get_user_meta(get_current_user_id(), 'like_posts') ?: array();
if (isset($_POST['like'])) {
    redirect_login();
    $like = json_decode($_POST['like']);
    if ($like && !in_array($id_dl, $like_posts)) {
        add_user_meta(get_current_user_id(), 'like_posts', $id_dl);

            $likes = (get_post_meta($id_dl, 'like', true) ?: 0) + 1;
            update_post_meta($id_dl, 'like', $likes);



    }
        if (!$like && in_array($id_dl, $like_posts)) {

        delete_user_meta(get_current_user_id(), 'like_posts', $id_dl);
        $likes = (get_post_meta($id_dl, 'like', true) ?: 0) -1;
        update_post_meta($id_dl, 'like', $likes);
    }
    if(!$likes)
        $likes=0;
    echo $likes; exit;
}


?>