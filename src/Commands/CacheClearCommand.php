<?php

namespace Weglot\Translate\Commands;

use Illuminate\Console\Command;
use Weglot\Translate\Facades\Cache;

class CacheClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'weglot:cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleaning weglot translation cache';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $itemCachePool = Cache::getItemCachePool();
        return $itemCachePool->clear();
    }
}
