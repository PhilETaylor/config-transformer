<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109238\Symfony\Component\HttpFoundation\Session\Storage;

use ConfigTransformer202109238\Symfony\Component\HttpFoundation\Request;
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 *
 * @internal to be removed in Symfony 6
 */
final class ServiceSessionFactory implements \ConfigTransformer202109238\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface
{
    private $storage;
    public function __construct(\ConfigTransformer202109238\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface $storage)
    {
        $this->storage = $storage;
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     */
    public function createStorage($request) : \ConfigTransformer202109238\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
    {
        if ($this->storage instanceof \ConfigTransformer202109238\Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage && $request && $request->isSecure()) {
            $this->storage->setOptions(['cookie_secure' => \true]);
        }
        return $this->storage;
    }
}
