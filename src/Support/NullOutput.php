<?php

namespace VertexPortus\LaravelArkitect\Support;

use Symfony\Component\Console\Output\OutputInterface;

class NullOutput implements OutputInterface
{

    /**
     * @inheritDoc
     */
    public function write(iterable|string $messages, bool $newline = false, int $options = 0)
    {
        // TODO: Implement write() method.
    }

    /**
     * @inheritDoc
     */
    public function writeln(iterable|string $messages, int $options = 0)
    {
        // TODO: Implement writeln() method.
    }

    /**
     * @inheritDoc
     */
    public function setVerbosity(int $level)
    {
        // TODO: Implement setVerbosity() method.
    }

    /**
     * @inheritDoc
     */
    public function getVerbosity(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function isQuiet(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isVerbose(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isVeryVerbose(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isDebug(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function setDecorated(bool $decorated)
    {
        // TODO: Implement setDecorated() method.
    }

    /**
     * @inheritDoc
     */
    public function isDecorated(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function setFormatter(\Symfony\Component\Console\Formatter\OutputFormatterInterface $formatter)
    {
        // TODO: Implement setFormatter() method.
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): \Symfony\Component\Console\Formatter\OutputFormatterInterface
    {
        return new \Symfony\Component\Console\Formatter\OutputFormatter();
    }
}
