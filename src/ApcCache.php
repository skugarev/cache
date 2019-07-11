<?php
namespace Yiisoft\Cache;

/**
 * ApcCache provides APCu caching in terms of an application component.
 *
 * To use this application component, the [APCu PHP extension](http://www.php.net/apcu) must be loaded.
 * In order to enable APCu for CLI you should add "apc.enable_cli = 1" to your php.ini.
 *
 * Application configuration example:
 *
 * ```php
 * return [
 *     'components' => [
 *         'cache' => [
 *             '__class' => Yiisoft\Cache\Cache::class,
 *             'handler' => [
 *                 '__class' => Yiisoft\Cache\ApcCache::class,
 *             ],
 *         ],
 *         // ...
 *     ],
 *     // ...
 * ];
 * ```
 *
 * See [[\Psr\SimpleCache\CacheInterface]] for common cache operations that ApcCache supports.
 *
 * For more details and usage information on Cache, see the [guide article on caching](guide:caching-overview).
 */
class ApcCache extends SimpleCache
{

    public function hasValue($key): bool
    {
        return \apcu_exists($key);
    }

    protected function getValue($key)
    {
        return \apcu_fetch($key);
    }

    protected function getValues($keys): array
    {
        $values = \apcu_fetch($keys);
        return \is_array($values) ? $values : [];
    }

    protected function setValue($key, $value, $ttl): bool
    {
        return \apcu_store($key, $value, $ttl);
    }

    protected function setValues($values, $ttl): bool
    {
        $result = \apcu_store($values, null, $ttl);
        return \is_array($result);
    }

    protected function deleteValue($key): bool
    {
        return \apcu_delete($key);
    }

    public function clear(): bool
    {
        return \apcu_clear_cache();
    }
}
