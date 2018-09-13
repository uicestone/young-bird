<?php

class YB_REST_Profile_Controller extends WP_REST_Controller {

  /**
   * Register the REST API routes.
   */
  public function register_routes() {
    register_rest_route('yb', 'school/(?P<keyword>.+)', array(
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array( $this, 'search_schools' ),
      )
    ));
    register_rest_route('yb', 'major/(?P<keyword>.+)', array(
      array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => array( $this, 'search_majors' ),
      )
    ));
  }

  /**
   * Search schools
   *
   * @param WP_REST_Request $request
   * @return WP_Error|WP_REST_Response
   */
  public static function search_schools( $request ) {
    $keyword = $request->get_param('keyword');

    if (!$keyword) {
      return rest_ensure_response(array());
    }

    $schools = json_decode(get_option('schools'));
    $schools = array_slice(array_values(array_map(function($school_array) {
      return $school_array[0];
    }, array_filter($schools, function($school_array) use($keyword) {
      $school_name = $school_array[0];
      $school_abbr = $school_array[1] ?: null;
      return stripos($school_name, $keyword) !== false
        || stripos($school_abbr, $keyword) !== false;
    }))), 0, 10);

    return rest_ensure_response($schools);
  }

  /**
   * Search majors
   *
   * @param WP_REST_Request $request
   * @return WP_Error|WP_REST_Response
   */
  public static function search_majors( $request ) {
    $keyword = $request->get_param('keyword');

    if (!$keyword) {
      return rest_ensure_response(array());
    }

    $lang = $request->get_param('lang') ?: pll_default_language();
    $majors = json_decode(get_option('majors_' . $lang));
    $majors = array_slice(array_values(array_filter($majors, function($major) use($keyword) {
      return stripos($major, $keyword) !== false;
    })), 0, 10);
    return rest_ensure_response($majors);
  }

}

(new YB_REST_Profile_Controller())->register_routes();
