<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Checkers\Traits\CompiledBlacklistAwareTrait;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;
use WP_CLI\Fetchers\User;
use WP_User;

class BadUserLoginOrEmail extends AbstractChecker
{
    use CompiledBlacklistAwareTrait;

    public const ID = 'bad-user-login-or-email';
    public const DESCRIPTION = 'Disallow blacklisted username and email.';
    public const DEFAULT_BLACKLIST = [
        'admin',
        'administrator',
        'webmaster',
        'root',
        'www',
    ];

    /**
     * User fetcher.
     *
     * @var User
     */
    private $fetcher;

    /**
     * {@inheritdoc}
     */
    protected static function make(): AbstractChecker
    {
        return new static(
            new User()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        $badUsers = array_filter(
            array_map(function (string $userLoginOrEmail): ?WP_User {
                $user = $this->fetcher->get($userLoginOrEmail); // phpcs:ignore WordPressVIPMinimum.Variables

                return ($user instanceof WP_User) ? $user : null;
            }, $config->compileBlacklist(self::DEFAULT_BLACKLIST))
        );

        if (! empty($badUsers)) {
            $messages = array_values(
                array_map(function (WP_User $user): string {
                    return sprintf(
                        'User: %1$s <%2$s> (ID: %3$d) is blacklisted',
                        $user->get('user_login'),
                        $user->get('user_email'),
                        $user->get('ID')
                    );
                }, $badUsers)
            );

            return ResultFactory::makeFailure($this, $messages);
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
        $error = $this->errorIfCompiledBlacklistIsEmpty($config);

        if (null !== $error) {
            return $error;
        }

        $blacklist = $config->compileBlacklist(self::DEFAULT_BLACKLIST);
        $numericBlacklist = array_filter($blacklist, 'is_numeric');

        return empty($numericBlacklist)
            ? null
            : ResultFactory::makeError($this, 'Blacklist cannot contains numeric items');
    }

    /**
     * BadUserLoginOrEmail constructor.
     *
     * @param User $fetcher User fetcher.
     */
    public function __construct(User $fetcher)
    {
        $this->fetcher = $fetcher;
    }
}
