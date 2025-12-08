<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\Transaction;
use App\Models\WasteType;
use App\Models\RewardRedemption;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionStaffExport;
use App\Exports\TransactionAdminExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use function Symfony\Component\Clock\now;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            $transaction = Transaction::with('user', 'wasteType', 'location')->latest()->get();
            return view('admin.transaction.index', compact('transaction'));
        }

        // Staff hanya bisa melihat transaksi di lokasi sendiri
        $transaction = Transaction::with('user', 'wasteType', 'location')->where('id_lokasi', auth()->user()->id_lokasi)->latest()->get();

        return view('staff.transaction.index', compact('transaction'));
    }

    public function myPoint()
    {
        $user = auth()->user();
        $redeemHistory = RewardRedemption::where('id_user', $user->id_user)
            ->with('reward') // relasi ke tabel reward
            ->latest()
            ->paginate(10);

        // menghitung total point
        $totalEarned = $user->total_poin;

        // menghitung total point yang telah digunakan
        $totalSpent = RewardRedemption::where('id_user', $user->id_user)
            ->whereIn('status_tukar', ['pending', 'approved', 'done'])
            ->join('rewards', 'rewards.id_hadiah', '=', 'reward_redemptions.id_hadiah')
            ->sum('rewards.p_dibutuhkan');

        // menghitung total sisa point
        $totalSisa = $user->poin;

        $transactions = Transaction::with(['wasteType', 'location'])
            ->where('id_user', $user->id_user)
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('user.points.index', compact(
            'user',
            'transactions',
            'totalEarned',
            'totalSpent',
            'totalSisa',
            'redeemHistory'
        ));
    }

    public function create()
    {
        $user = User::where('role', 'user')->get();
        $wasteType = WasteType::all();

        if (auth()->user()->role === 'admin') {
            $location = Location::all();
            return view('admin.transaction.create', compact('user', 'wasteType', 'location'));
        }

        return view('staff.transaction.create', compact('user', 'wasteType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_jenis' => 'required|exists:waste_types,id_jenis',
            'berat' => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            // Format : TRSH-YYYYMMDD-0001
            $today = now()->format('Ymd');
            // Ambil transaksi terakhir di hari ini
            $lastTransaction = Transaction::whereDate('created_at', now()->format('Y-m-d'))
                ->orderBy('id_transaksi', 'desc')
                ->lockForUpdate()
                ->first();

            // Ambil nomor urut berikutnya
            $nextNumber = $lastTransaction
                ? ((int) substr($lastTransaction->no_transaksi, -4)) + 1
                : 1;

            // Bentuk kode transaksi
            $no_transaksi = 'TRSH-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $createData = [
                'no_transaksi' => $no_transaksi,
                'id_user' => $request->id_user,
                'id_jenis' => $request->id_jenis,
                'berat' => $request->berat,
                'poin_didapat' => $this->hitungPoin($request->id_jenis, $request->berat),
                'tanggal' => now(),
                'status' => 'pending',
            ];

            if (auth()->user()->role === 'staff') {
                $createData['id_lokasi'] = auth()->user()->id_lokasi;
            } else {
                $createData['id_lokasi'] = $request->id_lokasi;
            }

            Transaction::create($createData);
        });

        return auth()->user()->role === 'staff'
            ? redirect()->route('staff.transactions.index')->with('success', 'Transaksi berhasil ditambahkan!')
            : redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }



    public function updateStatus(Request $request, $id_transaksi)
    {
        $request->validate(['status' => 'required|in:pending,approved,completed,canceled']);

        $trx = Transaction::findOrFail($id_transaksi);
        $oldStatus = $trx->status;
        $trx->update(['status' => $request->status]);

        // kalau baru jadi "completed" → tambah poin
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            $user = User::find($trx->id_user);
            $user->increment('poin', $trx->poin_didapat);
            $user->increment('total_poin', $trx->poin_didapat);
        }

        // kalau dicancel/ditolak & sebelumnya completed → kembalikan poin
        if ($request->status !== 'completed' && $oldStatus === 'completed') {
            $user = User::find($trx->id_user);
            $user->decrement('poin', $trx->poin_didapat);
            $user->decrement('total_poin', $trx->poin_didapat);
        }

        return back()->with('success', 'Status diperbarui.');
    }

    private function hitungPoin($id_jenis, $berat)
    {
        //mengambil poin_per_kg di tabel waste_type dan dikalikan dengan berat di tabel transaction
        $wasteType = WasteType::find($id_jenis);
        return $wasteType->poin_per_kg * $berat;
    }

    public function edit($id_transaksi)
    {
        $transaction = Transaction::where('id_transaksi', $id_transaksi)->with(['user', 'wasteType', 'location'])->firstOrFail();
        $user = User::where('role', 'user')->get();
        $wasteType = WasteType::all();

        if (auth()->user()->role === 'admin') {
            $location = Location::all();
            return view('admin.transaction.edit', compact('transaction', 'user', 'wasteType', 'location'));
        } else {
            return view('staff.transaction.edit', compact('transaction', 'user', 'wasteType'));
        }
    }

    public function update(Request $request, $id_transaksi)
    {
        $transaction = Transaction::findOrFail($id_transaksi);

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_jenis' => 'required|exists:waste_types,id_jenis',
            'berat' => 'required|numeric|min:0.1',
        ]);

        $updateData = [
            'id_user' => $request->id_user,
            'id_jenis' => $request->id_jenis,
            'berat' => $request->berat,
            'poin_didapat' => $this->hitungPoin($request->id_jenis, $request->berat),
        ];

        if (auth()->user()->role === 'admin') {
            $request->validate(['id_lokasi' => 'required|exists:locations,id_lokasi']);
            $updateData['id_lokasi'] = $request->id_lokasi;
        } else {
            $updateData['id_lokasi'] = auth()->user()->id_lokasi;
        }

        $transaction->update($updateData);

        return auth()->user()->role === 'staff' ? redirect()->route('staff.transactions.index')->with('success', 'Transaksi diperbarui!') : redirect()->route('admin.transactions.index')->with('success', 'Transaksi diperbarui!');
    }

    public function destroy($id_transaksi)
    {
        $transaction = Transaction::findOrFail($id_transaksi);
        $transaction->delete();

        return auth()->user()->role === 'staff' ? redirect()->route('staff.transactions.index')->with('success', 'Transaksi berhasil dihapus!') : redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function trash()
    {
        if (auth()->user()->role === 'admin') {
            $transaction = Transaction::onlyTrashed()->with('user', 'wasteType', 'location')->get();
            return view('admin.transaction.trash', compact('transaction'));
        } else {
            $transaction = Transaction::onlyTrashed()->where('id_lokasi', auth()->user()->id_lokasi)->with('user', 'wasteType', 'location')->get();
            return view('staff.transaction.trash', compact('transaction'));
        }
    }

    public function restore($id_transaksi)
    {
        if (auth()->user()->role === 'admin') {
            $transaction = Transaction::onlyTrashed()->findOrFail($id_transaksi);
            $transaction->restore();
            return redirect()->route('admin.transactions.trash')->with('success', 'Berhasil mengembalikan data!');
        } else {
            $transaction = Transaction::onlyTrashed()->findOrFail($id_transaksi);
            $transaction->restore();
            return redirect()->route('staff.transactions.trash')->with('success', 'Berhasil mengembalikan data!');
        }
    }

    public function deletePermanent($id_transaksi)
    {
        $transaction = Transaction::onlyTrashed()->findOrFail($id_transaksi);
        $transaction->forceDelete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus permanen!');
    }

    public function exportExcel()
    {
        if (auth()->user()->role == 'admin') {
            $fileName = 'data-transaksi-admin.xlsx';
            return Excel::download(new TransactionAdminExport, $fileName);
        } else {
            $fileName = 'data-transaksi-staff.xlsx';
            $transactions = Transaction::with('user')->where('id_lokasi', auth()->user()->id_lokasi)->get();
            return Excel::download(new TransactionStaffExport($transactions), $fileName);
        }
    }

    public function exportPDF()
    {
        if (auth()->user()->role == 'admin') {
            $transactions = Transaction::with('user', 'wasteType', 'location')->get();
            $pdf = PDF::loadView('admin.transaction.export-pdf', compact('transactions'));
            return $pdf->download('data-transaksi-admin.pdf');
        } else {
            $transactions = Transaction::with('user', 'wasteType', 'location')->where('id_lokasi', auth()->user()->id_lokasi)->get();
            $pdf = PDF::loadView('staff.transaction.export-pdf', compact('transactions'));
            return $pdf->download('data-transaksi-staff.pdf');
        }
    }

    public function dataChart()
    {
        $month = now()->format('m');
        if (auth()->user()->role === 'admin') {
            $transactions = Transaction::with('user', 'wasteType', 'location')->whereMonth('tanggal', $month)->get()->groupBy(function ($transaction) {
                return Carbon::parse($transaction->tanggal)->format('d');
            })->toArray();
        } else {
            $transactions = Transaction::with('user', 'wasteType', 'location')->where('id_lokasi', auth()->user()->id_lokasi)->whereMonth('tanggal', $month)->get()->groupBy(function ($transaction) {
                return Carbon::parse($transaction->tanggal)->format('d');
            })->toArray();
        }
        $labels = array_keys($transactions);
        $data = [];
        foreach ($transactions as $transaction) {
            array_push($data, count($transaction));
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
