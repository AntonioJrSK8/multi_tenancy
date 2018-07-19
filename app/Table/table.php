<?php
namespace App\Table;

use Illuminate\Database\Eloquent\Builder;

class table
{
    /**
     * @var Builder
     */

    //propriedade usado para guarda as linhas
    private $rows = [];
    //propriedade usado para guarda as colunas
    private $columns = [];
    //propriedade de ações
    private $actions = [];
    /**
     * variavel usado para guarda os filtros dentro da tabela
     * @var
     */
    private $filters = [];
    //total de registro por pagina 15
    private $perPage = 15;
    //propriedade usado para guarda todas os modelos consultados
    private $model = null;
    private $modelOriginal = null;
    /**
     * Metodos de paginação
     * @var $perPage
     */
    public function paginate($perPage){
        $this->perPage = $perPage;
        return $this ;
    }
    /**
     * Metodo de filtragem na tabela
     * @var $filters
     */
    public function filters($filters){
        $this->filters = $filters;
        return $this;
    }

    //metodo usado para recupera as linhas do model
    public function rows(){
        return $this->rows;
    }

    /**
     * metodo usado para recupera as colunas do model
     * @param $columns
     */
    public function columns($columns = null)
    {
        if (!$columns) {
            return $this->columns;
        }
        $this->columns = $columns;
        return $this;
    }

    public function actions(){
        return $this->actions;
    }

    /**
     * @var $label
     * @var $route
     * @var $tamplate
     */
    public function addAction($label, $route, $template){
        $this->actions[] = [
            'label' => $label,
            'route' => $route,
            'template' => $template
        ];
        return $this;
    }

    /**
     * Metodo usado para implementar o botão  de editar no grid
     * @var $route
     * @var $template
     */
    public function addEditAction($route, $template = null){
        $this->addAction('Edição', $route,!$template ? 'table.edit_action' : $tamplate);
        return $this;
    }

    /**
     * Metodo usado para implementar o botão de excluir no grid
     * @var $route
     * @var $template
     */
    public function addDeleteAction($route, $template = null)
    {
        $this->addAction('Excluir', $route, !$template ? 'table.delete_action' : $tamplate);
        return $this;
    }

    /**
     *  metodo usado para recupera os model que foi guardado
     * @var $model
     */
    public function model($model = null){
        if(!$model){
            return $this->model;
        }
        $this->model = !is_object($model) ? new $model : $model;

        $this->modelOriginal = clone $this->model;
        return $this;
    }

    public function search(){
        $keycolumn = $this->modelOriginal->getKeyName();
        $columns = collect($this->columns())->pluck('name')->toArray();
        array_unshift($columns, $keycolumn);

        $this->applyFilters(); //Aplica o filtro antes do paginate.
        $this->applyOrders();

        $this->rows = $this->model->paginate($this->perPage, $columns);

        return $this;
    }

    protected function applyFilters(){
        foreach ($this->filters as $filter) {
            $field = $filter['name'];
            $operator = $filter['operator'];
            $search = \Request::get('search');
            $search = strtolower($operator)==='like' ? "%$search%" : $search;
            if (!strpos($filter['name'], '.')) {
                $this->model = $this->model->orWhere($field, $operator, $search);
            } else {
                list($relation, $field) = explode('.', $filter['name']);
                $this->model = $this->model->orWhereHas($relation, function ($query) use ($field, $operator, $search) {
                    $query->where($field, $operator, $search);
                });
            }

        }
    }

    protected function applyOrders(){
        $fieldOrderParam = \Request::get('field_order');
        $orderParam = \Request::get('order');
        foreach ($this->columns() as $key => $column){
            if($column['name'] === $fieldOrderParam && isset($column['order'])){
                $order = $orderParam =='desc'?'desc':'asc';
                $this->columns[$key]['_order'] = $order;
                $this->model->orderBy("{$column['name']}", $order);
            }elseif(isset($column['order'])){
                $this->columns[$key]['_order'] = $column['order'];
                if($column['order'] === 'asc' || $column['order']==='desc'){
                    $this->model->orderBy("{$column['name']}", $column['order']);
                }
            }
        }
    }

}
