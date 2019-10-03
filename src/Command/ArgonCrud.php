<?php

namespace Argon\Form\Command;

use Illuminate\Console\Command;

class ArgonCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'argon:crud {model : The model class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create basic Argon/Form CRUD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function basicTemplating($template, Array $data) {

        foreach ($data as $key => $value) {
            $template = str_replace("%$key%", $value, $template);
        }
        return $template;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = $this->argument('model');
        
        if (!class_exists("\\App\\{$model}")) {
            $this->error("The model '{$model}' does not exist!");
            return;
        }

        
        if (file_exists(app_path('Http/Controllers')."/{$model}Controller.php")) {
            $this->error("The controller '{$model}Controller' already exists!");
            return;
        }

        if (file_exists(resource_path('views').DIRECTORY_SEPARATOR.strtolower($model).'_form.blade.php')) {
            $this->error("The view '".strtolower($model)."_form.blade.php' already exists!");   
            return;
        }

        if (file_exists(resource_path('views').DIRECTORY_SEPARATOR.strtolower($model).'_list.blade.php')) {
            $this->error("The view '".strtolower($model)."_list.blade.php' already exists!");   
            return;
        }

        $controllerCode = \View::file(__DIR__.'/stubs/controller.blade.php')->withModel($model);
        $controllerCode = "<?php\n\n".$controllerCode;

        $className = "\App\\{$model}";
        $obj = new $className;
        $fields = $obj->getFillable();

        $f = "";
        foreach ($fields as $field) {
            $f .= "{!! Form::text('{$field}')->label('{$field}')->value(\$model->{$field} ?? null) !!}\n";
        }

        $formViewCode = file_get_contents(__DIR__.'/stubs/form_view.stub');
        $formViewCode = $this->basicTemplating($formViewCode, [
            'indexRoute' => strtolower($model).".index",
            'fields' => $f
        ]);

        $columnNames = "\n";
        foreach ($fields as $field) {
            $columnNames .= "                      <td>$field</td>\n";
        }
        $columnNames .= "";

        $columnValues = "\n";
        foreach ($fields as $field) {
            $columnValues .= "                        <td>{{ \$row->{$field} }}</td>\n";
        }
        $columnValues .= "";

        $listViewCode = file_get_contents(__DIR__.'/stubs/list_view.stub');
        $listViewCode = $this->basicTemplating($listViewCode, [
            'columnNames' => $columnNames,
            'columnValues' => $columnValues,
            'model' => $model
        ]);

        
        
        $this->info("Creating Controller '{$model}Controller'...");
        file_put_contents(app_path("Http/Controllers/{$model}Controller.php"), $controllerCode);

        $this->info("Creating view '".strtolower($model)."_form.blade.php'...");
        file_put_contents(resource_path("views/".strtolower($model)."_form.blade.php"), $formViewCode);

        $this->info("Creating view '".strtolower($model)."_list.blade.php'...");
        file_put_contents(resource_path("views/".strtolower($model)."_list.blade.php"), $listViewCode);
        
        // copy(
        //     realpath(__DIR__.'/../../templates/layout/list.blade.php'),
        //     resource_path("views/".strtolower($model)."_list.blade.php")
        // );

    }
}
