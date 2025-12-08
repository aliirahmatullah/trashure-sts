<?php

namespace App\Http\Controllers;

use App\Models\RewardRedemption;
use App\Models\Reward;
use App\Models\User;
use App\Models\WasteType;
use App\Models\Transaction;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Exports\RewardRedemptionExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RewardRedemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $redeem_reward = RewardRedemption::with('reward', 'user')->get();
        return view('admin.redeem.index', compact('redeem_reward'));
    }

    public function form($id_hadiah)
    {
        $reward = Reward::findOrFail($id_hadiah);
        return view('user.redeem.form', compact('reward'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id_hadiah)
    {
        $reward = Reward::findOrFail($id_hadiah);
        $user = auth()->user();

        DB::transaction(function () use ($user, $reward, $request) {
            $today = now()->format('Ymd');
            $lastRedeem = RewardRedemption::whereDate('tanggal_tukar', now()->format('Y-m-d'))
            ->orderBy('id_tukar', 'desc')
            ->lockForUpdate()
            ->first();

            $nextNumber = $lastRedeem ? ((int)substr($lastRedeem->no_transaksi, -4)) + 1 : 1;
            $no_transaksi = 'THRR-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // kurangi poin user
            $user->decrement('poin', $reward->p_dibutuhkan);

            // simpan data redeem
            RewardRedemption::create([
                'id_user'           => $user->id_user,
                'id_hadiah'         => $reward->id_hadiah,
                'no_transaksi'      => $no_transaksi,
                'jumlah_hadiah'     => 1,
                'tanggal_tukar'     => now(),
                'status_tukar'      => 'pending',
                'nama_penerima'     => $request->nama_penerima,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'no_hp_penerima'    => $request->no_hp_penerima,
            ]);
        });
        return redirect()->route('user.points.index')->with('success', 'Hadiah berhasil ditukar! Silakan tunggu konfirmasi admin.');
    }

    public function updateStatus(Request $request, $id_tukar)
    {
        $request->validate([
            'status_tukar' => 'required|in:pending,approved,done,canceled'
        ]);

        $redeem = RewardRedemption::with('reward', 'user')->findOrFail($id_tukar);

        $oldStatus = $redeem->status_tukar;
        $newStatus = $request->status_tukar;

        // jika dibatalkan dan sebelumnya BUKAN canceled → kembalikan poin
        if ($newStatus === 'canceled' && $oldStatus !== 'canceled') {
            $redeem->user->increment('poin', $redeem->reward->p_dibutuhkan);
        }

        // update status
        $redeem->update([
            'status_tukar' => $newStatus
        ]);

        return back()->with('success', 'Status redeem reward berhasil diperbarui.');
    }


    /**
     * Display the specified resource.
     */
    public function show(RewardRedemption $rewardRedemption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_tukar)
    {
        $redeem = RewardRedemption::with('reward', 'user')->findOrFail($id_tukar);
        return view('admin.redeem.edit', compact('redeem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_tukar)
    {


        $request->validate([
            'nama_penerima'     => 'required',
            'alamat_pengiriman' => 'required',
            'no_hp_penerima'    => 'required'
        ]);

        $redeem = RewardRedemption::findOrFail($id_tukar);

        $redeem->update([
            'nama_penerima'     => $request->nama_penerima,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_hp_penerima'    => $request->no_hp_penerima,
        ]);

        return redirect()->route('admin.redeems.index')->with('success', 'Redeem Reward diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_tukar)
    {
        $redeem = RewardRedemption::findOrFail($id_tukar);
        $redeem->delete();
        return back()->with('success', 'Redeem Reward berhasil dihapus!');
    }

    public function trash()
    {
        $redeem_reward = RewardRedemption::onlyTrashed()->with('reward', 'user')->get();
        return view('admin.redeem.trash', compact('redeem_reward'));
    }

    public function restore($id_tukar)
    {
        $redeem = RewardRedemption::withTrashed()->findOrFail($id_tukar);
        $redeem->restore();
        return redirect()->route('admin.redeems.trash')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id_tukar)
    {
        $redeem = RewardRedemption::onlyTrashed()->findOrFail($id_tukar);
        $redeem->forceDelete();
        return back()->with('success', 'Redeem Reward berhasil dihapus permanen!');
    }

    public function exportExcel()
    {
        $fileName = 'data-redeem.xlsx';
        return Excel::download(new RewardRedemptionExport, $fileName);
    }

    public function exportPDF()
    {
        $redeem_reward = RewardRedemption::with('reward', 'user')->get();
        $pdf = Pdf::loadView('admin.redeem.export-pdf', compact('redeem_reward'));
        return $pdf->download('data-redeem.pdf');
    }

    public function dataChart()
    {
        $month = now()->format('m');
        $redeem_reward = RewardRedemption::with('reward', 'user')->whereMonth('tanggal_tukar', $month)->get()->groupBy(function ($redeem) {
            return Carbon::parse($redeem->tanggal_tukar)->format('d');
        })->toArray();

        $labels = array_keys($redeem_reward);
        $data = [];
        foreach ($redeem_reward as $redeem) {
            array_push($data, count($redeem));
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
