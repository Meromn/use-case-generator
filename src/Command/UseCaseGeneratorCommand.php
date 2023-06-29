<?php

namespace Meromn\UseCaseGenerator\Command;

use Meromn\UseCaseGenerator\Contracts\Service\UseCaseGeneratorServiceInterface;
use Meromn\UseCaseGenerator\Service\UseCaseGeneratorService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: self::COMMAND_NAME,
    description: 'UseCase Files generator',
    hidden: false
)]
class UseCaseGeneratorCommand extends Command
{
    public const COMMAND_NAME = 'meromn:maker:use-case';
    public const COMMAND_ARGUMENT_USE_CASE = 'use_case';
    public const COMMAND_OPTION_IS_WITH_TEST = 'test';
    public const COMMAND_OPTION_IS_WITH_TEST_SHORTCUT = 't';

    public function __construct(
        private readonly UseCaseGeneratorServiceInterface $useCaseGeneratorService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::COMMAND_ARGUMENT_USE_CASE,
            InputArgument::OPTIONAL,
            'The name of the use case'
        )
            ->addOption(
                self::COMMAND_OPTION_IS_WITH_TEST,
                self::COMMAND_OPTION_IS_WITH_TEST_SHORTCUT,
                InputOption::VALUE_NONE,
                'Generate with test'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $useCaseName = $input->getArgument(self::COMMAND_ARGUMENT_USE_CASE);
        $isWithTest = (bool)$input->getOption(self::COMMAND_OPTION_IS_WITH_TEST);
        $io = new SymfonyStyle($input, $output);
        if (
            !UseCaseGeneratorService::checkUseCaseNameIsNotNull($useCaseName) ||
            !UseCaseGeneratorService::checkValidUserProvideName($useCaseName)
        ) {
            if ($useCaseName !== null && !UseCaseGeneratorService::checkValidUserProvideName($useCaseName))
            {
                $io->error('The name of the use case must have \'UseCase\' suffix');
            }
            $useCaseName = $io->ask(
                'Name of the use case to create (e.g. <fg=yellow>ActionUseCase</>)',
                null,
                function (?string $answer): string {
                    return UseCaseGeneratorService::checkUseCaseNameIntegrity($answer);
                });
        }
        $files = $this->useCaseGeneratorService->generateFolderAndFiles($useCaseName);
        $outputStyle = new OutputFormatterStyle('#2f49de');
        $output->getFormatter()->setStyle('creation', $outputStyle);
        $io->newLine();
        foreach ($files as $file) {
            $io->writeln('  <creation>created</> ' . $file);
        }
        $testFiles = null;
        if ($isWithTest === false) {
            $isWithTest = $io->confirm('Do you want to create tests for this useCase ?');
        }
        if ($isWithTest) {
            $testFiles = $this->useCaseGeneratorService->generateTestsFiles($useCaseName);
        }
        if ($testFiles !== null) {
            foreach ($testFiles as $testFile) {
                $io->writeln('  <creation>created</> ' . $testFile);
            }
        }
        $io->newLine();
        $io->writeln(' <bg=green;fg=white>          </>');
        $io->writeln(' <bg=green;fg=white> Success! </>');
        $io->writeln(' <bg=green;fg=white>          </>');
        $io->newLine();

        return Command::SUCCESS;
    }
}

