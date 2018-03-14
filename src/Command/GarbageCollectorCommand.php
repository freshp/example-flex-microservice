<?php
declare(strict_types=1);

namespace App\Command;

use App\Repository\TestUserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GarbageCollectorCommand extends Command
{
    private $testUserRepository;

    public function __construct(TestUserRepository $testUserRepository)
    {
        parent::__construct();

        $this->testUserRepository = $testUserRepository;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:garbage-collector')
            ->setDescription('run through all entities and hard delete old entries by date option')
            ->addOption(
                'hardDeleteTimeParser',
                'hdt',
                InputArgument::OPTIONAL,
                'A timeformat the php parser understand. Take a look at: http://php.net/manual/de/datetime.formats.php',
                '-2 months'
            );
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln(sprintf('Start collecting at %s', date('Y-m-d H:i:s')));

        try {
            $hardDeleteTime = new \DateTime($input->getOption('hardDeleteTimeParser'));
        } catch (\Throwable $throwable) {
            $output->writeln('could not convert given parameter "hardDeleteTimeParser" to date');

            return;
        }

        $entries = $this->testUserRepository->findOldSoftdeletedEntries($hardDeleteTime);

        foreach ($entries as $entry) {
            $this->testUserRepository->hardDelete($entry);
        }

        $output->writeln(
            sprintf(
                'Finish hard delete of softdeleted user older then %s. found %d entries and finished at %s',
                $hardDeleteTime->format('Y-m-d H:i:s'),
                count($entries),
                date('Y-m-d H:i:s')
            )
        );
    }
}
