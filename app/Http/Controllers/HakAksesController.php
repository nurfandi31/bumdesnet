<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HakAksesController extends Controller
{
    public function index()
    {
        $users = User::with('position')->get();
        $title = '';
        return view('hak_akses.index')->with(compact('users', 'title'));
    }


    public function hakAkses($id_user)
    {

        $user = User::with('position')->where('id', $id_user)->first();
        $menu = Menu::where('parent_id', '0')->with('child')->get();
        return view('hak_akses.update')->with(compact('user', 'menu'));
    }

  public function simpan(Request $request, $id_user)
{
    $menu = Menu::whereNotIn('id', $request->menu)->pluck('id');
    User::where('id', $id_user)->update([
        'akses_menu' => json_encode($menu)
    ]);

    return redirect('/master')->with('success', 'Hak akses berhasil diperbarui!');
}

}
