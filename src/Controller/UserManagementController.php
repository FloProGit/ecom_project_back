<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserManagementController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    private TranslatorInterface $t;
    public function __construct( UserRepository $userRepository,
                                 EntityManagerInterface $entityManager,
                                 UserPasswordHasherInterface $passwordHasher,TranslatorInterface $t
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->t = $t;
    }

    public function index(): response
    {
        $result = $this->userRepository->findAll();

        $ConditonsForms = array_map(function (User $user) {
            return $this->createForm(UserType::class, $user)->createView();
        }, $result);

        $formularCreation = $this->createForm(UserType::class, new User())->createView();
        return $this->render('Pages/UserManagement/user_management.html.twig', [
             'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('user_management', domain: 'general')]]
            ]
            ,
            'user_forms_array' => $ConditonsForms,
            'user_form_create' => $formularCreation,
            'navbardata' => json_encode(['fm'=> 'catalogue','sm'=>'user_management'])
        ]);

    }

    #[CanDo(['ROLE_SUPER_ADMIN'],'user_list')]
    public function saveUser(User $User ,Request $request) : response
    {

        $User = $this->createForm(UserType::class, $User);

        $User->handleRequest($request);

        if ($User->isSubmitted() && $User->isValid()) {
            try {
                $userData = $User->getData();
                $this->entityManager->persist($userData);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        $this->addFlash("success",  "Contient le contenu de la notification ");
        return $this->redirectToRoute('user_list');
    }
    #[CanDo(['ROLE_SUPER_ADMIN'],'user_list')]
    public function createUser(Request $request) : response
    {
        $newUser = $this->createForm(UserType::class, new User());

        $newUser->handleRequest($request);

        if ($newUser->isSubmitted() && $newUser->isValid()) {
            try {
                $userData = $newUser->getData();
                $userData->setCreatedAt(new \DateTimeImmutable());
                $userData->setUpdatedAt(new \DateTimeImmutable());
               $hashedPassword = $this->passwordHasher->hashPassword(
                    $userData,
                    'azerty1234' // a changé pour un system de password temporaire lors de la validation du compte
                );
                $userData->setPassword($hashedPassword);
                $this->entityManager->persist($userData);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            }
        }
        $this->addFlash("success",  "Utilisateur créé ");
        return $this->redirectToRoute('user_list');
    }

    #[CanDo(['ROLE_SUPER_ADMIN'],'user_list')]
    public function deleteUser(User $user)
    {
        try{
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
        catch (\Exception $e)
        {
            $this->addFlash("danger",  "Oups! quelque chose c'est mal passé ");
            return $this->redirectToRoute('user_list');

        }
        $this->addFlash("warning",  "suppression effectué");
        return $this->redirectToRoute('user_list');
    }
}
