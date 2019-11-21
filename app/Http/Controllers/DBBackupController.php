<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Backup\Facades\Backup;
use Illuminate\Support\Facades\File;

class DBBackupController extends Controller
{
    public function home(){

        $files = Backup::getRestorationFiles(storage_path().'/backup/');

        return view('welcome',compact('files'));

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
