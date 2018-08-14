<?php
declare(strict_types=1);

namespace Itineris\Preflight\Checkers;

use Itineris\Preflight\CheckerInterface;
use Itineris\Preflight\ResultInterface;
use Itineris\Preflight\Results\Failure;
use Itineris\Preflight\Results\Success;
use WP_CLI\Fetchers\User;

class BadUserLoginOrEmail implements CheckerInterface
{
    /**
     * User fetcher.
     *
     * @var User
     */
    private $fetcher;

    /**
     * BadUserLoginOrEmail constructor.
     *
     * @param User $fetcher User fetcher.
     */
    public function __construct(User $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'bad-user-login-or-email';
    }

    /**
     * Run the check and return a result.
     * TODO: Accept config object/array.
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
            array_map(function (string $userLoginOrEmail) {
                return $this->fetcher->get($userLoginOrEmail);
            }, $blacklist)
        );

        if (! empty($badUsers)) {
            return new Failure($this);
        }

        return new Success($this);
    }
}
