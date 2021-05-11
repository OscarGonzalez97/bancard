<?php


namespace Bancard\Operations;

use Bancard\Bancard;
use Bancard\Util\Token;

class Charge extends Operation
{
    /**
     * @var string
     */
    protected $endpoint = '/vpos/api/0.3/charge';

    /**
     * Make a new token.
     *
     * @return string
     */
    public function token()
    {
        return Token::make(
            Bancard::privateKey(),
            $this->payload('shop_process_id'),
            $this->payload('charge'),
            $this->payload('amount'),
            $this->payload('currency'),
            $this->payload('alias_token'),
        );
    }
}
