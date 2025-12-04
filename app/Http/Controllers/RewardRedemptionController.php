<?php

namespace App\Http\Controllers;

use App\Models\RewardRedemption;
use App\Models\Reward;
use App\Models\User;
use App\Models\WasteType;
use App\Models\Transaction;
use App\Models\Location;
use Illuminate\Http\Request;

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

        // cek poin cukup
        if ($user->poin < $reward->p_dibutuhkan) {
            return back()->with('error', 'Poin Anda tidak cukup untuk hadiah ini.');
        }

        // kurangi poin & catat redeem
        $user->decrement('poin', $reward->p_dibutuhkan);
        $user->increment('total_poin', 0); // tetap 0 (total pernah didapat tidak naik)

        RewardRedemption::create([
            'id_user'        => $user->id_user,
            'id_hadiah'      => $reward->id_hadiah,
            'jumlah_hadiah'  => 1,
            'tanggal_tukar'  => now(),
            'status_tukar'   => 'pending',
            'nama_penerima'  => $request->nama_penerima,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_hp_penerima' => $request->no_hp_penerima,
        ]);

        return redirect()->route('user.points.index')->with('success', 'Hadiah berhasil ditukar! Silakan tunggu konfirmasi admin.');
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
    public function edit(RewardRedemption $rewardRedemption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RewardRedemption $rewardRedemption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RewardRedemption $rewardRedemption)
    {
        //
    }
}
