<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ServiceException extends Exception
{
    /**
     * @var array|object|null
     */
    private $type;

    public function __construct($message = "", $type = null, $code = 500, Throwable $previous = null)
    {
        $this->type = $type;
        parent::__construct($message, $code, $previous);
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'type' => $this->getType(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
