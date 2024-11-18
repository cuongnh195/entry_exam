<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateHotelRequest;
use App\Http\Requests\Admin\UpdateHotelRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Services\HotelService;
use App\Services\PrefectureService;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    private $hotelService;
    private $prefectureService;

    public function __construct(
        HotelService $hotelService,
        PrefectureService $prefectureService
    ) {
        $this->hotelService = $hotelService;
        $this->prefectureService = $prefectureService;
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

    /**
     * Show edit page
     *
     * @param int $hotelId
     * @return View
     */
    public function showEdit(int $hotelId): View
    {
        $prefectures = $this->prefectureService->all();
        $hotel = $this->hotelService->getHotelDetail($hotelId);
        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }

    /**
     * Show create page
     *
     * @return View
     */
    public function showCreate(): View
    {
        $prefectures = $this->prefectureService->all();

        return view('admin.hotel.create', compact('prefectures'));
    }


    /**
     * Search result
     *
     * @param Request $request
     * @return View
     */
    public function searchResult(Request $request): View
    {
        $hotelNameToSearch = $request->input('hotel_name');
    
        if (empty($hotelNameToSearch)) {
            return view('admin.hotel.result')->with('errorMessage', __('messages.hotel_search_error'));
        }
        $var = [];
        $var['hotelList'] = $this->hotelService->searchHotel($hotelNameToSearch);
        return view('admin.hotel.result', $var);
    }

    /**
     * Update a hotel
     *
     * @param UpdateHotelRequest $request
     */
    public function edit(UpdateHotelRequest $request, int $hotelId)
    {
        try {
            $this->hotelService->updateHotel($request->validated(), $hotelId);

            return redirect()->route('adminHotelSearchPage')
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

            return redirect()->route('adminHotelSearchPage')
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
            
            return redirect()->route('adminHotelSearchPage')
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
