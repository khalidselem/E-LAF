<?php
  namespace iberezansky\fb3d;

  function rec_stripslashes($mixed) {
    return  is_array($mixed) ? array_map('\iberezansky\fb3d\rec_stripslashes', $mixed) : stripslashes($mixed);
  }

  function is_request_allowed() {
    $res = false;
    if(wp_verify_nonce($_POST[NONCE], NONCE) && is_user_logged_in()) {
      $user = wp_get_current_user();
      $roles = (array)$user->roles;
      $res = array_search('administrator', $roles)!==false;
    }
    return $res;
  }

  function receive_question_answer_json() {
    if(is_request_allowed()) {
      global $fb3d;
      $data = plane2struct(array2plane($_POST), [
        'base'=> [
          'question-id'=> ['default'=> 'unknown', 'qualifier'=> '%s'],
          'question-state'=> ['default'=> 0, 'qualifier'=> '%d'],
        ]
      ]);
      $q = $data['question'];
      $fb3d['options']['questions'][$q['id']] = [
        'state'=> $q['state'],
        'date'=> date(DTM_FORMAT)
      ];
      push_options();
      wp_send_json(['code'=> CODE_OK]);
    }
  }

  add_action('wp_ajax_fb3d_receive_question_answer', '\iberezansky\fb3d\receive_question_answer_json');

?>
