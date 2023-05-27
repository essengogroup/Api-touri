<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationSiteRequest;
use App\Http\Resources\ReservationSiteResource;
use App\Models\Activite;
use App\Models\ReservationSite;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationSiteController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
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
        $reservationSites = $query->with('site', 'user', 'activites')->get();

        return $this->sendResponse(
            data: ReservationSiteResource::collection($reservationSites),
            message: 'ReservationSites found successfully'
        );
    }

    public function store(StoreReservationSiteRequest $request): JsonResponse
    {
        $data = $request->validated();
        $site = Site::query()->find($request->site_id);
        if (!$site) {
            return $this->sendError(error: 'Site not found', code: 404);
        }
        $price = 0;
        if ($request->has('activites') && count($request->activites) > 0) {
            $activites = Activite::query()->whereIn('id', $request->activites)->get();
            if ($activites->count() !== count($request->activites)) {
                return $this->sendError(error: 'Activite not found', code: 404);
            }

            $activites->each(function ($activite) use ($price, $site, &$data) {
//                if ($activite->pivot->type === 'obligatoire') {
//                    $data['price'] = (int)($data['price'] + $activite->pivot->price);
//                }
                $price += (int)$activite->price;
            });
        }
        $data['price'] = (int)($site->price + $price);
        if ($request->nb_personnes > 1) {
            $data['price'] = (int)($data['price'] * $request->nb_personnes);
        }
        $reservationSite = ReservationSite::create($data);
        $reservationSite->activites()->attach($request->activites);

        return $this->sendResponse(
            data: new ReservationSiteResource($reservationSite),
            message: 'ReservationSite created successfully'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $reservationSite = ReservationSite::query()
            ->with('site', 'user', 'activites')
            ->find($id);
        if (!$reservationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        return $this->sendResponse(
            data: new ReservationSiteResource($reservationSite),
            message: 'ReservationSite found successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $revervationSite = ReservationSite::query()->find($id);
        if (!$revervationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        $revervationSite->delete();
        return $this->sendResponse(
            data: null,
            message: 'ReservationSite deleted successfully'
        );
    }

    public function getReservationSiteByUser(int $id): JsonResponse
    {
        $reservationSites = ReservationSite::query()
            ->where('user_id', $id)
            ->with('site', 'user', 'activites')
            ->get();
        return $this->sendResponse(
            data: ReservationSiteResource::collection($reservationSites),
            message: 'ReservationSites found successfully'
        );
    }

    public function cancel(int $id): JsonResponse
    {
        $reservationSite = ReservationSite::query()
            ->where('id', $id)
            ->where('status', 'pending')
            ->first();
        if (!$reservationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        $reservationSite->update(['status' => 'canceled']);
        return $this->sendResponse(
            data: null,
            message: 'ReservationSite canceled successfully'
        );
    }

    public function pay(int $id): JsonResponse
    {
        $reservationSite = ReservationSite::query()
            ->where('id', $id)
            ->where('status', 'accepted')
            ->first();
        if (!$reservationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        $reservationSite->update(['status' => 'paid', 'is_paid' => true]);
        return $this->sendResponse(
            data: null,
            message: 'ReservationSite paid successfully'
        );
    }

    public function validated(int $id): JsonResponse
    {
        $reservationSite = ReservationSite::query()
            ->where('id', $id)
            ->where('status', 'pending')
            ->first();
        if (!$reservationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        $reservationSite->update(['status' => 'accepted']);
        return $this->sendResponse(
            data: null,
            message: 'ReservationSite validated successfully'
        );
    }

    public function refused(int $id): JsonResponse
    {
        $reservationSite = ReservationSite::query()
            ->where('id', $id)
            ->where('status', 'pending')
            ->first();
        if (!$reservationSite) {
            return $this->sendError(error: 'ReservationSite not found', code: 404);
        }
        $reservationSite->update(['status' => 'refused']);
        return $this->sendResponse(
            data: null,
            message: 'ReservationSite refused successfully'
        );
    }
    // TODO: add activite to reservationSite
    /*
    public function addActivite(Request $request, int $id):  \Illuminate\Http\JsonResponse
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->activites()->attach($request->activite_id);
        return response()->json([
            'message' => 'Activite added successfully',
        ]);
    }*/

    // TODO: remove activite from reservationSite
    /*
    public function removeActivite(Request $request, int $id):  \Illuminate\Http\JsonResponse
    {
        $reservationSite = ReservationSite::findOrFail($id);
        $reservationSite->activites()->detach($request->activite_id);
        return response()->json([
            'message' => 'Activite removed successfully',
        ]);
    }
    */
}
