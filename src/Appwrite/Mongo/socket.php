<?php 

namespace Appwrite\Mongo;

class SocketException extends \Exception {}

class Socket {
  protected string $host;
  protected int $port;
  protected int $timeout;

  protected bool $connected = false;

  protected $stream;


  /**
   * Socket constructor.
   * @param string $ip
   * @param int $port
   * @param int|float $timeout
   */
  public function __construct(string $host = '127.0.0.1', int $port = 27017, int $timeout = 20) 
  {
    $this->host = $host;
    $this->port = $port;
    $this->timeout = $timeout;
  }

  public function write(string $data):string
  {
    fwrite(
      $this->getStream(),
      $data,
      strlen($data)
    );

    return $this->read();
  }

  public function read(): ?string
  {
    $response = null;

    while($chunk = fread($this->getStream(), 1024))
    {
      $response .= $chunk;

      if(substr($chunk, -1) === "\n")
      {
        break;
      }
    }

    return $response;
  }

  protected function getStream()
  {
    // First run?
    if(!is_resource($this->stream))
    {
      $this->connect();

      return $this->stream;
    }

    $stream_meta = \stream_get_meta_data($this->stream);
    
    if($stream_meta['timed_out'] || $stream_meta['eof'])
    {
      $this->connect();
    }
    return $this->stream;
  }

  public function connect() 
  {
    $stream = \stream_socket_client(
      sprintf('tcp://%s:%d', $this->host, $this->port),
      $errno,
      $errstr,
      $this->timeout
    );

    if(!\is_resource($stream)) {
      throw new SocketException(sprintf('Unable to connect to %s:%d - %s', $this->host, $this->port, $errstr));
    }

    \stream_set_timeout($stream, $this->timeout);
    \stream_set_blocking($stream, true);

    $this->stream = $stream;
    $this->connected = true;

    return $this;
  }

  public function disconnect()
  {
    if(is_resource($this->stream)) 
    {
      \fclose($this->stream);
    }

    return $this;
  }
}