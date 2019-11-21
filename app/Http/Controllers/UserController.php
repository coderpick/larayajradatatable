<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use Illuminate\Http\Request;
use Cornford\Backup\Facades\Backup;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function home(){

        $files = Backup::getRestorationFiles(storage_path().'/backup/');

        return view('welcome',compact('files'));

    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a><a href="javascript:void(0)" class="edit btn btn-info btn-sm">Edit</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users');
    }

    public function dbBackup()
    {
        Backup::setPath(storage_path().'/backup/');
        Backup::export();
        connectify('success', 'Backup Success!', 'Database Backup successfully completed');
        return redirect()->back();
    }

    public function dbRestore(Request $request)
    {
        $file = $request->file;
        Backup::restore(storage_path().'/backup/'.$file);
        connectify('success', 'Restore Success!', 'Database Restore successfully completed');
        return redirect()->back();
    }

    public function dbDelete(Request $request)
    {
        $file = $request->file;
        File::delete(storage_path().'/backup/'.$file);
        connectify('success', 'Delete Success!', 'Database Delete successfully completed');
        return redirect()->back();
    }

}
