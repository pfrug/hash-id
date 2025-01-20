<?php

namespace Pfrug\HashId\Console\Commands;

use Illuminate\Console\Command;
use Jenssegers\Optimus\Energon;

class RegenerateIdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hashid:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate the prime, inverse, and random values for hash IDs';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        list($prime, $inverse, $rand) = Energon::generate();

        $configPath = config_path('hashid.php');

        if (!file_exists($configPath)) {
            $this->error('Configuration file not found: ' . $configPath);
            return;
        }

        $configContent = file_get_contents($configPath);

        $updatedContent = preg_replace(
            [
                "/'prime' => \d+/",
                "/'inverse' => \d+/",
                "/'random' => \d+/"
            ],
            [
                "'prime' => $prime",
                "'inverse' => $inverse",
                "'random' => $rand"
            ],
            $configContent
        );

        dump($configPath, $updatedContent);
        file_put_contents($configPath, $updatedContent);

        $this->info('Hash ID configuration values regenerated successfully.');
    }
}
