<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\ConditionProduct;
use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'app:create-product-from-csv',
    description: 'load csv from file',
)]
class CreateProductFromCsvCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private string $fileDirectory;

    private SymfonyStyle $io;

    private ProductRepository $productRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        string                 $fileDirectory,
        ProductRepository      $productRepository
    )
    {
        parent::__construct();
        $this->fileDirectory = $fileDirectory;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    protected function configure(): void
    {

        $this->setDescription('load csv from file');
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
//        parent::initialize($input, $output); // TODO: Change the autogenerated stub
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->createProduct();

        return Command::SUCCESS;
    }

    private function getDataFromFile(): array
    {
        $file = $this->fileDirectory . 'files-products-csv-standard-product-2570-fr.csv';

        $fileExtention = pathinfo($file, PATHINFO_EXTENSION);

        $normalizers = [new ObjectNormalizer()];

        $encoders = [
            new CsvEncoder()
        ];

        $serializer = new Serializer($normalizers, $encoders);

        /** @var  string $fileString */
        $fileString = file_get_contents($file);

        $data = $serializer->decode($fileString, $fileExtention, [CsvEncoder::DELIMITER_KEY => ';']);

        return $data;
    }

    private function createProduct()
    {
        $this->io->section('Creation des Product a partir du fichier');

        $productCreated = 0;

        foreach ($this->getDataFromFile() as $row) {


            if (array_key_exists('ID', $row)) {

                $product = $this->productRepository->findOneBy([
                    'ext_id' => $row['ID']
                ]);
                if (!$product) {
                    try {
                        $product = new Product();
                        $product->setExtId($row['ID']);

                        $arrayCategory = $this->entityManager->getRepository(Category::class)->getCategoriesByCodes($row['CATEGORY']);

                        $product->addMultipleCategory($arrayCategory);


                        $product->setName($row['NAME']);
                        $product->setAttribute1($row['ATTRIBUTE1']);
                        $product->setAttribute2($row['ATTRIBUTE2']);
                        $product->setValue1($row['VALUE1']);
                        $product->setValue2($row['VALUE2']);
                        $product->setDescription($row['DESCRIPTION']);
                        $product->setBrand(intval($row['BRAND']));
                        $product->setFeature($row['FEATURE']);
                        $product->setPrice(floatval($row['PRICE']));
                        $product->setPvp(floatval($row['PVP_BIGBUY']));
                        $product->setPvd(floatval($row['PVD']));
                        $product->setIva(intval($row['IVA']));
                        $product->setVideo(intval($row['VIDEO']));
                        $product->setEan13(999999999);
                        $product->setWidth(floatval($row['WIDTH']));
                        $product->setHeight(floatval($row['HEIGHT']));
                        $product->setDepth(floatval($row['DEPTH']));
                        $product->setWeight(floatval($row['WEIGHT']));

                        $product->setStock(intval($row['STOCK']));
                        $product->setCreatedAt(DateTimeImmutable::createFromFormat("d/m/Y H:i", $row['DATE_ADD']));
                        $product->setImage1($row['IMAGE1']);
                        $product->setImage2($row['IMAGE2']);
                        $product->setImage3($row['IMAGE3']);
                        $product->setImage4($row['IMAGE4']);
                        $product->setImage5($row['IMAGE5']);
                        $product->setImage6($row['IMAGE6']);
                        $product->setImage7($row['IMAGE7']);
                        $product->setImage8($row['IMAGE8']);
                        $product->setIntrastat(intval($row['INTRASTAT']));
                        $Condition = $this->entityManager->getRepository(ConditionProduct::class)->findOneBy(['current_condition' => $row['CONDITION']]);
                        $product->setConditionProductId($Condition);
                        $this->entityManager->persist($product);

                        $productCreated++;
                    } catch (\Exception $e) {
                        $this->io->section($e);
                    }
                }
            }
            else
            {
                $product = $this->productRepository->findOneBy([
                    'ext_id' => $row['ID']
                ]);

                $arrayCategory = $this->entityManager->getRepository(Category::class)->getCategoriesByCodes($row['CATEGORY']);

                $product->addMultipleCategory($arrayCategory);


                $Condition = $this->entityManager->getRepository(ConditionProduct::class)->findOneBy(['current_condition' => $row['CONDITION']]);
                $product->setConditionProductId($Condition);

                $this->entityManager->persist($product);
            }
        }
        try {
            $this->entityManager->flush();

        } catch (\Exception $e) {
            $this->io->section($e);
        }
//        $this->getDataFromFile();
        if ($productCreated != 0) {
            $string = "{$productCreated} Product Créé en Base de Donnée";
        } else {
            $string = "Aucun  Product créé en Base de Donnée";
        }
        $this->io->success($string);
    }
}
