<?php

namespace App\Traits;

trait ResponseTrait
{
    // Handling Success Response.
    public static function Success($data, $message, $code = 200)
    {
        return response()->json([
            'code' => (int) $code,
            'message' => __('' . $message),
            'data' => $data,
        ], $code);
    }

    // Handling Error Response.
    public static function Error($message, $code, $data = [])
    {
        return response()->json([
            'code' => (int) $code,
            'message' =>  __('' . $message),
            'data' => (object) $data,
        ], $code);
    }

    // Handling ValidationError Response.
    public static function ValidationError($validator)
    {
        $errors = collect($validator->errors())
            ->flatMap(function ($messages, $field) {
                return [$field => $messages];
            })
            ->map(function ($messages, $field) {
                return [
                    'error' => $messages[0],
                    'field' => $field,
                ];
            })
            ->values();
        return response()->json([
            'code' => 422,
            'message' => __('message.validation.' . $errors[0]['error']),
            'data' => (object) [],
        ], 422);
    }
}
