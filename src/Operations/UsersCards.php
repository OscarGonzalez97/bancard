<?php


namespace Bancard\Operations;

use Bancard\Bancard;
use Bancard\Util\Token;

class UsersCards extends Operation
{

    /**
     * @var string
     */
    protected $endpoint = '/vpos/api/0.3/users/user_id/cards';

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Make a new token.
     *
     * @return string
     */
    public function token()
    {
        return Token::make(
            Bancard::privateKey(),
            $this->payload('user_id'),
            'request_user_cards',
        );
    }
}
