<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\Structure;
use Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $items = Employee::orderBy('head_id')->orderBy('sort')->orderByDesc('id')->paginate(30);
        return view('admin.employees.index', compact('items'));
    }


    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'position_uz' => 'required',
                'position_ru' => 'required',
                'position_en' => 'required',
                'project_uz'  => 'required',
                'project_ru'  => 'required',
                'project_en'  => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('admin/employees/create')->withErrors($validator)->withInput();
            }

            $data['is_vacant'] = $request->has('is_vacant');
            $data['head_id']   = $request->filled('head_id') ? (int) $request->head_id : null;
            $data['sort']      = (int) ($request->sort ?? 0);

            if ($request->hasFile('image')) {
                $img = $request->file('image');
                if ($img->isValid()) {
                    $ext  = $img->getClientOriginalExtension();
                    $name = rand(111, 999999) . '.' . $ext;
                    $path = 'images/employees/' . $name;
                    if (!file_exists('images/employees')) {
                        mkdir('images/employees', 0755, true);
                    }
                    (new ImageManager(new Driver()))->decode($img)->save($path);
                    $data['image'] = $name;
                }
            }

            Employee::create($data);
            return redirect('/admin/employees')->with('success', 'Успешно добавлено');
        }

        $heads = Employee::whereNull('head_id')->orderBy('sort')->orderByDesc('id')->get();
        $structures = Structure::orderBy('sort')->orderByDesc('id')->get();
        return view('admin.employees.create', compact('heads', 'structures'));
    }


    public function edit($id, Request $request)
    {
        $item = Employee::findOrFail($id);

        if ($request->isMethod('post')) {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'position_uz' => 'required',
                'position_ru' => 'required',
                'position_en' => 'required',
                'project_uz'  => 'required',
                'project_ru'  => 'required',
                'project_en'  => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('admin/employees/edit/' . $id)->withErrors($validator)->withInput();
            }

            $data['is_vacant'] = $request->has('is_vacant');
            $data['head_id']   = $request->filled('head_id') ? (int) $request->head_id : null;
            $data['sort']      = (int) ($request->sort ?? 0);

            // Prevent self-reference
            if ($data['head_id'] === $item->id) {
                $data['head_id'] = null;
            }

            if ($request->hasFile('image')) {
                $img = $request->file('image');
                if ($img->isValid()) {
                    $ext  = $img->getClientOriginalExtension();
                    $name = rand(111, 999999) . '.' . $ext;
                    $path = 'images/employees/' . $name;
                    if (!file_exists('images/employees')) {
                        mkdir('images/employees', 0755, true);
                    }
                    (new ImageManager(new Driver()))->decode($img)->save($path);
                    if ($item->image && file_exists('images/employees/' . $item->image)) {
                        unlink('images/employees/' . $item->image);
                    }
                    $data['image'] = $name;
                }
            }

            $item->update($data);
            return redirect('/admin/employees')->with('success', 'Успешно изменено');
        }

        $heads = Employee::whereNull('head_id')->where('id', '<>', $item->id)->orderBy('sort')->orderByDesc('id')->get();
        $structures = Structure::orderBy('sort')->orderByDesc('id')->get();
        return view('admin.employees.edit', compact('item', 'heads', 'structures'));
    }


    public function delete($id)
    {
        $item = Employee::findOrFail($id);

        // Detach team members from this head
        Employee::where('head_id', $item->id)->update(['head_id' => null]);

        if ($item->image && file_exists('images/employees/' . $item->image)) {
            unlink('images/employees/' . $item->image);
        }

        $item->delete();
        return redirect('/admin/employees')->with('success', 'Успешно удалено');
    }
}
