<?php declare(strict_types=1);


namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Services\TokenService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class ApiUserController extends AbstractController
{
    private UserRepository $userRepository;
    private TokenService $tokenService;

    private UserPasswordHasherInterface $passwordHasher;
    private JWTTokenManagerInterface $jwtManager ;

    public function __construct(
        UserRepository              $userRepository,
        JWTTokenManagerInterface    $jwtManager,
        TokenService                $tokenService,
        UserPasswordHasherInterface $passwordHasher,
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
    }


    public function getUserByToken(Request $request): JsonResponse
    {
        $jsonContent = json_decode($request->getContent(), true);
        $token = $jsonContent["token"];
        $email = $this->tokenService->getEmailFromToken($token);
        $User = $this->userRepository->getUser($email);

        return $this->json($User, 200, []);

    }

    public function updatePasswordUserByToken(Request $request): JsonResponse
    {
        $jsonContent = json_decode($request->getContent(), true);
        $token = $jsonContent["token"];
        $password = $jsonContent["password"];
        $email = $this->tokenService->getEmailFromToken($token);
        $user = $this->userRepository->findOneBy(['email' => $email]);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $this->userRepository->updateUserPassword($email, $hashedPassword);
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $newToken = $this->jwtManager->create($user);
        return $this->json($newToken, 200, []);

    }

    public function updateNameUserByToken(Request $request): JsonResponse
    {
        $jsonContent = json_decode($request->getContent(), true);
        $token = $jsonContent["token"];
        $name = $jsonContent["name"];
        $email = $this->tokenService->getEmailFromToken($token);

        $this->userRepository->updateUserName($email, $name);
        $user = $this->userRepository->findOneBy(['email' => $email]);
        $newToken = $this->jwtManager->create($user);
        return $this->json($newToken, 200, []);

    }

    public function updateEmailUserByToken(Request $request): JsonResponse
    {
        $jsonContent = json_decode($request->getContent(), true);
        $token = $jsonContent["token"];
        $newEmail = $jsonContent["email"];
        $email = $this->tokenService->getEmailFromToken($token);
        $this->userRepository->updateUserEmail($email, $newEmail);
        $user = $this->userRepository->findOneBy(['email' => $newEmail]);
        $newToken = $this->jwtManager->create($user);

        return $this->json($newToken, 200, []);

    }

    public function deleteUserByToken(Request $request): JsonResponse
    {
        $token = $request->query->get('token');
        $email = $this->tokenService->getEmailFromToken($token);
        $User = $this->userRepository->deleteUser($email);

        return $this->json($User, 200, []);

    }
}
