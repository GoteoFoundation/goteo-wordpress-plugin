<?php

class Goteo_HttpClient {
  
  private $base_url;
  private $api_key;
  private $api_user;
  private $api_token;

  public function __construct() {
    $this->base_url = get_option('goteo_base_api_url');
    $this->api_key = get_option('goteo_key');
    $this->api_user = get_option('goteo_user');
  }

  public function get($uri) {
    $url = $this->base_url . $uri;

    if (get_transient('goteo_access_token')) {
      $args = array(
        'headers' => array(
          'Authorization' => 'Bearer ' . base64_encode( get_transient('goteo_access_token') )
        )
      );
    } else {
      $args = array(
        'headers' => array(
          'Authorization' => 'Basic ' . base64_encode( $this->api_user . ":" . $this->api_key)
        )
      );
    }

    $response = wp_remote_get($url, 
      $args
    );

    $response_code = wp_remote_retrieve_response_code( $response );
    // if (is_wp_error($response) || !$this->is_successful($response_code)) {
      // throw new HttpClientException($response);
    // }

    $body = wp_remote_retrieve_body($response);

    return json_decode($body);
  }

  public function login() {

    if (get_transient('goteo_access_token'))
      return true;

    $url = $this->base_url . '/login';
    $args = array(
      'headers' => array(
        'Authorization' => 'Basic ' . base64_encode( $this->api_user . ":" . $this->api_key)
      )
    );

    $response = wp_remote_get($url, 
      $args
    );

    $response_code = wp_remote_retrieve_response_code( $response );
    if (is_wp_error($response)) {
      return false;
    }

    if ($response.ok) {
      $body = json_decode(wp_remote_retrieve_body($response));
      set_transient('goteo_access_token', $body->access_token, $body->expires_in); 
      $this->token = $body->access_token;
    }

    return true;

  }

}