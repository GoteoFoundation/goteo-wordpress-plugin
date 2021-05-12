<?php

class MatcherProjectRepository {

  public function getProjects($id) {
    $http_client = Goteo::http_client();

    $projects = $http_client->get('/matchers/' . $id . '/projects');

    return $projects->items;
  }
}