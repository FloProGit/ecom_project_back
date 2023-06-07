<?php
declare(strict_types=1);

namespace App\Services;



use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

final class TokenService{

    private  JWTEncoderInterface $JWTEncoder;

    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->JWTEncoder = $JWTEncoder;
    }

    public function getEmailFromToken(string $token):string
    {
        return $this->JWTEncoder->decode($token)["username"];
    }


}