<?php

class MatcherRepository {
  public function get($id) {
    $http_client = Goteo::http_client();

    $matcher = $http_client->get('/matchers/' . $id );

    if (!$matcher) {
      $matchers_array = $http_client->get('/matchers');
      $matchers = array_filter(current($matchers_array), function($obj) use ($id) {
        return ($obj->owner == $id);
      });

      $matcher = current($matchers);
    }

    return $matcher;
  }
}