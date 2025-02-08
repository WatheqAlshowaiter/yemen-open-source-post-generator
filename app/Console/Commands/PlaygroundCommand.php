<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class PlaygroundCommand extends Command
{
    protected $signature = 'play';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input = 'Split the input into exactly three lines, each as close to three chars fewer than the last.';
        dd(
            $this->taylorCommentStyle($input),
            $this->testTaylorCommentStyle(),
        );
    }

    /**
     * Convert a string into Laravel style code comment lines.
     */
    public function taylorCommentStyle(string $value): string
    {
        $totalLength = strlen($value);
        $targetLengths = [ceil($totalLength / 3) + 4, ceil($totalLength / 3), ceil($totalLength / 3) - 4];

        [$_, $lines] = Str::of($value)->trim()->split('/\s+/')
            ->reduceSpread(function ($lineNumber, $lines, $word) use ($targetLengths) {
                if ($lineNumber < 2 && strlen(trim("{$lines[$lineNumber]} {$word}")) >= $targetLengths[$lineNumber]) {
                    $lineNumber++;
                }

                $lines[$lineNumber] = trim("{$lines[$lineNumber]} {$word}");

                return [$lineNumber, $lines];
            }, 0, ['', '', '']);

        return implode("\n", $lines);
    }


    /**
     * Split the input into exactly three
     * lines, each as close to three
     * chars fewer than the last.
     */
    public function testTaylorCommentStyle(): int
    {
        $input = 'Split the input into exactly three lines, each as close to three chars fewer than the last.';
        $expected = "Split the input into exactly three\nlines, each as close to three\nchars fewer than the last.";

        return strcmp($expected, $this->taylorCommentStyle($input));
    }
}
