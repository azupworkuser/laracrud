<?php

namespace LaraCrud\View;

use DbReader\Table;
use LaraCrud\Helpers\TemplateManager;
use LaraCrud\View\Partial\Panel;
use LaraCrud\View\Partial\Table as TableView;

/**
 * Tuhin Bepari <digitaldreams40@gmail.com>
 */
class Index extends Page
{
    protected $tableView;
    protected $panel;

    public function __construct(Table $table, $name = '', $type = '')
    {
        $this->table = $table;
        $this->setFolderName();
        $this->name = !empty($name) ? $name : config('laracrud.view.page.index.name');
        $this->type = !empty($type) ? $type : config('laracrud.view.page.index.type');
        $this->tableView = new TableView($this->table);
        $this->panel = new Panel($this->table);
        parent::__construct();
    }

    /**
     *
     */
    function template()
    {
        $file = '';
        $prefix = config('laracrud.view.namespace') ? config('laracrud.view.namespace') . '::' : '';
        $folder = $this->version == 3 ? 'panels' : 'cards';
        $data = [
            'table' => $this->table->name(),
            'layout' => config('laracrud.view.layout'),
            'folder' => $prefix . $folder,
            'routeModelKey' => $this->dataStore['routeModelKey'] ?? 'id',
            'searchBox' => '',
            'partialFilename' => str_singular($this->table->name()),
            'createRoute' => $this->getRouteName('create', $this->table->name())
        ];
        switch ($this->type) {
            case 'panel':
                $this->panel();
                $file = "view/{$this->version}/pages/index_panel.html";
                break;
            case 'table':
                $this->tableView();
                $file = "view/{$this->version}/pages/index.html";
                break;
            default:
                $this->tableView();
                $file = "view/{$this->version}/pages/index.html";
                break;
        }
        $tempMan = new TemplateManager($file, $data);
        return $tempMan->get();
    }

    /**
     *
     * @return string
     * @throws \Exception
     */
    protected function tableView()
    {
        if (!$this->tableView->isExists()) {
            return $this->tableView->save();
        }
    }

    /**
     *
     */
    protected function panel()
    {
        if (!$this->panel->isExists()) {
            return $this->panel->save();
        }
    }

    /**
     *
     */
    protected function searchBox()
    {
        return '';
    }

    public function save()
    {
        parent::save(); // TODO: Change the autogenerated stub
    }

}