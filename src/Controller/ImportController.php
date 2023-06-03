<?php declare(strict_types=1);



namespace App\Controller;



use App\Entity\Attribute;
use App\Form\AttributeType;
use App\Form\ImportType;
use App\Repository\AttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Psr\Log\LoggerInterface;
final class ImportController extends AbstractController
{

    private AttributeRepository $attributeRepository;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $t;
    public function __construct(
        AttributeRepository $attributeRepository ,
        EntityManagerInterface $entityManager,
        TranslatorInterface $t,
        private LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->attributeRepository = $attributeRepository;
        $this->t = $t;


    }

    public function index()
    {
        $form = $this->createForm(ImportType::class);



        return $this->render('Pages/Tools/import.html.twig', [
             'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('export', domain: 'general')]]
            ],
            'import_form'=>$form,
            'navbardata' => json_encode(['fm'=> 'Tools','sm'=>'export'])
        ]);
    }

    public function importDataFromFile(Request $request,KernelInterface $kernel)
    {
        $content = null;
        $form = $this->createForm(ImportType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('csv_file')->getData();

             $file->move(
                 $this->getParameter('download_directory').DIRECTORY_SEPARATOR.'temp',
                 $file->getClientOriginalName()
             );

            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput([
                'command' => 'app:create-product-from-prestashop-Product_csv',
                'path' => $this->getParameter('download_directory'). DIRECTORY_SEPARATOR .$file->getClientOriginalName(),

            ]);

            $output = new BufferedOutput();

            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            $content = $output->fetch();
            if($result === 0)
            {
                $this->addFlash("success", $content );
            }
            else{
                $this->addFlash("danger",  "Une erreur c'est produite pendant l'importation");
            }
        }


        return $this->render('Pages/Tools/import.html.twig', [
            'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('Import', domain: 'general')]]
            ],
            'import_form'=>$form,
            'navbardata' => json_encode(['fm'=> 'Tools','sm'=>'export'])
        ]);
    }

}
