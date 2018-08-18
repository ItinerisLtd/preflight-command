<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledBlacklistAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;
use WP_User;

class BlacklistedUsernames extends AbstractChecker
{
    use CompiledBlacklistAwareTrait;

    public const ID = 'blacklisted-usernames';
    public const DESCRIPTION = 'Disallow blacklisted usernames.';
    public const DEFAULT_BLACKLIST = [
        'admin',
        'administrator',
        'example',
        'root',
        'webmaster',
        'www',
    ];
    public const FAILURE_MESSAGE = 'Blacklisted usernames found:';

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $blacklistedUsers = array_filter(
            array_map(function (string $blacklistedUsername): ?WP_User {
                $user = get_user_by('login', $blacklistedUsername);

                return $user ?: null;
            }, $config->compileBlacklist(self::DEFAULT_BLACKLIST))
        );

        if (! empty($blacklistedUsers)) {
            $messages = array_map(function (WP_User $user): string {
                return sprintf(
                    'ID: %1$d %2$s <%3$s>',
                    $user->get('ID'),
                    $user->get('user_login'),
                    $user->get('user_email')
                );
            }, $blacklistedUsers);

            return ResultFactory::makeFailure(
                $this,
                array_merge([self::FAILURE_MESSAGE], $messages)
            );
        }

        return ResultFactory::makeSuccess($this);
    }

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeInvalidConfig(Config $config): ?Error
    {
        return $this->errorIfCompiledBlacklistIsEmpty($config, static::DEFAULT_BLACKLIST);
    }
}
