<?php


namespace App\Repositories\V1;

use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class CertificateRepository
{

    /**
     * Generates a certificate.
     *
     * @param bool $preview
     * @param mixed $student
     * @param mixed $course
     * @return array
     */
    public function generateCertificate($preview = false, $refresh = false, $student = null, $course = null): array
    {
        // Get meta data for certificate
        $data = $this->getMetaData($student, $course);

        // Get old certificate if it exists
        $old_certificate = $this->getOldCertificate($student, $course, $data);

        if ($preview && !$refresh && $old_certificate) {
            return $this->getFormattedCertificate($old_certificate);
        }

        // Delete old certificate from storage
        $this->deleteOldCertificate($old_certificate);

        // Define path for certificate
        $directory = 'jambasangsang/assets/certificates';
        $path = $directory . '/' . $data['filename'];

        // Generate PDF
        $pdf = $this->generatePdf($data);

        // Store PDF
        $data['path'] = $this->storePdf($path, $pdf);

        // Save certificate in database
        $certificate = $this->saveCertificate($data, $student, $course);

        // Get formatted certificate data
        return $this->getFormattedCertificate($certificate);
    }

    /**
     * Gets data for certificate.
     *
     * @param mixed $student
     * @param mixed $course
     * @param array $data
     * @return mixed
     */
    public static function getMetaData($student = null, $course = null)
    {
        $faker = Faker::create();

        $name = $student ? "{$student->name} {$student->lname}" : $faker->name;
        $courseTitle = $course ? $course->title : $faker->words($nb = 3, $asText = true);
        $filename = $student && $course ? strtolower(str_replace([' ', '.'], '-', "{$student->name}-{$course->slug}")) : 'preview';
        $filename = $filename . '-certificate.pdf';
        $issueDate = now();

        return compact('name', 'courseTitle', 'issueDate', 'filename');
    }

    /**
     * Gets the old certificate.
     *
     * @param mixed $student
     * @param mixed $course
     * @param array $data
     * @return mixed
     */
    private function getOldCertificate($student, $course, array $data)
    {
        return $student ? $student->certificates()->where('course_id', $course->id)->first() : Certificate::whereName($data['filename'])->first();
    }

    /**
     * Deletes the old certificate from storage.
     *
     * @param bool $preview
     * @param mixed $old_certificate
     */
    private function deleteOldCertificate($old_certificate)
    {
        if ($old_certificate && Storage::disk(config('filesystems.default'))->exists($old_certificate->path)) {
            Storage::disk(config('filesystems.default'))->delete($old_certificate->path);
        }
    }

    /**
     * Generates the PDF.
     *
     * @param array $data
     * @return mixed
     */
    private function generatePdf(array $data)
    {
        return Pdf::loadView('jambasangsang.backend.certificate.index', compact('data'))
            ->setPaper('a4', 'landscape')
            ->setOption([
                'fontDir' => public_path('pdf-fonts'),
                'defaultFont' => 'Montserrat',
                'margin-top' => 0
            ]);
    }

    /**
     * Stores the PDF.
     *
     * @param string $path
     * @param mixed $pdf
     * @return string
     */
    private function storePdf(string $path, $pdf): string
    {
        $disk = config('filesystems.default');
        Storage::disk($disk)->put($path, $pdf->output());

        return $disk === 'local' ? $path : Storage::disk('s3')->url($path);
    }

    /**
     * Saves the certificate in the database.
     *
     * @param array $data
     * @param mixed $student
     * @param mixed $course
     * @return mixed
     */
    private function saveCertificate(array $data, $student = null, $course = null)
    {
        return Certificate::updateOrCreate(
            ['name' =>  $data['filename']],
            [
                'user_id' => $student ? $student->id : null,
                'course_id' => $course ? $course->id : null,
                'path' => $data['path'],
            ]
        );
    }

    /**
     * Gets a formatted certificate array.
     *
     * @param Certificate $certificate
     * @return array
     */
    public function getFormattedCertificate(Certificate $certificate)
    {
        return [
            'id' => $certificate->id,
            'name' => $certificate->name,
            'path' => !filter_var($certificate->path, FILTER_VALIDATE_URL) ? asset($certificate->path) : $certificate->path,
            'downloads' => $certificate->downloads,
            'is_revoked' => (bool) $certificate->is_revoked,
        ];
    }
}
