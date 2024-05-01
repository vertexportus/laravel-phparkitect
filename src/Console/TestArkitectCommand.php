<?php

namespace VertexPortus\LaravelArkitect\Console;

use Arkitect\CLI\Config;
use Arkitect\CLI\Runner;
use Arkitect\CLI\Version;
use Arkitect\Rules\Violations;
use Illuminate\Console\Command;
use Arkitect\Rules\ParsingErrors;
use Arkitect\CLI\TargetPhpVersion;
use Webmozart\Assert\Assert;
use Symfony\Component\Process\Process;
use Arkitect\CLI\PhpArkitectApplication;
use Arkitect\CLI\Progress\DebugProgress;
use Arkitect\CLI\Progress\ProgressBarProgress;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Arkitect\Exceptions\FailOnFirstViolationException;
use VertexPortus\LaravelArkitect\Support\NullOutput;

class TestArkitectCommand extends Command
{
    private const logo = <<< 'EOD'
  ____  _   _ ____   _         _    _ _            _
 |  _ \| | | |  _ \ / \   _ __| | _(_) |_ ___  ___| |_
 | |_) | |_| | |_) / _ \ | '__| |/ / | __/ _ \/ __| __|
 |  __/|  _  |  __/ ___ \| |  |   <| | ||  __/ (__| |_
 |_|   |_| |_|_| /_/   \_\_|  |_|\_\_|\__\___|\___|\__|
 _______________________________________________________
EOD;
    private const SUCCESS_CODE = 0;
    private const ERROR_CODE = 1;
    private const DEFAULT_BASELINE_FILENAME = 'phparkitect-baseline.json';

    protected string $configFile = __DIR__.'/../Support/phparkitect.php';
    protected bool $verbose = false;
    protected bool $stopOnFailure = false;
    protected bool $json = false;

    protected $signature = 'test:arkitect {--stop-on-failure : The process will end immediately after the first violation.}
                                           {--debug : The verbose mode to see every parsed file.}
                                           {--json : Output json instead of text.}';

    protected $description = 'Run the architectural tests';

    public function handle(): int
    {
        $this->verbose = boolval($this->option('debug'));
        $this->stopOnFailure = boolval($this->option('stop-on-failure'));
        $this->json = boolval($this->option('json'));

        return $this->executeArkitectCheck();
    }

    public function executeArkitectCheck(
        $output = new ConsoleOutput(),
//        $useBaseline = false,
//        $skipBaseline = false,
//        $generateBaseline = false,
//        $ignoreBaselineLinenumbers = false,
    ) : int {
        ini_set('memory_limit', '-1');
        ini_set('xdebug.max_nesting_level', '10000');
        $startTime = microtime(true);

        if ($this->json) {
            $output = new NullOutput();
        }

        $output->writeln(static::logo);
        $output->writeln(" <info>Version: " . Version::get() . "</info>" . PHP_EOL);

        try {
//            if (true !== $skipBaseline && !$useBaseline && file_exists(self::DEFAULT_BASELINE_FILENAME)) {
//                $useBaseline = self::DEFAULT_BASELINE_FILENAME;
//            }
//
//            if ($useBaseline) {
//                if (file_exists($useBaseline)) {
//                    $output->writeln('<info>Baseline found: '.$useBaseline.'</info>');
//                }
//                else {
//                    $output->writeln('<error>Baseline file not found.</error>');
//                    return self::ERROR_CODE;
//                }
//            }


            /** @var string|null $phpVersion */
            $targetPhpVersion = TargetPhpVersion::create("8.3");

            $progress = $this->verbose ? new DebugProgress($output) : new ProgressBarProgress($output);
            if ($this->verbose) {
                $output->writeln(sprintf("Config file: %s\n", $this->configFile));
            }

            $config = new Config();
            \Closure::fromCallable(function () use ($config): ?bool {
                $loadedConfig = require $this->configFile;
                Assert::isCallable($loadedConfig);
                return $loadedConfig($config);
            })();

            $runner = new Runner($this->stopOnFailure);
            try {
                $runner->run($config, $progress, $targetPhpVersion);
            } catch (FailOnFirstViolationException $e) {
            }
            $violations = $runner->getViolations();
            $violations->sort();

//            echo(json_encode($violations, JSON_PRETTY_PRINT));
//
//            if (false !== $generateBaseline) {
//                if (null === $generateBaseline) {
//                    $generateBaseline = self::DEFAULT_BASELINE_FILENAME;
//                }
//                $this->saveBaseline($generateBaseline, $violations);
//
//                $output->writeln('<info>Baseline file \''.$generateBaseline.'\'created!</info>');
//                $this->printExecutionTime($output, $startTime);
//
//                return self::SUCCESS_CODE;
//            }
//
//            if ($useBaseline) {
//                $baseline = $this->loadBaseline($useBaseline);
//
//                $violations->remove($baseline, $ignoreBaselineLinenumbers);
//            }

            if ($violations->count() > 0) {
                $this->printViolations($violations, $output);
                $this->printExecutionTime($output, $startTime);

                return self::ERROR_CODE;
            }

            $parsedErrors = $runner->getParsingErrors();
            if ($parsedErrors->count() > 0) {
                $this->printParsedErrors($parsedErrors, $output);
                $this->printExecutionTime($output, $startTime);

                return self::ERROR_CODE;
            }
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            $this->printExecutionTime($output, $startTime);

            return self::ERROR_CODE;
        }

//        $this->printNoViolationsDetectedMessage($output);
        $this->printExecutionTime($output, $startTime);

        return self::SUCCESS_CODE;
    }

    protected function printExecutionTime(OutputInterface $output, float $startTime): void
    {
        $endTime = microtime(true);
        $executionTime = number_format($endTime - $startTime, 2);

        $output->writeln(' <info>Execution time: '.$executionTime."s</info>\n");
    }

    private function printViolations(Violations $violations, OutputInterface $output): void
    {
        if ($this->json) {
            (new ConsoleOutput())->writeln(json_encode($violations, JSON_PRETTY_PRINT));
            return;
        }
        $output->writeln('<error>ERRORS!</error>');
        $output->writeln(sprintf('%s', $violations->toString()));
        $output->writeln(sprintf('<error>%s VIOLATIONS DETECTED!</error>', \count($violations)));
    }

    private function printParsedErrors(ParsingErrors $parsingErrors, OutputInterface $output): void
    {
        $output->writeln('<error>ERROR ON PARSING THESE FILES:</error>');
        $output->writeln(sprintf('%s', $parsingErrors->toString()));
    }

    private function printNoViolationsDetectedMessage(OutputInterface $output): void
    {
        $output->writeln('<info>NO VIOLATIONS DETECTED!</info>');
    }
}
