<?php

use Illuminate\Support\Facades\Cache;

function prepareElementID($inputSettings, $index = -1, $isStruct = false)
{
    return $isStruct ? $inputSettings->id : str_replace('@index', $index, $inputSettings->id);
}

function oldData($type, $id)
{
    $datas = session('oldDataCommitted');

    if ($datas && isset(session('oldDataCommitted')->get($type)->get($id)->Data)) {
        $datas = json_decode(json_encode(session('oldDataCommitted')->get($type)->get($id)->Data));

    } else {
        $datas = [];
    }

    return $datas;
}

function hasOldData()
{
    return session('oldDataCommitted');
}

function hasOldDataWithKey($key)
{
    $data = session('oldDataCommitted')?->get('inputs')?->get($key);
    if (session('oldDataCommitted') && json_decode($data) == null){
        return session('oldDataCommitted') ? ($data) : null;
    }else{
        return session('oldDataCommitted') ? ( !is_numeric($data) ?  json_decode($data) :  $data ) : null;
    }
}

function inputSetValue($key, $defaultValue)
{
    return hasOldDataWithKey($key) ?? $defaultValue;
}

function tableStringSetValue($inputSettings, $oldData)
{
    if ($inputSettings->type == 'money') {
        return str_contains($oldData->{$inputSettings->key}, ',') ? $oldData->{$inputSettings->key} : number_format($oldData->{$inputSettings->key});
    }
    return $oldData->{$inputSettings->key};
}

function getCacheKeys()
{
    return Cache::get('cache-keys');
}

function setCacheKey($key): void
{
    $allKeys = getCacheKeys();
    $allKeys[] = $key;
    Cache::forget('cache-keys');
    Cache::forever('cache-keys', array_unique($allKeys));
}

function searchCacheByKey($key)
{
    $allKeys = getCacheKeys();
    if ($allKeys) {
        return array_filter($allKeys, fn($k) => str_starts_with($k, $key));
    }
    return [];
}

function removeFromCacheByKeys($keys): void
{
    $allKeys = getCacheKeys();
    if ($allKeys) {
        $allKeys = array_filter($allKeys, fn($k) => !in_array($k, $keys));
        Cache::forever('cache-keys', array_unique($allKeys));
    }
}


function flushCacheWithPattern($pattern): bool
{
    try {
        $keysToRemove = searchCacheByKey($pattern);
        foreach ($keysToRemove as $key) {
            Cache::forget($key);
        }
        removeFromCacheByKeys($keysToRemove);
        return true;
    } catch (Exception $ex) {
        return false;
    }
}
