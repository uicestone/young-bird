<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
add_action( 'cmb2_admin_init', function () {

  $event_gallery_metabox = new_cmb2_box(array (
    'id'           => 'event_gallery_metabox',
    'title'        => esc_html__( '精彩瞬间', 'cmb2' ),
    'object_types' => array ( 'event' )
  ));

  $event_gallery_metabox->add_field( array(
    'name' => '图片',
    'id'   => 'gallery',
    'type' => 'file_list',
    'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
    'query_args' => array( 'type' => 'image' ), // Only images attachment
  ) );

  $avatar_meta_box = new_cmb2_box(array (
    'id'           => 'avatar_metabox',
    'title'        => esc_html__( '头像', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge',
  ));

  $avatar_meta_box->add_field(array (
    'name' => esc_html__( '头像', 'cmb2' ),
    'id' => 'avatar',
    'type' => 'file',
    'query_args' => array (
      'type' => array(
        'image/gif',
        'image/jpeg',
        'image/png',
      )
    )
  ));

  $mobile_meta_box = new_cmb2_box(array (
    'id'           => 'mobile_metabox',
    'title'        => esc_html__( '手机', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge',
  ));

  $mobile_meta_box->add_field(array (
    'name' => esc_html__( '手机', 'cmb2' ),
    'id' => 'mobile',
    'type' => 'text_medium',
    'attributes' => array (
      'type' => 'number'
    )
  ));

  $birthday_meta_box = new_cmb2_box(array (
    'id'           => 'birthday_metabox',
    'title'        => esc_html__( '生日', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge',
  ));

  $birthday_meta_box->add_field(array (
    'name' => esc_html__( '生日', 'cmb2' ),
    'id' => 'birthday',
    'type' => 'text_date',
    'attributes' => array (
      'data-datepicker' => json_encode(array (
        'yearRange' => '-100:-10',
        'defaultDate' => '-30y',
        'showMonthAfterYear' => true
      ))
    ),
    'date_format' => 'Y-m-d'
  ));

  $identities_meta_box = new_cmb2_box(array (
    'id'           => 'identities_metabox',
    'title'        => esc_html__( '身份', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge',
  ));

  $identities_meta_box->add_field(array (
    'name' => esc_html__( '身份', 'cmb2' ),
    'desc' => esc_html__( '大咖的身份，一行表示一个', 'cmb2' ),
    'id' => 'identities',
    'type' => 'text',
    'repeatable' => true,
    'text' => array (
      'add_row_text' => __('新增身份', 'young-bird')
    )
  ));

  $titles_meta_box = new_cmb2_box(array (
    'id'           => 'titles_metabox',
    'title'        => esc_html__( '机构/部门头衔', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge'
  ));

  $titles_meta_box->add_field(array (
    'name' => esc_html__( '机构/部门头衔', 'cmb2' ),
    'desc' => esc_html__( '大咖所属机构以及部门头衔，用斜杠（/）分隔，一行表示一个', 'cmb2' ),
    'id' => 'titles',
    'type' => 'text',
    'attributes' => array (
      'placeholder' => '小桔科技/华东区市场经理',
    ),
    'repeatable' => true,
    'text' => array (
      'add_row_text' => '新增机构/部门头衔'
    )
  ));

  $awards_meta_box = new_cmb2_box(array (
    'id'           => 'awards_metabox',
    'title'        => esc_html__( '奖项', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge'
  ));

  $awards_meta_box->add_field(array (
    'name' => esc_html__( '奖项', 'cmb2' ),
    'desc' => esc_html__( '大咖的所获奖项，一行表示一个', 'cmb2' ),
    'id' => 'awards',
    'type' => 'text',
    'repeatable' => true,
    'text' => array (
      'add_row_text' => __('新增奖项', 'young-bird')
    )
  ));

  $resume_meta_box = new_cmb2_box(array (
    'id'           => 'resume_metabox',
    'title'        => esc_html__( '简历', 'cmb2' ),
    'object_types' => array ( 'user' ),
    'show_on_cb'   => 'ybp_cmb2_show_on_user_role_judge',
  ));

  $resume_meta_box->add_field(array (
    'name' => esc_html__( '简历', 'cmb2' ),
    'id' => 'resume',
    'type' => 'file'
  ));

});

/**
 * Only show the box in user with role of 'judge'
 *
 * @param $field
 * @return bool
 */
function ybp_cmb2_show_on_user_role_judge ($field) {
  $user = get_user_by('ID', $field->object_id());
  if (!$user) {
    return false;
  }
  return in_array('judge', $user->roles);
}
