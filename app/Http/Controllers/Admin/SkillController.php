<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Skill as SkillResource;
use App\Http\Resources\SkillCollection as SkillCollection;
use App\Skill;
use App\Http\Requests\SaveSkill;
use App\Scopes\SkillScope;

class SkillController extends Controller
{
    public function all()
    {
        return new SkillCollection(Skill::all());
    }

    public function create()
    {
       return response()->json(['id' => Skill::create()->id]);
    }

    public function edit(Skill $skill)
    {
        return new SkillResource($skill);
    }

    public function save($id, SaveSkill $request)
    {
        $skill = Skill::withoutGlobalScope(SkillScope::class)->findOrFail($id);
        $skill->order = $request->order ?? 0;
        $skill->skill = $request->skill;
        $skill->save();
        return new SkillResource($skill);
    }

    public function delete($id)
    {
        Skill::withoutGlobalScope(SkillScope::class)->findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }


}
