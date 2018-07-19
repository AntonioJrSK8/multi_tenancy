<?php

namespace App\Http\Controllers;

use App\Category;
use App\Table\table;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{


    /**
     * @var Table
     */
    private $table;

    /**
     * Construtor
     * @param $table
     */
    public function __construct(Table $table)
    {
        $this->middleware('auth');
        //$this->middleware('auth');
        $this->table = $table;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = \Auth::user()->account_id;
        $this->table->model(Category::ByAccount($account))
            ->columns([
                [
                    'label' => 'Nome',
                    'name' => 'name',
                    'order' => true
                ]
            ])
            ->filters([
                [
                    'name' => 'id',
                    'operator' => 'like'
                ],
                [
                    'name' => 'name',
                    'operator' => 'like'
                ]
            ])
            ->addEditAction('category.edit')
            ->addDeleteAction('category.destroy')
            ->paginate(5)
            ->search();

        return view('categories.index', [
            'table' => $this->table
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo $id;
    }
}
