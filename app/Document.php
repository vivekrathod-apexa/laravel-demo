<?php

// Document.php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

  protected $fillable = [
    'filename','file_path'
  ];

     
}