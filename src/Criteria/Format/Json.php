<?php

namespace Streams\Core\Criteria\Format;

use Illuminate\Support\Arr;
use Filebase\Format\FormatInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Class Json
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Json implements FormatInterface
{

    /**
     * Get the format's file extension.
     * 
     * @return string
     */
    public static function getFileExtension()
    {
        return 'json';
    }

    /**
     * Encode the data for storage.
     * 
     * @param array $data
     * @param bool $pretty
     * @return string
     */
    public static function encode($data, $pretty)
    {
        $meta = (array) $data;

        $data = Arr::pull($meta, 'data', []);

        $data = array_merge($meta, $data);

        if (!isset($data['__created_by']) && $user = Auth::user()) {
            $data['__created_by'] = $user->getAuthIdentifier();
        }

        if (!isset($data['__updated_by']) && $user = Auth::user()) {
            $data['__updated_by'] = $user->getAuthIdentifier();
        }

        return json_encode($data);
    }

    /**
     * Decode the data from storage.
     * 
     * @param $data
     * @return mixed
     */
    public static function decode($data)
    {
        return [
            'data' => json_decode($data, true),
        ];
    }
}
