<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CertificateService
{
    /**
     * Issue a new certificate for a facility.
     */
    public function issueCertificate(int $hospitalId, int $userId)
    {
        $certificateNo = $this->generateCertificateNumber($hospitalId);
        $issueDate = Carbon::now()->toDateString();
        $expiryDate = Carbon::now()->addYears(2)->toDateString(); // 2-year validity

        return DB::table('hs_facility_certificates')->insert([
            'hospital_id' => $hospitalId,
            'certificate_no' => $certificateNo,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'issued_by' => $userId,
            'status' => 'valid',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Generate a unique certificate number.
     */
    private function generateCertificateNumber(int $hospitalId): string
    {
        return 'HFR-CERT-' . $hospitalId . '-' . time();
    }

    /**
     * Get certificate details for a facility.
     */
    public function getCertificate(int $hospitalId)
    {
        return DB::table('hs_facility_certificates')
            ->where('hospital_id', $hospitalId)
            ->where('status', 'valid')
            ->first();
    }
}
