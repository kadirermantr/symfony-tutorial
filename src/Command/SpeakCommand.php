<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
	name: 'speak',
	description: 'Speak a message.',
)]
class SpeakCommand extends Command
{
	protected function configure(): void
	{
		$this->addArgument('message', InputArgument::OPTIONAL, 'What message should I speak?', 'Hello world');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

		$io->comment('started');
		$io->success('say ' . $input->getArgument('message'));
		$io->comment('finished');

        return Command::SUCCESS;
    }
}
