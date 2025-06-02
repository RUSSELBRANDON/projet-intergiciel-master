<?php

namespace App\Enums;

  enum BorrowingRequestStatusEnum: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
  }