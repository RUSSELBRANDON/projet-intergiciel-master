<?php

namespace App\Enums;

  enum EmailTypeEnum: string {
    case EMAILLOANREQUEST = 'emailloanrequest';
    case EMAILLOANREPLY = 'emailloanreply';
    case EMAILDUEREMINDER = 'emailduereminder';
    case EMAILBOOKAVAILABLE = 'emailbookavailable';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
  }