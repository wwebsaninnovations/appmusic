<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Support\Facades\Auth;
class SearchController extends Controller
{
    public function search(Request $request)
    {

        $user_id = Auth::user()->id;
        $keyword = $request->input('keyword');

     
        // Query to filter releases based on the keyword
        $releases = Release::where('user_id', $user_id)
        ->where('format', 'LIKE', "%$keyword%")
        ->with('tracks')
        ->orderBy('created_at', 'desc')
        ->get();


        $html = '';
        foreach ($releases as $release) {
            $html .= '<div class="col-md-4">';
            $html .= '<div class="release-card">';
            $html .= '<div class="wrap-image">';
            $html .= '<img src="' . ($release->thumbnail_path ? asset('storage/' . $release->thumbnail_path) : 'https://via.placeholder.com/150') . '" alt="Thumbnail">';
            $html .= '</div>';
            $html .= '<div class="release-card-body">';
            $html .= '<div class="releast_heading">';
            $html .= '<div class="release-card-title">' . $release->format . '</div>';
            $html .= '<span class="release-card-status ' . ($release->form_status == 0 ? 'bg-warning' : 'bg-success') . '">';
            $html .= $release->form_status == 0 ? 'Incomplete' : 'Completed';
            $html .= '</span>';
            $html .= '</div>';
            $html .= '<div class="release-card-date">Created on: ' . $release->created_at->format('M d, Y') . '</div>';
            // Status badge
            $status = $release->status;
            $statusText = '';
            $badgeClass = '';
            switch ($status) {
                case 0:
                    $statusText = 'Pending';
                    $badgeClass = 'badge bg-warning';
                    break;
                case 1:
                    $statusText = 'Processing';
                    $badgeClass = 'badge bg-primary';
                    break;
                case 2:
                    $statusText = 'Rejected';
                    $badgeClass = 'badge bg-danger';
                    break;
                case 3:
                    $statusText = 'Approved';
                    $badgeClass = 'badge bg-success';
                    break;
                default:
                    $statusText = 'Unknown';
                    $badgeClass = 'badge bg-dark';
                    break;
            }
            $html .= '<span class="' . $badgeClass . '">' . $statusText . '</span>';
            // Actions
            $html .= '<div class="actions">';
            $html .= '<form action="' . route('releases.destroy', $release->id) . '" method="post">';
            $html .= csrf_field();
            $html .= method_field('DELETE');
            $html .= '<a href="' . route('releases.step2', ['release_id' => $release->id, 'level' => 'basic']) . '" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>';
            $html .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Do you want to delete this user?\');"><i class="bi bi-trash"></i> Delete</button>';
            $html .= '</form>';
            $html .= '</div>'; // End actions
            $html .= '</div>'; // End release-card-body
            $html .= '</div>'; // End release-card
            $html .= '</div>'; // End col-md-4
        }

        // If no releases found, add a message
        if ($html === '') {
            $html = '<div class="col-12"><span class="text-danger"><strong>No Releases Found!</strong></span></div>';
        }

        // Return the $html variable
        return response()->json(['html' => $html]);


    }
}
