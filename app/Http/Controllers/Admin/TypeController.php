<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : 'updated_at';
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : 'ASC';

        $types = Type::orderBy($sort, $order)->paginate(10)->withQueryString();

        return view('admin.types.index', compact('types', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = new Type();

        return view('admin.types.form', compact('type'))
            ->with('message_content', 'Tipologia creata con successo');;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request->all());

        $type = new Type();
        $type->fill($data);
        $type->save();

        return to_route('admin.types.index', $type)
            ->with('message_content', 'Type creato con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $data = $this->validation($request->all());

        $type->update($data);
        return to_route('admin.types.index', $type)
            ->with('message_content', 'Tipologia ' . $type->title . ' modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type_id = $type->id;
        $type->delete();
        return to_route('admin.types.index')
            ->with('message_type', 'danger')
            ->with('message_content', 'Tipologia ' . $type->title . 'con id ' . $type->id . ' eliminata con successo.');
    }

    private function validation($data)
    {
        return Validator::make(
            $data,
            [
                'label' => 'required|string|max:30',
                'color' => 'required|string|size:7'
            ],
            [
                'label.required' => 'Label must be field',
                'label.string' => 'Label must be a string',
                'label.max' => 'Label must be a string',

                'color.required' => 'Label must be field',
                'color.string' => 'Label must be a string',
                'color.size' => 'Label must have max 7 characters (es. #ffffff)',
            ]
        )->validate();
    }
}
