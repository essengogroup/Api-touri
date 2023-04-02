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
    public function index(Request $request)
    {
        // CREATE A QUERY BUILDER
        $query = ReservationSite::query();

        /* FILTERS */

        // FILTER BY SITE
        if ($request->has('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        // FILTER BY SITE DATE
        if ($request->has('site_date_id')) {
            $query->where('site_date_id', $request->site_date_id);
        }

        // FILTER BY IS PAID
        if ($request->has('is_paid')) {
            $query->where('is_paid', $request->is_paid);
        }
        // FILTER BY DATE
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }
        // FILTER BY DATE RANGE
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        // FILTER BY PRICE
        if ($request->has('price_from') && $request->has('price_to')) {
            $query->whereBetween('price', [$request->price_from, $request->price_to]);
        }
        // FILTER BY NB PERSONNES
        if ($request->has('nb_personnes_from') && $request->has('nb_personnes_to')) {
            $query->whereBetween('nb_personnes', [$request->nb_personnes_from, $request->nb_personnes_to]);
        }
        // FILTER BY COMMENTAIRE
        if ($request->has('commentaire')) {
            $query->where('commentaire', 'like', '%' . $request->commentaire . '%');
        }
        // FILTER BY ACTIVITE
        if ($request->has('activite_id')) {
            $query->whereHas('activites', function ($query) use ($request) {
                $query->where('activite_id', $request->activite_id);
            });
        }
        // FILTER BY ACTIVITE TYPE
        if ($request->has('activite_type')) {
            $query->whereHas('activites', function ($query) use ($request) {
                $query->where('type', $request->activite_type);
            });
        }
        // FILTER BY ACTIVITE NAME
        if ($request->has('activite_name')) {
            $query->whereHas('activites', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->activite_name . '%');
            });
        }

        // FILTER BY USER ID
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        // FILTER BY STATUS
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }


        // PAGINATE
        $reservationSites = $query->with('site', 'user', 'siteDate', 'activites')->get();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]);
        /*
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->paginate();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]); */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getReservationSiteByUser($id)
    {
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->where('user_id', $id)->get();
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
        $reservationSite->update(['status' => 'accepted']);
        return response()->json([
            'message' => 'ReservationSite validated successfully',
        ]);
    }

    public function refused($id)
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->update(['status' => 'refused']);
        return response()->json([
            'message' => 'ReservationSite refused successfully',
        ]);
    }

    public function getReservationSiteBySite($id)
    {
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->where('site_id', $id)->get();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]);
    }

    public function getReservationSiteBySiteDate($id)
    {
        $reservationSites = ReservationSite::with('site', 'user', 'siteDate', 'activites')->where('site_date_id', $id)->get();
        return response()->json([
            'message' => 'ReservationSites found successfully',
            'data' => ReservationSiteResource::collection($reservationSites)
        ]);
    }
    /*
    public function addActivite(Request $request, int $id):  \Illuminate\Http\JsonResponse
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->activites()->attach($request->activite_id);
        return response()->json([
            'message' => 'Activite added successfully',
        ]);
    }

    public function removeActivite(Request $request, int $id):  \Illuminate\Http\JsonResponse
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->activites()->detach($request->activite_id);
        return response()->json([
            'message' => 'Activite removed successfully',
        ]);
    } */
}
