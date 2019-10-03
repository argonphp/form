<?php

namespace Argon\Form;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
	
	public function index() {
		return view('ArgonForm::layout.list')
			->withModel($this->model)
			->withRoutePrefix($this->routePrefix)
			->withColumns($this->columns)
			->withLabels($this->labels);
	}

	public function create()
    {
        return view($this->formView)
        ->withAction(route("{$this->routePrefix}.store"));
    }

    public function store(Request $request)
    {
    	
    	$modelClass = $this->model;
    	$model = new $modelClass;
    	$fillable = $model->getFillable();

		if (is_callable([$this, 'validation'])) {
			$this->validation($request);
		}

    	$modelClass::create($request->only($fillable));
    	return redirect()->route("{$this->routePrefix}.index");
    }

    public function edit($id)
    {

    	$className = $this->model;
    	$model = $className::find($id);
        
    	$view = view($this->formView)
        ->withAction(route("{$this->routePrefix}.update", $id))
        ->withMethod('PUT');

        if (request()->session()->get('errors') === NULL) {
        	$view->withModel($model);
        }

        return $view;
    }

    public function update(Request $request, $id)
    {
    	$className = $this->model;
    	$model = $className::find($id);

		if (is_callable([$this, 'validation'])) {
			$this->validation($request);
		}

		$model->fill($request->only($model->getFillable()));
		$model->save();

		return redirect()->route("{$this->routePrefix}.index");
    }

    public function destroy($id) {
    	$className = $this->model;
    	$model = $className::find($id);
    	$model->delete();
    	return redirect()->route("{$this->routePrefix}.index");
    }

    public function show($id) {
    	return $this->edit($id);
    }

}