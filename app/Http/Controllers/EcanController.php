<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\LogAktivitas;
use App\Models\Makanan;
use App\Models\Pesanan;
use App\Models\Rating;
use App\Models\store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EcanController extends Controller
{
    /**
     * Menampilkan halaman utama untuk User.
     */
    public function index()
    {
        $stores = store::with('Makanan')->get(); // Fetch all stores
        return view('user.dashboard', compact('stores'));
    }

    /**
     * Menampilkan halaman admin untuk melihat data.
     */
    public function admin()
    {
        $stores = store::with('Makanan')->get();
        $users = \App\Models\User::all();
        $makanan = Makanan::all();
        return view('admin.dashboard', compact('stores', 'users', 'makanan'));
    }

    public function addUserForm(){
        return view('admin.tambah_user');
    }

    //Tambah User
    public function addUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        $user = new \App\Models\User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  // Make sure to hash the password
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User successfully added!');
    }

    public function deleteUser($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User successfully deleted!');
    }

    public function editUserForm($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        return view('admin.edit_user', compact('user'));
    }

    public function editUser(Request $request, $userId)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'role' => 'required|in:user,admin',
        ]);

        $user = \App\Models\User::findOrFail($userId);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User successfully updated!');
    }


    /**
     * Menambahkan makanan (Admin).
     */
    public function makanan()
    {
        $makanan = Makanan::all();
        return view('admin.makanan', compact('makanans'));
    }

    public function tambahMakananForm()
    {
        $stores = store::all();  // Ambil semua toko
        return view('admin.tambah_makanan', compact('stores'));
    }

    public function tambahMakanan(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'store_id' => 'required|exists:stores,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $makanan = new Makanan();
        $makanan->nama_makanan = $request->nama_makanan;
        $makanan->deskripsi = $request->deskripsi;
        $makanan->harga = $request->harga;
        $makanan->store_id = $request->store_id;

        if ($request->hasFile('gambar')) {
            $makanan->gambar = $request->file('gambar')->store('images', 'public');
        }

        $makanan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Makanan berhasil ditambahkan');
    }

    public function deleteMakanan($makananId)
    {
            // Delete related ratings first
        Rating::where('makanan_id', $makananId)->delete();
        $makanan = Makanan::findOrFail($makananId);
        $makanan->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Makanan successfully deleted!');
    }



    public function tambahTokoForm()
    {
        return view('admin.tambah_toko');
    }

    public function tambahToko(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store = new store();
        $store->name = $request->name;
        $store->description = $request->description;

        $store->save();

        return redirect()->route('admin.dashboard')->with('success', 'Toko berhasil ditambahkan');
    }

    /**
     * Memberikan rating untuk makanan (User).
     */
    public function beriRating(Request $request, $makananId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'makanan_id' => $makananId,
            ],
            [
                'rating' => $request->rating,
            ]
        );
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Memberikan rating' . $request->rating . 'pada makanan' . Makanan::find($makananId)->nama_makanan,
        ]);

        return redirect()->back()->with('success', 'Rating berhasil diberikan!');
    }

    /**
     * Menambahkan komentar untuk makanan (User).
     */
    public function tambahKomentar(Request $request, $makananId)
    {
        $request->validate([
            'komentar' => 'required|string|max:500',
        ]);

        Komentar::create([
            'user_id' => Auth::id(),
            'makanan_id' => $makananId,
            'komentar' => $request->komentar,
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Memberikan Komentar ' . $request->komentar . ' pada makanan' . Makanan::find($makananId)->nama_makanan,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Membuat pesanan makanan (User).
     */
    public function orderPage($makananId)
    {
        $makanan = Makanan::findOrFail($makananId);
        return view('order', compact('makanan'));
    }

    public function showStores()
    {
        $stores = store::all();
        return view('user.stores', compact('stores'));
    }

    public function showMakananByStore($storeId)
    {
        $store = store::with('makanan')->findOrFail($storeId);
        return view('user.makanans', compact('store'));
    }

    public function addToBag(Request $request, $makananId)
    {
        $makanan = Makanan::findOrFail($makananId);

        $cart = session()->get('cart', []);

        if (isset($cart[$makananId])) {
            $cart[$makananId]['quantity']++;
        } else {
            $cart[$makananId] = [
                'name' => $makanan->nama_makanan,
                'price' => $makanan->harga,
                'quantity' => 1,
                'image' => $makanan->gambar // Asumsikan kolom gambar ada di tabel makanan
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Makanan berhasil ditambahkan ke keranjang!');
    }

    public function removeFromCart($makananId)
    {
        $cart = session()->get('cart', []);

        // Cek apakah makanan ada di dalam cart
        if (isset($cart[$makananId])) {
            // Hapus item tersebut
            unset($cart[$makananId]);

            // Simpan kembali ke session
            session()->put('cart', $cart);

            // Kembalikan ke halaman keranjang dengan pesan sukses
            return redirect()->route('user.cart')->with('success', 'Item berhasil dihapus dari keranjang');
        }

        return redirect()->route('user.cart')->with('error', 'Item tidak ditemukan di keranjang');
    }


    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

// Method to show order review page
    public function reviewOrder()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;

        foreach ($cart as $makananId => $details) {
            $totalPrice += $details['quantity'] * $details['price'];
        }

        return view('order', compact('cart', 'totalPrice'));
    }

    // Method to handle the final checkout (after confirmation)
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cod,qris', // Payment method options
        ]);

        $cart = session()->get('cart', []);

        // Validate if the cart is empty
        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        // Process the order after payment method selection
        foreach ($cart as $makananId => $details) {
            Pesanan::create([
                'user_id' => Auth::id(),
                'makanan_id' => $makananId,
                'jumlah' => $details['quantity'],
                'total_harga' => $details['quantity'] * $details['price'],
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Checked out for makanan: ' . Makanan::find($makananId)->nama_makanan . ' with quantity: ' . $details['quantity'],
            ]);
        }

        // Clear the cart after checkout
        session()->forget('cart');

        return redirect()->route('user.dashboard')->with('success', 'Checkout successful!');
    }


    /**
     * Menampilkan log aktivitas user (Admin).
     */
    public function showActivityLog()
    {
        $logActivities = LogAktivitas::with('user')->get();
        return view('admin.activity_log', compact('logActivities'));
    }
}
