<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\UserData\Extractor;

use OAuth\UserData\Utils\ArrayUtils;

/**
 * Class ScopeAwareExtractor.
 */
abstract class ScopeAwareExtractor extends Extractor implements ScopeAwareExtractorInterface
{
    public static function getScopesForFields()
    {
        $fields = func_get_args();
        if (is_array($fields[0])) {
            $fields = $fields[0];
        }
        return ArrayUtils::extractMappedValues(static::getFieldScopesMap(), $fields);
    }
}
