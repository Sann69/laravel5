<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Illuminate\Support\Str;

class UserController extends Controller
{

    
    public function callSession(Request $request)
    {
        return redirect()->back()->with('status', 'Berhasil memanggil sesi');
    }

    public function getAdmin(User $user)
    {
        $products = Product::where('user_id', $user->id)->get();
        return view('admin_page', ['products' => $products, 'user' => $user]);
    }

    public function editProduct(Request $request, User $user, Product $product)
    {
        return view('edit_product', ['product' => $product, 'user' => $user]);
    }

    // public function updateProduct(Request $request, User $user, Product $product)
    // {

    //     if ($product->user_id === $user->id) {
    //         $product->nama = $request->nama;
    //         $product->stok = $request->stok;
    //         $product->berat = $request->berat;
    //         $product->harga = $request->harga;
    //         $product->deskripsi = $request->deskripsi;
    //         $product->kondisi = $request->kondisi;
    //         $product->gambar = $request->gambar;
    //         $product->save();
    //     }

    //     return redirect()->route('admin_page', ['user' => $user->id])->with('message', 'Berhasil update data');
    // }


    public function updateProduct(Request $request, User $user, Product $product)
    {
        // Validasi input
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048', // Ubah gambar jika diunggah
        ]);
    
        if ($product->user_id === $user->id) {
            // Update data produk
            $product->nama = $request->nama;
            $product->stok = $request->stok;
            $product->berat = $request->berat;
            $product->harga = $request->harga;
            $product->deskripsi = $request->deskripsi;
            $product->kondisi = $request->kondisi;
    
            // Ubah gambar jika diunggah
            if ($request->hasFile('gambar')) {
                // Simpan gambar baru
                $gambarPath = $request->file('gambar')->store('public/gambar');
                $product->gambar = basename($gambarPath);
            }
    
            // Simpan perubahan produk
            $product->save();
            
            return redirect()->route('admin_page', ['user' => $user->id])->with('message', 'Berhasil update data');
        }
    
    }


    public function deleteProduct(Request $request, User $user, Product $product)
    {
        if ($product->user_id === $user->id) {
            $product->delete();
        }
        return redirect()->back()->with('status', 'Berhasil menghapus data');
    }

    public function handleRequest(Request $request, User $user)
    {
        return view('handle_request', ['user' => $user]);
    }

    // public function postRequest(Request $request, User $user)
    // {

    //     Product::create([
    //         'user_id' => $user->id,
    //         'gambar' => $request->gambar,
    //         'nama' => $request->nama,
    //         'berat' => $request->berat,
    //         'harga' => $request->harga,
    //         'kondisi' => $request->kondisi,
    //         'stok' => $request->stok,
    //         'deskripsi' => $request->deskripsi,
    //     ]);

    //     // return redirect()->route('get_product');
    //     return redirect()->route('admin_page', ['user' => $user->id]);
    // }

        public function postRequest(Request $request, User $user)
    {
        // Validasi form
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // validasi untuk gambar
            // tambahkan validasi untuk input lainnya
        ]);

        // Simpan gambar ke penyimpanan lokal (storage/app/public/gambar)
        $gambarPath = $request->file('gambar')->store('public/gambar');

        // Ambil nama file gambar
        $gambarName = basename($gambarPath);

        // Buat record baru di database
        Product::create([
            'user_id' => $user->id,
            'gambar' => $gambarName,
            'nama' => $request->nama,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'kondisi' => $request->kondisi,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin_page', ['user' => $user->id]);
    }



    public function getProduct()
    {
        $products = Product::all();
        //. $user = User::find(1);
        //. $data = $user->products;
        return view('products')->with('products', $products);

    }


    public function getProfile(Request $request, User $user)
    {
        $user = User::with('summarize')->find($user->id);
        // dd($user);
        return view('profile', ['user' => $user]);
    }


    //----------------------------------------------------------------------

    public function register()
    {
        return view('register');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required|in:male,female',
            'umur' => 'required|integer|min:1',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'umur' => $request->umur,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
        ]);

        // assign role
        $user->assignRole('user');

        if ($user) {
            return redirect()->route('register')
                ->with('success', 'User created successfully');
        } else {
            return redirect()->route('register')
                ->with('error', 'Failed to create user');
        }
    }

    public function login()
    {
        return view('login');
    }

    // public function loginUser(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('login')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $request->session()->regenerate();
    //         return redirect()->route('dashboard');

    //     } else {
    //         return redirect()->route('login')
    //             ->with('error', 'Login failed email or password is incorrect');
    //     }
    // }


    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('superadmin')) {
                return redirect()->route('admin_page', ['user' => $user->id]);
            } elseif ($user->hasRole('user')) {
                return redirect()->route('get_product');
            }
        } else {
            return redirect()->route('login')
                ->with('error', 'Login failed, email or password is incorrect');
        }
    }






    public function dashboard()
    {
        $user = Auth::user();

        // get user role
        // dd($user->roles[0]->name);
        
        // change role
        // $user->roles()->detach();
        // $user->assignRole('superadmin');

        // if (!$user) {
        //     return redirect()->route('login');
        // }

        return view('dashboard', compact('user'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = new User();
            $newUser->google_id = $user->id;
            $newUser->nama = $user->nama;
            $newUser->email = $user->email;
            $newUser->password = Hash::make(Str::random(15));
            $newUser->gender = 'male';
            $newUser->umur = 25;
            $newUser->tgl_lahir = '1996-05-13';
            $newUser->alamat = 'Jakarta Selatan';
            $newUser->save();

            // assign role
            $newUser->assignRole('user');

            Auth::login($newUser);
        }

        return redirect()->route('dashboard');
    }
}