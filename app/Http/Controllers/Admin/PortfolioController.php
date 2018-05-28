<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio as PortfolioResource;
use App\Http\Resources\PortfolioCollection;
use App\Portfolio;
use App\Http\Requests\SavePortfolio;
use App\Scopes\PortfolioTitleScope;

class PortfolioController extends Controller
{
    public function all()
    {
        return new PortfolioCollection(Portfolio::all());
    }

    public function create()
    {
        return response()->json(['id' => Portfolio::create()->id]);
    }

    public function edit(Portfolio $portfolio)
    {
        return new PortfolioResource($portfolio);
    }

    public function save($id, SavePortfolio $request)
    {
        $portfolio= Portfolio::withoutGlobalScope(PortfolioTitleScope::class)->findOrFail($id);
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->url = $request->url;
        $portfolio->save();
        return new PortfolioResource($portfolio);
    }

    public function delete($id)
    {
        Portfolio::withoutGlobalScope(PortfolioTitleScope::class)->findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }

    public function images(Request $request, Portfolio $portfolio)
    {
       return $portfolio->images; 
    }

    public function imageSync(Request $request, Portfolio $portfolio)
    {
        $this->validate($request, [
            'ids' => 'string|nullable'
        ]);

        $ids = $request->ids;

        $array = [];
        if(!empty($ids)){
            $array = explode(',', $ids);
        }

        $portfolio->images()->sync($array);
        return $this->images($request, $portfolio);
    }
}
