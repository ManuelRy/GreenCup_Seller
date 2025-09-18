<?php

namespace App\Http\Controllers;

use App\Repository\FileRepository;
use App\Repository\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    private ReportRepository $rRepo;
    private FileRepository $fRepo;

    public function __construct(ReportRepository $rRepo, FileRepository $fRepo)
    {
        $this->rRepo = $rRepo;
        $this->fRepo = $fRepo;
    }

    public function index()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to view reports.');
        }

        $reports = $this->rRepo->getByReporterId($seller->id);
        return view('report.index', compact('reports'));
    }

    public function create()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to create reports.');
        }

        return view('report.create');
    }

    public function store(Request $request)
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to create reports.');
            }

            $request->validate([
                'title' => 'required|string|max:100',
                'priority' => 'required|string', // adjust values to match Report::$priorities
                'tag' => 'required|string|max:50',
                'description' => 'required|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB = 5120KB
            ], [
                'image.max' => 'The image size must not exceed 5MB.',
                'image.image' => 'The uploaded file must be a valid image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            ]);

            $report = $this->rRepo->create([
                'title'        => $request->title,
                'priority'     => $request->priority,
                'tag'           => $request->tag,
                'description'  => $request->description,
                'reporter_id'  => $seller->id, // Use seller ID instead of Auth::id()
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                $response = $this->fRepo->upload($file);
                // dd($response);
                if ($response->successful()) {
                    $data = $response->json();

                    $this->rRepo->createEvidence([
                        'report_id' => $report->id,
                        'file_url'  => $this->fRepo->get($data['path'] ?? null),
                    ]);
                }
            }

            return redirect()->route('report.index')->with('success', 'Report created successfully!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong while submitting your report. Please try again.'])->withInput();
        }
    }
}
