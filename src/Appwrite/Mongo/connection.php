<?php

namespace Appwrite\Mongo;

class Connection {
  private string $address;
  private int $port;
  private \Socket $socket;

  private const MAX_BUFFER_SIZE = 1024;
  
  public function __construct(string $address, int $port) {
    $this->address = $address;
    $this->port = $port;
    $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  }

  public function connect() {
    socket_connect($this->socket, $this->address, $this->port);

    return $this;
  }

  public function disconnect() {
    socket_close($this->socket);

    return $this;
  }

  public function write(string $data) {
    socket_write($this->socket, $data, strlen($data));

    return $this;
  }

  public function read() {
    $buffer = '';

    while ($data = socket_read($this->socket, self::MAX_BUFFER_SIZE)) {
      $buffer .= $data;
    }

    return $buffer;
  }
}