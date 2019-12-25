<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $guarded = ['id'];

    public function store($inputs, $id = null)
    {
        if($id)
        {
            $contacts= $this->findOrFail($id);
            return $contacts->update($inputs);
        }
        return $this->create($inputs)->id;
    }

}
