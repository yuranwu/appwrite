<?php

namespace Appwrite\Mongo;

use Appwrite\Mongo\Socket;
use Appwrite\Mongo\Auth;

class Connection {
  private $options;
  private $handle;
  private $auth;

  /**
   * Creates a new protocol instance
   *
   * @see    https://docs.mongodb.com/manual/reference/connection-string/
   * @param  string $url Mongo url style connection string
   * @param  [:string] $options
   */
  public function __construct(string $url, array $options = []) 
  {
    $this->options = [
      'params' => [],
      ...parse_url($url),
      ...$options,
    ];

    if(isset($this->options['query'])) {
      parse_str($this->options['query'], $params);

      unset($this->options['query']);

      $this->options['params'] += $params;
    }

    $this->conn = new Socket(
      $this->options['host'] ?? 'localhost',
      $this->options['port'] ?? 27017
    );

    $this->auth = Auth::mechanism();
  }

  public function endpoint(bool $usePassword = false): string {
    $endpoint = 'mongodb://';

    if(isset($this->options['user'])) {
      $pw = ($usePassword ? $this->options['pass'] : '**********');
      $endpoint .= $this->options['user'] . ':' . $pw . '@';
    }

    $endpoint .= $this->options['host'] . ':' . $this->options['port'] ?? 27017;

    $urlQuery = isset($this->options['path']) ? '&authSource=' . \ltrim($this->options['path'], '/') : '';

    foreach($this->options['params'] as $key => $value) {
      $urlQuery .= '&' . $key . '=' . $value;
    }

    $urlQuery && $endpoint .= '?' . substr($query, 1);

    return $endpoint;
  }
}