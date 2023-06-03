<?php



namespace App\Controller;





use App\Services\Factory\ProductFactory;
use App\Services\Infrastructure\MediaUrlDownloadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{

    public function index(MediaUrlDownloadService $imageDownloadService) : response
    {
        $imageDownloadService->downloadImagesAndSaveMediaUrl(['https://cdnbigbuy.com/images/53208_mandatory-ring.jpg']);
        return $this->render('dashboard.html.twig',['navbardata' => json_encode(['fm'=> 'dashboard'])]);
    }


}