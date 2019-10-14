<?php

namespace Larapp\Options;

use Illuminate\Support\Facades\Cache;
use Larapp\Options\Model\Option as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Options
{
     /**
     * Default cache key
     * @var string
     */
    const CACHE = 'keniley-options';

     /**
     * Cache driver
     * @var string
     */
    const DRIVER = 'file';

    /**
     * Config namespace
     * @var string
     */
    const CONFIG = 'options';

    /**
     * Cache key
     * @var string
     */
    private $cache;

    /**
     * New instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->cache = config('options-package.cache-name', self::CACHE);
    }

    /**
     * Get all options from cache or database
     *
     * @return array
     */
    public function all(): array
    {
        $data = Cache::store(self::DRIVER)->rememberForever($this->cache, function () {
            return Model::all()->toArray();
        });

        return $data;
    }

    /**
     * Restore cache
     *
     * @return \Larapp\Options\Options
     */
    public function restore(): Options
    {
        Cache::store(self::DRIVER)->forget($this->cache);

        return $this->setToConfig();
    }

    /**
     * Set options to laravel config
     *
     * @return \Larapp\Options\Options
     */
    public function setToConfig(): Options
    {
        // if database loading is disabled
        if(config('options-package.enabled', true) !== true) {
            return $this;
        }

        // if database loading is disabled in developer mode and we are now in developer mode
        if(config('options-package.only-in-production', false) !== false && config('app.env') !== 'production') {
            return $this;
        }

        $data[self::CONFIG] = [];

        foreach($this->all() as $item) {
            $key = $item['name'];
            $value = $this->cast($item);

            if(Str::contains($key, '.')) {
                Arr::set($data[self::CONFIG], $key, $value);  
                continue;  
            }

            $data[self::CONFIG][$key] = $value;
        }

        config()->set($data);

        return $this;
    }

    /**
     * Set value to specified type
     *
     * @param array $item
     *
     * @return mixed
     */
    private function cast(array $item)
    {
        $config = 'options-package.types.'.$item['type'];

        $function = config($config);

        if(is_callable($function)) {
            return $function($item);
        }

        return (string) $item['value'];
    }
}