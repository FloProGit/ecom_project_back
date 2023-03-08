<?php



namespace App\Controller;





use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class ProductsController extends AbstractController
{

    public function index() : response
    {
        $filesystem = new Filesystem();
        $contenu = '';
        try {
            $dirFullPath = __DIR__;

            //PRE: $dirs = /app/public/src/Helpers
            $dirs = explode('\\',$dirFullPath);

            array_pop($dirs); //remove last element in array ('Helpers')
            array_pop($dirs); //remove the next last element from array ('src')

            //POST: $dirs = /app/public
            $RootPath = implode('\\',$dirs);

            $searchPath= $RootPath.'/public/FileTest/files-categories-csv-prestashop-category-2570-fr.csv';
            $result =  $filesystem->exists($searchPath);
            $resultdata = file_get_contents($searchPath);

            $person = $serializer->deserialize($resultdata, Product::class, 'csv');
            var_dump($resultdata);
            die();
        }
        catch(Exception $e)
        {

        }
        return $this->render('Pages/Product/products.html.twig');
    }


}