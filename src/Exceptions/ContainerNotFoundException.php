<?php


namespace Allenlinatoc\PhpContainer\Exceptions;

use Throwable;

class ContainerNotFoundException extends \Exception
{
    const CODE_DEFAULT = 0;

    /**
     * ContainerNotFoundException constructor.
     * @param string $id        ID or name of container element not found
     * @param int $code         (Optional) Exception
     * @param Throwable|null $previous
     */
    public function __construct($id, $code = self::CODE_DEFAULT, Throwable $previous = null)
    {
        parent::__construct("Container element \"" . $id . "\" not found", $code, $previous);
    }
}