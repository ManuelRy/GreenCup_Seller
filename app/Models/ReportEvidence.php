<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\NormalizesRemoteUrl;

class ReportEvidence extends Model
{
  use NormalizesRemoteUrl;

  protected $table = "report_evidences";
  protected $fillable = [
    'report_id',
    'file_url',
  ];

  public function report()
  {
    return $this->belongsTo(Report::class);
  }

  public function getFileUrlAttribute($value): ?string
  {
    return $this->normalizeRemoteUrl($value);
  }
}
