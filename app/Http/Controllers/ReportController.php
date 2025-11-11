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

        $reports = $this->rRepo->getByReporterId(Auth::id());
        return view('report.index', compact('reports'));
    }

    public function create()
    {
        return view('report.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:100',
                'priority' => 'required|string', // adjust values to match Report::$priorities
                'tag' => 'required|string|max:50',
                'description' => 'required|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:102400', // 100MB = 102400KB
            ], [
                'image.max' => 'The image size must not exceed 100MB.',
                'image.image' => 'The uploaded file must be a valid image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            ]);

            Log::info('Report submission started', [
                'title' => $request->title,
                'has_file' => $request->hasFile('image'),
                'user_id' => Auth::id(),
            ]);

            $report = $this->rRepo->create([
                'title'        => $request->title,
                'priority'     => $request->priority,
                'tag'           => $request->tag,
                'description'  => $request->description,
                'reporter_id'  => Auth::id(),
            ]);

            Log::info('Report created in database', ['report_id' => $report->id]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                Log::info('Processing image upload', [
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);

                $response = $this->fRepo->upload('report_evidences', $file);
                
                Log::info('File upload response', [
                    'status' => $response->status(),
                    'successful' => $response->successful(),
                    'body' => $response->body(),
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    $this->rRepo->createEvidence([
                        'report_id' => $report->id,
                        'file_url'  => $data['path'] ?? null,
                    ]);

                    Log::info('Evidence created successfully', ['file_url' => $data['path'] ?? null]);
                } else {
                    Log::error('File upload failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    return back()->withErrors(['error' => 'Report created but image upload failed. Please try again or contact support.'])->withInput();
                }
            }

            return redirect()->route('report.index')->with('success', 'Report created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Report validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Throwable $th) {
            Log::error('Report submission error', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Something went wrong while submitting your report. Please try again.'])->withInput();
        }
    }
}
