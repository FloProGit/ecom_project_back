<?php
declare(strict_types=1);

namespace App\Form\Constraints;

use Symfony\Component\Validator\Constraints\Length;

 class LengthConstraint extends Length
{
    public function __construct(
        int $min = null,
        int $max = null,
        string $minMessage = null,
        string $maxMessage = null,
        array $options = []
    ) {
        $minMessage = $minMessage ?? 'Must be at least '.$min.' characters long' ;
        $maxMessage = $maxMessage ?? 'Cannot be longer than '.$max.' characters' ;

        parent::__construct(null, $min, $max, null, null, null, $minMessage, $maxMessage,
            null, null, null, $options);
    }
    public function validatedBy()
    {
        return Length::class.'Validator';
    }
}
