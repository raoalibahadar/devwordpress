<?php
 namespace MailPoetVendor\Doctrine\ORM\Cache; if (!defined('ABSPATH')) exit; interface TimestampRegion extends \MailPoetVendor\Doctrine\ORM\Cache\Region { public function update(\MailPoetVendor\Doctrine\ORM\Cache\CacheKey $key); } 