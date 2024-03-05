<?php

namespace App\Command;

use App\Entity\RequestEntity;
use App\Service\CryptoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'CryptoCommand',
    description: 'Send data to Crypto for evaluation',
)]
class CryptoCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, private CryptoService $cryptoService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('asset', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('address', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('date_from', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('date_to', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('threshold', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $asset = $input->getArgument('asset');
        $address = $input->getArgument('address');
        $date_from = $input->getArgument('date_from');
        $date_to = $input->getArgument('date_to');
        $threshold = $input->getArgument('threshold');

        // make it for everybody if it is needed
        if ($asset) {
            $io->note(sprintf('You passed an argument: %s', $asset));
        }

        try {
            $requestEntity = new RequestEntity();
            $requestEntity->setAsset($asset);
            $requestEntity->setAddress($address);
            $requestEntity->setDateFrom($date_from);
            $requestEntity->setDateTo($date_to);
            $requestEntity->setThreshold($threshold);
            $this->entityManager->flush();

            $this->cryptoService->callCrypto($requestEntity);
        } catch (\Exception $exception) {
            // do something here about it ...

            error_log($exception->getMessage(), $exception->getCode());
        }

        $io->success('here some data will be thrown...');

        return Command::SUCCESS;
    }
}
