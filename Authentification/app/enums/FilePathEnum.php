<?php

namespace App\Enums;

enum FilePathEnum: string
{
    case PROFILE_IMAGES = 'profile_images';
    case DOCUMENTS = 'documents';
    case BLOG_IMAGES = 'blog/images';
    case USER_FILES = 'users/files';

    public function getStoragePath(): string
    {
        return match($this) {
            self::PROFILE_IMAGES => 'profile_images',
            self::DOCUMENTS => 'documents',
            self::BLOG_IMAGES => 'blog/images',
            self::USER_FILES => 'users/files',
        };
    }
}


