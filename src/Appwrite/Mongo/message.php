<?php

namespace Appwrite\Mongo\Message;

class Header {
  public int $messageLength;
  public int $requestID;
  public int $responseTo;
  public int $opCode;
}

class Message {
  public Header $header;
  public int $flags;
  public array $sections;
  public int $checksum;
  
  public function __construct(Header $header, int $flags, array $sections, int $checksum = -1) {
    $this->header = $header;
    $this->flags = $flags;
    $this->sections = $sections;
    $this->checksum = $checksum;
  }

  
}