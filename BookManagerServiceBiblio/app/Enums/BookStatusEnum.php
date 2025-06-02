<?php

namespace App\Enums;

  enum BookStatusEnum: string {
    case AVAILABLE = 'available';
    case BORROWED = 'borrowed';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
  }