<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use WP_CLI\Fetchers\User;
use WP_User;

class BadUserLoginOrEmail extends AbstractChecker
{
    public const ID = 'bad-user-login-or-email';
    public const DESCRIPTION = 'Disallow blacklisted username and email';

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
     * Run the check and return a result.
     * TODO: Accept config object/array.
     *
     * @var WP_User[] $badUsers Array of bad Users.
     *
     * @return ResultInterface
     */
    public function check(): ResultInterface
    {
        // TODO: Check is not `is_numeric`.
        $blacklist = [
            'admin',
            'administrator',
            'webmaster',
            'root',
            'www',
        ];

        $badUsers = array_filter(
            array_map(function (string $userLoginOrEmail): ?WP_User {
                $user = $this->fetcher->get($userLoginOrEmail);

                return ($user instanceof WP_User) ? $user : null;
            }, $blacklist)
        );

        if (! empty($badUsers)) {
            return new Failure($this);
        }

        return new Success($this);
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
