<?php

namespace App\Mapper;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class BookMapper extends AbstractMapper
{
    public function __construct(
        public ?int $id,
        #[NotBlank]
        #[NotNull]
        public ?string $title,
        #[NotBlank]
        #[NotNull]
        public ?string $author,
        #[NotBlank]
        #[NotNull]
        #[Positive]
        #[Length(exactly: 4)]
        public ?int $publicationYear
    )
    {
    }
}
