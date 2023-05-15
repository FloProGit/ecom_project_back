<?php


/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Http\Attribute;


/**
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_FUNCTION)]
final class CanDo
{
    public function __construct(
        /**
         * Sets the first argument that will be passed to isGranted().
         */
        public ?array $roles = null,

        /**
         * The message of the exception - has a nice default if not set.
         */
        public ?string $route = null,

        /**
         * If set, will throw HttpKernel's HttpException with the given $statusCode.
         * If null, Security\Core's AccessDeniedException will be used.
         */
        public ?string $message = null,
    ) {
    }
}
