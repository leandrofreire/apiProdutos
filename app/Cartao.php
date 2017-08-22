<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
  protected $fillable = [
      'numero', 'data', 'cvv', 'titular', 'cpf',
  ];
}
