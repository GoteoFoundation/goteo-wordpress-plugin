<?php

class MatcherRepository {
  public function get($id) {
    $http_client = Goteo::http_client();

    $matcher = $http_client->get('/matchers/' . $id );

    return $matcher;
  }
}