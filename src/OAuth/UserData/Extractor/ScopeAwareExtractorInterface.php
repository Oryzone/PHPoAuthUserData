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

/**
 * Interface ScopeAwareExtractorInterface
 *
 * @package OAuth\UserData\Extractor
 */
interface ScopeAwareExtractorInterface
{
    /**
     * Get a map of fields mapped to the required scopes.
     *
     * @return array
     */
    public static function getFieldScopesMap();

    /**
     * Returns all scopes needed for the specified fields.
     * @param  string|array $argument1, ..., $argumentN All the fields you need to fetch as string arguments or just
     * one array of fields.
     *
     * @return array All the scopes needed for the required fields.
     */
    public static function getScopesForFields();
}
