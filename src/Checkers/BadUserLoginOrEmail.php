<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\Config;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Error;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
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
        // TODO: Check is not `is_numeric`.
        $badUsers = array_filter(
            array_map(function (string $userLoginOrEmail): ?WP_User {
                $user = $this->fetcher->get($userLoginOrEmail);

                return ($user instanceof WP_User) ? $user : null;
            }, $config->compileBlacklist(self::DEFAULT_BLACKLIST))
        );

        if (! empty($badUsers)) {
            $messages = array_map(function (WP_User $user): string {
                return sprintf(
                    'User: %1$s <%2$s> (ID: %3$d) is blacklisted',
                    $user->get('user_login'),
                    $user->get('user_email'),
                    $user->get('ID')
                );
            }, $badUsers);

            return new Failure(
                $this,
                implode(PHP_EOL, $messages)
            );
        }

        return new Success($this);
    }

    /**
     * {@inheritdoc}
     *
     * @param Config $config The config instance.
     *
     * @return Error|null
     */
    protected function maybeError(Config $config): ?Error
    {
        $error = $this->errorIfCompiledBlacklistIsEmpty($config);

        if (null !== $error) {
            return $error;
        }

        $blacklist = $config->compileBlacklist(self::DEFAULT_BLACKLIST);
        $numericBlacklist = array_filter($blacklist, 'is_numeric');

        return empty($numericBlacklist)
            ? null
            : $this->makeError('Blacklist cannot contains numeric items');
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
