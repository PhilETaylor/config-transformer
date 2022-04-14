<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202204146\Symfony\Component\Console\Style;

use ConfigTransformer202204146\Symfony\Component\Console\Exception\InvalidArgumentException;
use ConfigTransformer202204146\Symfony\Component\Console\Exception\RuntimeException;
use ConfigTransformer202204146\Symfony\Component\Console\Formatter\OutputFormatter;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\ProgressBar;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\Table;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\TableCell;
use ConfigTransformer202204146\Symfony\Component\Console\Helper\TableSeparator;
use ConfigTransformer202204146\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202204146\Symfony\Component\Console\Output\ConsoleOutputInterface;
use ConfigTransformer202204146\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202204146\Symfony\Component\Console\Output\TrimmedBufferOutput;
use ConfigTransformer202204146\Symfony\Component\Console\Question\ChoiceQuestion;
use ConfigTransformer202204146\Symfony\Component\Console\Question\ConfirmationQuestion;
use ConfigTransformer202204146\Symfony\Component\Console\Question\Question;
use ConfigTransformer202204146\Symfony\Component\Console\Terminal;
/**
 * Output decorator helpers for the Symfony Style Guide.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class SymfonyStyle extends \ConfigTransformer202204146\Symfony\Component\Console\Style\OutputStyle
{
    public const MAX_LINE_LENGTH = 120;
    private $input;
    private $output;
    private $questionHelper;
    private $progressBar;
    /**
     * @var int
     */
    private $lineLength;
    private $bufferedOutput;
    public function __construct(\ConfigTransformer202204146\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer202204146\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->input = $input;
        $this->bufferedOutput = new \ConfigTransformer202204146\Symfony\Component\Console\Output\TrimmedBufferOutput(\DIRECTORY_SEPARATOR === '\\' ? 4 : 2, $output->getVerbosity(), \false, clone $output->getFormatter());
        // Windows cmd wraps lines as soon as the terminal width is reached, whether there are following chars or not.
        $width = (new \ConfigTransformer202204146\Symfony\Component\Console\Terminal())->getWidth() ?: self::MAX_LINE_LENGTH;
        $this->lineLength = \min($width - (int) (\DIRECTORY_SEPARATOR === '\\'), self::MAX_LINE_LENGTH);
        parent::__construct($this->output = $output);
    }
    /**
     * Formats a message as a block of text.
     * @param mixed[]|string $messages
     */
    public function block($messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = \false, bool $escape = \true)
    {
        $messages = \is_array($messages) ? \array_values($messages) : [$messages];
        $this->autoPrependBlock();
        $this->writeln($this->createBlock($messages, $type, $style, $prefix, $padding, $escape));
        $this->newLine();
    }
    /**
     * {@inheritdoc}
     */
    public function title(string $message)
    {
        $this->autoPrependBlock();
        $this->writeln([\sprintf('<comment>%s</>', \ConfigTransformer202204146\Symfony\Component\Console\Formatter\OutputFormatter::escapeTrailingBackslash($message)), \sprintf('<comment>%s</>', \str_repeat('=', \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width(\ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::removeDecoration($this->getFormatter(), $message))))]);
        $this->newLine();
    }
    /**
     * {@inheritdoc}
     */
    public function section(string $message)
    {
        $this->autoPrependBlock();
        $this->writeln([\sprintf('<comment>%s</>', \ConfigTransformer202204146\Symfony\Component\Console\Formatter\OutputFormatter::escapeTrailingBackslash($message)), \sprintf('<comment>%s</>', \str_repeat('-', \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width(\ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::removeDecoration($this->getFormatter(), $message))))]);
        $this->newLine();
    }
    /**
     * {@inheritdoc}
     */
    public function listing(array $elements)
    {
        $this->autoPrependText();
        $elements = \array_map(function ($element) {
            return \sprintf(' * %s', $element);
        }, $elements);
        $this->writeln($elements);
        $this->newLine();
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function text($message)
    {
        $this->autoPrependText();
        $messages = \is_array($message) ? \array_values($message) : [$message];
        foreach ($messages as $message) {
            $this->writeln(\sprintf(' %s', $message));
        }
    }
    /**
     * Formats a command comment.
     * @param mixed[]|string $message
     */
    public function comment($message)
    {
        $this->block($message, null, null, '<fg=default;bg=default> // </>', \false, \false);
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function success($message)
    {
        $this->block($message, 'OK', 'fg=black;bg=green', ' ', \true);
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function error($message)
    {
        $this->block($message, 'ERROR', 'fg=white;bg=red', ' ', \true);
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function warning($message)
    {
        $this->block($message, 'WARNING', 'fg=black;bg=yellow', ' ', \true);
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function note($message)
    {
        $this->block($message, 'NOTE', 'fg=yellow', ' ! ');
    }
    /**
     * Formats an info message.
     * @param mixed[]|string $message
     */
    public function info($message)
    {
        $this->block($message, 'INFO', 'fg=green', ' ', \true);
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $message
     */
    public function caution($message)
    {
        $this->block($message, 'CAUTION', 'fg=white;bg=red', ' ! ', \true);
    }
    /**
     * {@inheritdoc}
     */
    public function table(array $headers, array $rows)
    {
        $this->createTable()->setHeaders($headers)->setRows($rows)->render();
        $this->newLine();
    }
    /**
     * Formats a horizontal table.
     */
    public function horizontalTable(array $headers, array $rows)
    {
        $this->createTable()->setHorizontal(\true)->setHeaders($headers)->setRows($rows)->render();
        $this->newLine();
    }
    /**
     * Formats a list of key/value horizontally.
     *
     * Each row can be one of:
     * * 'A title'
     * * ['key' => 'value']
     * * new TableSeparator()
     * @param mixed[]|string|\Symfony\Component\Console\Helper\TableSeparator ...$list
     */
    public function definitionList(...$list)
    {
        $headers = [];
        $row = [];
        foreach ($list as $value) {
            if ($value instanceof \ConfigTransformer202204146\Symfony\Component\Console\Helper\TableSeparator) {
                $headers[] = $value;
                $row[] = $value;
                continue;
            }
            if (\is_string($value)) {
                $headers[] = new \ConfigTransformer202204146\Symfony\Component\Console\Helper\TableCell($value, ['colspan' => 2]);
                $row[] = null;
                continue;
            }
            if (!\is_array($value)) {
                throw new \ConfigTransformer202204146\Symfony\Component\Console\Exception\InvalidArgumentException('Value should be an array, string, or an instance of TableSeparator.');
            }
            $headers[] = \key($value);
            $row[] = \current($value);
        }
        $this->horizontalTable($headers, [$row]);
    }
    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function ask(string $question, string $default = null, callable $validator = null)
    {
        $question = new \ConfigTransformer202204146\Symfony\Component\Console\Question\Question($question, $default);
        $question->setValidator($validator);
        return $this->askQuestion($question);
    }
    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function askHidden(string $question, callable $validator = null)
    {
        $question = new \ConfigTransformer202204146\Symfony\Component\Console\Question\Question($question);
        $question->setHidden(\true);
        $question->setValidator($validator);
        return $this->askQuestion($question);
    }
    /**
     * {@inheritdoc}
     */
    public function confirm(string $question, bool $default = \true) : bool
    {
        return $this->askQuestion(new \ConfigTransformer202204146\Symfony\Component\Console\Question\ConfirmationQuestion($question, $default));
    }
    /**
     * {@inheritdoc}
     * @param mixed $default
     * @return mixed
     */
    public function choice(string $question, array $choices, $default = null)
    {
        if (null !== $default) {
            $values = \array_flip($choices);
            $default = $values[$default] ?? $default;
        }
        return $this->askQuestion(new \ConfigTransformer202204146\Symfony\Component\Console\Question\ChoiceQuestion($question, $choices, $default));
    }
    /**
     * {@inheritdoc}
     */
    public function progressStart(int $max = 0)
    {
        $this->progressBar = $this->createProgressBar($max);
        $this->progressBar->start();
    }
    /**
     * {@inheritdoc}
     */
    public function progressAdvance(int $step = 1)
    {
        $this->getProgressBar()->advance($step);
    }
    /**
     * {@inheritdoc}
     */
    public function progressFinish()
    {
        $this->getProgressBar()->finish();
        $this->newLine(2);
        unset($this->progressBar);
    }
    /**
     * {@inheritdoc}
     */
    public function createProgressBar(int $max = 0) : \ConfigTransformer202204146\Symfony\Component\Console\Helper\ProgressBar
    {
        $progressBar = parent::createProgressBar($max);
        if ('\\' !== \DIRECTORY_SEPARATOR || 'Hyper' === \getenv('TERM_PROGRAM')) {
            $progressBar->setEmptyBarCharacter('░');
            // light shade character \u2591
            $progressBar->setProgressCharacter('');
            $progressBar->setBarCharacter('▓');
            // dark shade character \u2593
        }
        return $progressBar;
    }
    /**
     * @see ProgressBar::iterate()
     */
    public function progressIterate(iterable $iterable, int $max = null) : iterable
    {
        yield from $this->createProgressBar()->iterate($iterable, $max);
        $this->newLine(2);
    }
    /**
     * @return mixed
     */
    public function askQuestion(\ConfigTransformer202204146\Symfony\Component\Console\Question\Question $question)
    {
        if ($this->input->isInteractive()) {
            $this->autoPrependBlock();
        }
        $this->questionHelper = $this->questionHelper ?? new \ConfigTransformer202204146\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $answer = $this->questionHelper->ask($this->input, $this, $question);
        if ($this->input->isInteractive()) {
            $this->newLine();
            $this->bufferedOutput->write("\n");
        }
        return $answer;
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $messages
     */
    public function writeln($messages, int $type = self::OUTPUT_NORMAL)
    {
        if (!\is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            parent::writeln($message, $type);
            $this->writeBuffer($message, \true, $type);
        }
    }
    /**
     * {@inheritdoc}
     * @param mixed[]|string $messages
     */
    public function write($messages, bool $newline = \false, int $type = self::OUTPUT_NORMAL)
    {
        if (!\is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            parent::write($message, $newline, $type);
            $this->writeBuffer($message, $newline, $type);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function newLine(int $count = 1)
    {
        parent::newLine($count);
        $this->bufferedOutput->write(\str_repeat("\n", $count));
    }
    /**
     * Returns a new instance which makes use of stderr if available.
     */
    public function getErrorStyle() : self
    {
        return new self($this->input, $this->getErrorOutput());
    }
    public function createTable() : \ConfigTransformer202204146\Symfony\Component\Console\Helper\Table
    {
        $output = $this->output instanceof \ConfigTransformer202204146\Symfony\Component\Console\Output\ConsoleOutputInterface ? $this->output->section() : $this->output;
        $style = clone \ConfigTransformer202204146\Symfony\Component\Console\Helper\Table::getStyleDefinition('symfony-style-guide');
        $style->setCellHeaderFormat('<info>%s</info>');
        return (new \ConfigTransformer202204146\Symfony\Component\Console\Helper\Table($output))->setStyle($style);
    }
    private function getProgressBar() : \ConfigTransformer202204146\Symfony\Component\Console\Helper\ProgressBar
    {
        if (!isset($this->progressBar)) {
            throw new \ConfigTransformer202204146\Symfony\Component\Console\Exception\RuntimeException('The ProgressBar is not started.');
        }
        return $this->progressBar;
    }
    private function autoPrependBlock() : void
    {
        $chars = \substr(\str_replace(\PHP_EOL, "\n", $this->bufferedOutput->fetch()), -2);
        if (!isset($chars[0])) {
            $this->newLine();
            //empty history, so we should start with a new line.
            return;
        }
        //Prepend new line for each non LF chars (This means no blank line was output before)
        $this->newLine(2 - \substr_count($chars, "\n"));
    }
    private function autoPrependText() : void
    {
        $fetched = $this->bufferedOutput->fetch();
        //Prepend new line if last char isn't EOL:
        if (\substr_compare($fetched, "\n", -\strlen("\n")) !== 0) {
            $this->newLine();
        }
    }
    private function writeBuffer(string $message, bool $newLine, int $type) : void
    {
        // We need to know if the last chars are PHP_EOL
        $this->bufferedOutput->write($message, $newLine, $type);
    }
    private function createBlock(iterable $messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = \false, bool $escape = \false) : array
    {
        $indentLength = 0;
        $prefixLength = \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width(\ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::removeDecoration($this->getFormatter(), $prefix));
        $lines = [];
        if (null !== $type) {
            $type = \sprintf('[%s] ', $type);
            $indentLength = \strlen($type);
            $lineIndentation = \str_repeat(' ', $indentLength);
        }
        // wrap and add newlines for each element
        foreach ($messages as $key => $message) {
            if ($escape) {
                $message = \ConfigTransformer202204146\Symfony\Component\Console\Formatter\OutputFormatter::escape($message);
            }
            $decorationLength = \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width($message) - \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width(\ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::removeDecoration($this->getFormatter(), $message));
            $messageLineLength = \min($this->lineLength - $prefixLength - $indentLength + $decorationLength, $this->lineLength);
            $messageLines = \explode(\PHP_EOL, \wordwrap($message, $messageLineLength, \PHP_EOL, \true));
            foreach ($messageLines as $messageLine) {
                $lines[] = $messageLine;
            }
            if (\count($messages) > 1 && $key < \count($messages) - 1) {
                $lines[] = '';
            }
        }
        $firstLineIndex = 0;
        if ($padding && $this->isDecorated()) {
            $firstLineIndex = 1;
            \array_unshift($lines, '');
            $lines[] = '';
        }
        foreach ($lines as $i => &$line) {
            if (null !== $type) {
                $line = $firstLineIndex === $i ? $type . $line : $lineIndentation . $line;
            }
            $line = $prefix . $line;
            $line .= \str_repeat(' ', \max($this->lineLength - \ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::width(\ConfigTransformer202204146\Symfony\Component\Console\Helper\Helper::removeDecoration($this->getFormatter(), $line)), 0));
            if ($style) {
                $line = \sprintf('<%s>%s</>', $style, $line);
            }
        }
        return $lines;
    }
}
