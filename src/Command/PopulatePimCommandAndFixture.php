<?php

namespace App\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'app:install-back',
    description: 'load csv from file',
)]
class PopulatePimCommandAndFixture extends Command
{
    private EntityManagerInterface $entityManager;
    private string $fileDirectory;

    private SymfonyStyle $io;

    private CategoryRepository $categoryRepository;

    public function __construct(

    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('initialise Bdd and populate');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executeDBCreation($output);
        $this->io->section('Start DB migration');
        $this->executeMigration($output);
        $this->io->section('Start Fixtures');
        $this->executeFixtures($output);
        $this->executeAddCategory($output);
        $this->executeAddProduct($output);
        return Command::SUCCESS;
    }

    private function executeMigration(OutputInterface $output)
    {

        $command = $this->getApplication()->find('doctrine:migrations:migrate');

        $greetInput = new ArrayInput([]);
        $returnCode = $command->run($greetInput, $output);

    }
    private function executeAddCategory(OutputInterface $output)
    {

        $command = $this->getApplication()->find('app:create-category-from-csv');

        $greetInput = new ArrayInput([]);
        $returnCode = $command->run($greetInput, $output);

    }

    private function executeAddProduct(OutputInterface $output)
    {

        $command = $this->getApplication()->find('app:create-product-from-csv');

        $greetInput = new ArrayInput([]);
        $returnCode = $command->run($greetInput, $output);

    }
    private function executeFixtures(OutputInterface $output)
    {

        $command = $this->getApplication()->find('doctrine:fixtures:load');

        $greetInput = new ArrayInput([]);
        $returnCode = $command->run($greetInput, $output);

    }
    private function executeDBCreation(OutputInterface $output)
    {

        $command = $this->getApplication()->find('doctrine:database:create');

        $greetInput = new ArrayInput([]);
        $returnCode = $command->run($greetInput, $output);

    }
}
