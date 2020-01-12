<?php


namespace Allenlinatoc\PhpContainer;


use Allenlinatoc\PhpContainer\Exceptions\ContainerNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class Container extends \Pimple\Container implements ContainerInterface
{

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     * @throws ContainerNotFoundException
     */
    public function get($id)
    {
        if (!$this->offsetExists($id))
        {
            throw new ContainerNotFoundException($id);
        }
        return $this->offsetGet($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->offsetExists($id);
    }


    public function set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    public function __get($id)
    {
        return $this->get($id);
    }

    public function __set($id, $value)
    {
        $this->set($id, $value);
    }

}