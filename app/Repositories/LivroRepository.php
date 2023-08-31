<?php

namespace App\Repositories;

use App\Models\Livro;

class LivroRepository
{
    public function find($id)
    {
        return Livro::find($id);
    }
}

