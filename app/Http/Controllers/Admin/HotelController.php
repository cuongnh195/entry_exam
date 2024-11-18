<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateHotelRequest;
use App\Http\Requests\Admin\UpdateHotelRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Services\HotelService;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    protected $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /** get methods */
    public function showSearch(): View
    {
        return view('admin.hotel.search');
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit(): View
    {
        return view('admin.hotel.edit');
    }

    public function showCreate(): View
    {
        return view('admin.hotel.create');
    }

    /** post methods */

    public function searchResult(Request $request): View
    {
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    /**
     * Update a hotel
     *
     * @param UpdateHotelRequest $request
     */
    public function edit(UpdateHotelRequest $request)
    {
        try {
            $this->hotelService->updateHotel($request->validated(), $request->input('hotel_id'));

            return redirect()->route('admin.hotel.index')
                ->with('success', __('messages.hotel_updated_success'));
        } catch (\Exception $e) {
            Log::error(__('messages.hotel_update_error') . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => __('messages.hotel_update_error')]);
        }
    }

    /**
     * Create a new hotel
     *
     * @param CreateHotelRequest $request
     */
    public function create(CreateHotelRequest $request)
    {
        try {
            $this->hotelService->createHotel($request->validated());

            return redirect()->route('admin.hotel.index')
                ->with('success', __('messages.hotel_created_success'));
        } catch (\Exception $e) {
            Log::error(__('messages.hotel_creation_error') . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => __('messages.hotel_creation_error')]);
        }
    }

    /**
     * Delete a hotel
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        try {
            $this->hotelService->deleteHotel($request->input('hotel_id'));
            
            return redirect()->route('admin.hotel.index')
                ->with('success', __('messages.hotel_deleted_success'));
        } catch (\Exception $e) {
            Log::error(__('messages.hotel_deletion_error') . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => __('messages.hotel_deletion_error')]);
        }
    }

    /**
     * Get hotel detail
     *
     * @param int $hotelId
     */
    public function getHotelDetail(int $hotelId): View
    {
        try {
            $hotel = $this->hotelService->getHotelDetail($hotelId);

            return view('admin.hotel.detail', compact('hotel'));
        } catch (\Exception $e) {
            Log::error(__('messages.hotel_detail_error') . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => __('messages.hotel_detail_error')]);
        }
    }
}
