<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VariableResource as VarResource;
use App\Http\Resources\VariableCollection as VarCollection;

use App\Variable;
use App\Http\Requests\SaveVariable;

class VarController extends Controller
{
    public function all()
    {
        return new VarCollection(Variable::all());
    }

    public function create()
    {
       return Variable::create()->id;
    }

    public function edit(Variable $variable)
    {
        return new VarResource($variable);
    }

    public function save(Variable $variable, SaveVariable $request)
    {
        $variable->key = $request->key;
        $variable->value = $request->value;
        $variable->save();
        return new VarResource($variable);
    }

    public function delete(Variable $variable)
    {
        $variable->delete();
        return response()->json(['status' => 'success']);
    }


}
