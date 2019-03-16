<?php

namespace Modules\Base\Repositories;

interface RepositoryInterface
{
    public function store(array $attributes);

    public function update($id, array $attributes);

    public function all($order);

    public function paginate($order);

    public function find($id);

    public function destroy($id);
}