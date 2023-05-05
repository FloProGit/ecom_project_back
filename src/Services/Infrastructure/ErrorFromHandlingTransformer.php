<?php declare(strict_types=1);


namespace App\Services\Infrastructure;

use Symfony\Component\Form\FormErrorIterator;

final class ErrorFromHandlingTransformer {

    private FormErrorIterator $errorIterator;
    public function __construct(FormErrorIterator $errorIterator)
    {
        $this->errorIterator = $errorIterator;
    }

    public function __toString(): string
    {
        $countError = $this->errorIterator->count();
        $messageReturned = "";
        for ($i = 0 ; $i < $countError; $i++)
        {
            $messageReturned .= $this->errorIterator[$i]->getMessage();
            $messageReturned .= "\n";
        }


        return $messageReturned;
    }

}
