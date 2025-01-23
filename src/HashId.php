<?php

namespace Pfrug\HashId;

use Exception;
use Jenssegers\Optimus\Optimus;
use RuntimeException;

trait HashId
{
    protected $optimus;

    public function __construct()
    {
        $this->optimus = app(Optimus::class);
    }

    /**
     * Retrieve the value of the model's route key.
     *
     * @return int
     * @throws RuntimeException
     */
    public function getRouteKey()
    {
        $key = $this->getKey();

        if (is_int($key) || ctype_digit($key)) {
            return $this->encodeId($key);
        }
        throw new RuntimeException('Key must be of type int to encode.');
    }

    /**
     * Resolve the route binding query by decoding the ID if it's numeric,
     * and retrieve the model for the bound value.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if (ctype_digit($value) || is_int($value)) {
            try {
                $value = $this->decodeId($value);
            } catch (Exception $e) {}
        }
        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * Encode the given ID using the Optimus library.
     *
     * @param int $id The ID to encode.
     * @return int The encoded ID.
     */
    public function encodeId($id)
    {
        return $this->optimus->encode($id);
    }

    /**
     * Decode the given encoded ID using the Optimus library.
     *
     * @param int $encodedId The encoded ID to decode.
     * @return int The decoded ID.
     */
    public function decodeId($encodedId)
    {
        return $this->optimus->decode($encodedId);
    }
}
