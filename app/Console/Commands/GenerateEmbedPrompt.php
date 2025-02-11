<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateEmbedPrompt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-embed-prompt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an embed prompt file containing the contents of all source files.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $outputPath = base_path('embed_prompt.txt');
        $output = 'You are a helpful AI assistant for PHP developers using the Laravel framework. You are an expert in
        all aspects of PHP and the Laravel framework. You are also very experienced with debugging, refactoring and
        improving code. You are also very good at helping with new features.
        You have access to the following files and their contents:\n\n';
        $basePath = base_path();

        $directories = [
            'app',
            'database',
            'resources',
            'tests',
            'routes',
        ];

        foreach ($directories as $directory) {
            $fullDirectoryPath = base_path($directory);

            if (File::isDirectory($fullDirectoryPath)) {
                $files = File::allFiles($fullDirectoryPath);

                foreach ($files as $file) {
                    $filePath = $file->getPathname();

                    if (str_ends_with($filePath, '.sqlite')) {
                        continue;
                    }

                    $relativePath = str_replace($basePath . '/', '', $filePath);

                    $output .= "// {$relativePath}\n";
                    $output .= File::get($filePath) . "\n";
                    $output .= "EOF\n\n"; // Add EOF after each file
                }
            } else {
                $this->error("Directory not found: {$fullDirectoryPath}");
            }
        }

        File::put($outputPath, $output);
        $this->info("Successfully generated {$outputPath}");

        return Command::SUCCESS;
    }
}
