<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Web\NetworkReviewModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewsController extends Controller
{
    // listing NetworkReview
    public function index(Request $request, AdminController $ac)
    {
        if ($request->ajax()) {
            // Get all_reviews
            $data = $ac->get_all_reviews();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'reviewslist/' . $row->review_id . '/edit';
                    $deleteUrl = 'reviewslist/' . $row->review_id;
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = '<div style="display: flex;
                    margin-left: 5px;">' . "<a href=" . $editUrl . " class='edit btn btn-primary btn-sm' style='height: 31px;'></i>Edit</a>" .
                        $form .
                        '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.reviews.index_reviews');
    }
    // function for edit NetworkReview
    public function edit(string $review_id)
    {
        $data = [];
        $data['reviewslist'] = NetworkReviewModel::find($review_id);

        if (!$data) {
            return ['success' => false, 'msg' => 'reviews not Found !!!'];
        }
        $data['review_id'] = $review_id;

        return view('Admin.reviews.update_reviews', $data);
    }
    // function for update NetworkReview
    public function update(Request $request, string $review_id)
    {
        $validated = $request->validate([
            'network_id' =>  'required',
            'user_id' =>  'required',
            'all_rating' =>  'min:0|max:5',
            'offer_rating' =>  'min:0|max:5',
            'payout_rating' =>  'min:0|max:5',
            'tracking_rating' =>  'min:0|max:5',
            'support_rating' => 'min:0|max:5',
            'review_text' => 'required',
        ]);

        $reviews = NetworkReviewModel::find($review_id);
        // When data not found
        if (!$reviews) {
            return ['success' => false, 'msg' => 'reviews not Found !!!'];
        }
        // When data found
        $reviews->network_id = $request->input('network_id');
        $reviews->user_id = $request->input('user_id');
        $reviews->all_rating = $request->input('all_rating');
        $reviews->offer_rating = $request->input('offer_rating');
        $reviews->payout_rating = $request->input('payout_rating');
        $reviews->tracking_rating = $request->input('tracking_rating');
        $reviews->support_rating = $request->input('support_rating');
        $reviews->review_text = $request->input('review_text');
        $reviews->status = $request->input('status');
        $reviews->save();
        return redirect('admin/reviewslist')->with('message', 'Your data successfully updated');
    }
    // function for destroy NetworkReview
    public function destroy(string $review_id)
    {
        $reviews = NetworkReviewModel::find($review_id);
        // dd($reviews);
        // When data not found
        if (!$reviews) {
            return ['success' => false, 'msg' => 'reviews not Found !!!'];
        }
        // When data found
        $reviews->delete();
        return redirect('admin/reviewslist')->with('message', 'Your data successfully deleted');
    }
    // Get reviews bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                NetworkReviewModel::whereIn('review_id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
