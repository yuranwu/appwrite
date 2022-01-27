<?php

namespace Appwrite\Mongo;

use Appwrite\Mongo\Scram;


class Auth
{
  //https://docs.mongodb.com/manual/core/security-scram/

  public static function mechanism()
  {
    return new Scram();
  }
}