<?php

namespace Bancard\Operations;

use Bancard\Bancard;
use GuzzleHttp\Client;
use Bancard\Http\APIClient;
use InvalidArgumentException;

abstract class Operation
{
    use APIClient;

    /**
     * Bancard base URI
     *
     * @var string
     */
    protected $baseUri = 'https://vpos.infonet.com.py:8888/';

    /**
     * Operation payload
     *
     * @var array
     */
    protected $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;

        $this->http = new Client([
            'base_uri' => $this->baseUri
        ]);
    }

    /**
     * Make a new operation.
     *
     * @param $payload
     * @return static
     */
    public static function make($payload)
    {
        return (new static($payload))->execute();
    }

    public function execute()
    {
        return $this->request('post', $this->endpoint, $this->operationPayload());
    }

    abstract protected function token();

    public function operationPayload()
    {
        $default = [
            'token'           => $this->token(),
            'shop_process_id' => null,
            'amount'          => null,
            'description'     => null,
            'currency'        => null,
            'additional_data' => null,
            'return_url'      => null,
            'cancel_url'      => null,
        ];

        $operationData = array_filter(
            array_merge($default, $this->payload)
        );

        return [
            'public_key' => Bancard::getPublicKey(),
            'operation' => $operationData,
        ];
    }

    public function payload(string $key)
    {
        if (isset($this->payload[$key]) == false) {
            throw new InvalidArgumentException("Invalid key \"{$key}\" in payload.");
        }

        return $this->payload[$key];
    }
}
