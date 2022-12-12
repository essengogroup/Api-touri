<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationSiteRequest;
use App\Http\Resources\ReservationSiteResource;
use App\Models\Activite;
use App\Models\ReservationSite;
use App\Models\Site;
use Illuminate\Http\Request;

class ReservationSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->paginate();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]);
    }

    public function store(StoreReservationSiteRequest $request)
    {
        $data = $request->validated();
        $site = Site::findOrFail($request->site_id);
        if ($request->nb_personnes > 1) {
            $data['price'] = (int) ($site->price * $request->nb_personnes);
        } else {
            $data['price'] = (int) ($site->price);
        }
        // if ($request->has('activites')) {
        collect($request->activites)->each(function ($activite_id) use ($site, &$data) {
            $activite = $site->activites()->findOrFail($activite_id);

            if ($activite->pivot->type === 'optionnel') {
                $data['price'] = (int) ($data['price'] + $activite->pivot->price);
            }
        });
        // }
        // create reservationSite
        $reservationSite = ReservationSite::create(collect($data)->except('activites')->toArray());

        $activiteSite = $site->activites()->get();
        $activiteSite->each(function ($activite) use ($reservationSite, $request) {
            if ($activite->pivot->type === 'obligatoire') {
                $reservationSite->activites()->attach($activite->id);
            }
            if ($activite->pivot->type === 'optionnel') {
                $activiteRequest = collect($request->activites)->contains($activite->id);
                if ($activiteRequest) {
                    $reservationSite->activites()->attach($activite->id);
                }
            }
        });

        return response()->json([
            'message' => 'ReservationSite created successfully',
            'data' => new ReservationSiteResource($reservationSite)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservationSite = ReservationSite::with('site', 'user', 'siteDate', 'activites')->findOrFail($id);
        return response()->json([
            'message' => 'ReservationSite found successfully',
            'data' => new ReservationSiteResource($reservationSite)
        ]);
    }

    public function getReservationSiteByUser($id)
    {
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->where('user_id', $id)->paginate();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]);
    }

    public function cancel($id)
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->update(['status' => 'canceled']);
        return response()->json([
            'message' => 'ReservationSite canceled successfully'
        ]);
    }

    public function pay($id)
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->update(['is_paid' => true]);
        return response()->json([
            'message' => 'ReservationSite paid successfully',
        ]);
    }

    public function validated($id)
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->update(['status' => 'validated']);
        return response()->json([
            'message' => 'ReservationSite validated successfully',
        ]);
    }
}
