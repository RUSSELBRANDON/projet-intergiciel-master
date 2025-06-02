<?php

namespace App\Enums;

enum GenreEnum: string
{
    case NOVEL = 'Novel';
    case SCIENCE_FICTION = 'Science Fiction';
    case FANTASY = 'Fantasy';
    case MYSTERY = 'Mystery';
    case HISTORICAL = 'Historical';
    case BIOGRAPHY = 'Biography';
    case POETRY = 'Poetry';
    case THEATER = 'Theater';
    case ESSAY = 'Essay';
    case YOUTH = 'Youth';
    case COMIC_MANGA = 'Comic/Manga';
    case HORROR = 'Horror';
    case ADVENTURE = 'Adventure';
    case ROMANCE = 'Romance';
    case SHORT_STORY = 'Short Story';
    case DOCUMENTARY = 'Documentary';
    case COOKING = 'Cooking';
    case ART = 'Art';
    case COMPUTER_SCIENCE = 'Computer Science';
    case SCIENCE = 'Science';

    /**
     * Retourne un tableau des genres pour les migrations/validations
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}