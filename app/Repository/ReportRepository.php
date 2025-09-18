<?php

namespace App\Repository;

use App\Models\Report;
use App\Models\ReportEvidence;
use Illuminate\Database\Eloquent\Model;

class ReportRepository
{
  public function create($data = []): Model
  {
    return Report::create([...$data, 'reporter' => 'seller', 'status' => 'Investigate',]);
  }

  public function createEvidence($data = [])
  {
    return ReportEvidence::create($data);
  }

  public function getByReporterId($reporterId)
  {
    return Report::with('evidences')
                 ->where('reporter_id', $reporterId)
                 ->where('reporter', 'seller')
                 ->orderBy('created_at', 'desc')
                 ->paginate(10);
  }
}
