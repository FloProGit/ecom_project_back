<?php


namespace App\Controller\Api;




use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterController extends AbstractController{


    public function index(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        Request $request):JsonResponse
    {
        $decoded = json_decode($request->getContent(),true);
        $email = $decoded["username"];
        $name = $decoded["name"];

        $plaintextPassword = $decoded["password"];

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setName($name);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setRoles(['USER_CUSTOMER']);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Registered Successfully']);
    }
}