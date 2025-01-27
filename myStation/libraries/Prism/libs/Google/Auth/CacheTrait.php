<?php
/*
 * Copyright 2015 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Auth;

trait CacheTrait
{
  /**
   * Gets the cached value if it is present in the cache when that is
   * available.
   */
  private function getCachedValue()
  {
    if (is_null($this->cache)) {
      return null;
    }

    if (isset($this->fetcher)) {
      $fetcherKey = $this->fetcher->getCacheKey();
    } else {
      $fetcherKey = $this->getCacheKey();
    }

    if (is_null($fetcherKey)) {
      return null;
    }

    $key = $this->cacheConfig['prefix'] . $fetcherKey;
    return $this->cache->get($key, $this->cacheConfig['lifetime']);
  }

  /**
   * Saves the value in the cache when that is available.
   */
  private function setCachedValue($v)
  {
    if (is_null($this->cache)) {
      return;
    }

    if (isset($this->fetcher)) {
      $fetcherKey = $this->fetcher->getCacheKey();
    } else {
      $fetcherKey = $this->getCacheKey();
    }

    if (is_null($fetcherKey)) {
      return;
    }
    $key = $this->cacheConfig['prefix'] . $fetcherKey;
    $this->cache->set($key, $v);
  }
}

