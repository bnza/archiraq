<?php

namespace App\Command;

use App\Entity\Voc\ChronologyEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddChronologyEntryCommand extends Command
{
    protected static $defaultName = 'app:voc:add-chronology';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Adds a new entry (KASSITE) to the chronology vocabulary.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $code = 'KAS';
        $name = 'KASSITE';
        $dateLow = -1550;
        $dateHigh = -1150;

        $io->title(sprintf('Adding chronology entry: %s (%s)', $name, $code));

        try {
            // Check if it already exists
            $existing = $this->em->getRepository(ChronologyEntity::class)->findOneBy(['code' => $code]);
            if ($existing) {
                $io->error(sprintf('Chronology with code "%s" already exists.', $code));
                return 1;
            }

            $chronology = new ChronologyEntity();
            $chronology->setCode($code);
            $chronology->setName($name);
            $chronology->setDateLow($dateLow);
            $chronology->setDateHigh($dateHigh);

            $this->em->persist($chronology);
            $this->em->flush();

            $io->success(sprintf('Chronology entry "%s" added successfully.', $name));
            return 0;
        } catch (\Exception $e) {
            $io->error('Failed to add chronology entry: ' . $e->getMessage());
            return 1;
        }
    }
}
