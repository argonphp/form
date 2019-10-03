<?php 
	$className = "\App\\$model";
	$obj = new $className;
	$fields = $obj->getFillable();
	$fillable = "'".implode("','", $fields)."'";
	
	$labels = "\n";
	foreach ($fields as $field) {
		$labels .= "        '$field' => '$field',\n";
	}
	$labels .= "    ";

	$validations = "\n";
	foreach ($fields as $field) {
		$validations .= "            '$field' => 'required',\n";
	}
	$validations .= "        ";


?>
namespace App\Http\Controllers;

use App\{{$model}};
use Illuminate\Http\Request;

class {{$model}}Controller extends Controller
{

    public function validation(Request $request) {
        $request->validate([{!!$validations!!}]);
        
        // To change some request data after validation in preparation do save in database
        // use the examples bellow:
        //
        // $request->merge(['name' => strtoupper($request->input('name')) ]);
        // $request->merge(['cpf' => str_replace(['.','-'], '', $request->input('cpf')) ]);
    }

	public function index() {
		return view('{{ strtolower($model).'_list' }}')
			->withModel({{ $model }}::class)
			->withRoutePrefix('{{ strtolower($model) }}')
			->withColumns([{!! $fillable !!}])
			->withLabels([{!! $labels !!}]);
	}

	public function create()
    {
        return view('{{ strtolower($model)."_form" }}')
        ->withAction(route("{{ strtolower($model) }}.store"));
    }

    public function store(Request $request)
    {

		if (is_callable([$this, 'validation'])) {
			$this->validation($request);
		}

    	{{$model}}::create($request->only([{!! $fillable !!}]));
    	return redirect()->route("{{ strtolower($model) }}.index");
    }

    public function edit({{$model}} ${{strtolower($model)}})
    {
    
    	$view = view('{{ strtolower($model).'_form' }}')
        ->withAction(route("{{strtolower($model)}}.update", ${{strtolower($model)}}->getKey()))
        ->withMethod('PUT');

        if (request()->session()->get('errors') === NULL) {
        	$view->withModel(${{strtolower($model)}});
        }

        return $view;
    }

    public function update(Request $request, {{$model}} ${{strtolower($model)}})
    {

		$this->validation($request);

		${{strtolower($model)}}->fill($request->only([{!! $fillable !!}]));
		${{strtolower($model)}}->save();

		return redirect()->route("{{ strtolower($model) }}.index");
    }

    public function destroy({{$model}} ${{strtolower($model)}}) {
    	${{strtolower($model)}}->delete();
    	return redirect()->route("{{ strtolower($model) }}.index");
    }

    public function show({{$model}} ${{strtolower($model)}}) {
    	return $this->edit(${{strtolower($model)}});
    }

}
