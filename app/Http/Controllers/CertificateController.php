<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendCertificateRequest;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Repositories\V1\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Jambasangsang\Flash\Facades\LaravelFlash;

class CertificateController extends Controller
{
    protected $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    public function preview()
    {
        // $data =  $this->certificateRepository->getMetaData();
        // return view('jambasangsang.backend.certificate.index', compact('data'));
        return view('emails.course_enrollment');
    }


    /**
     * Display Student Certificate.
     *
     * @param Request $request
     * @param User $student
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function student_certificate(Request $request, User $student, Course $course)
    {
        if (hasCertificate($student, $course, $student->courses()->where('courses.id', $course->id)->first()->pivot ?? null)) {
            try {
                $refresh = $request->get('refresh') ?? false;
                $certificate = $this->certificateRepository->generateCertificate(true, $refresh, $student, $course);
                $user = $student;

                return view('jambasangsang.backend.users.student_certificate', compact('user', 'course', 'certificate'));
            } catch (\Throwable $th) {
                LaravelFlash::withError($th->getMessage());
                return back();
            }
        } else {
            LaravelFlash::withError('OPPS! You cannot access certificate for this course');
            return back();
        }
    }


    /**
     * Download the certificate.
     *
     * @param Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function download(Certificate $certificate)
    {
        $data = $this->certificateRepository->getFormattedCertificate($certificate);

        // Check if certificate is revoked
        if ($data['is_revoked']) {
            LaravelFlash::withWarning('This certificate has been revoked. Please contact admin');
            return back();
        }

        $certificateContent = $this->getCertificateContent($data);

        if ($certificateContent !== null) {
            // Increment download count
            $certificate->downloaded();

            return response($certificateContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $data['name'] . '"');
        } else {
            LaravelFlash::withError('Failed to download certificate');
            return back();
        }
    }

    /**
     * Show modal to send certificate via email.
     *
     * @param Request $request
     * @param Certificate $certificate
     * @return \Illuminate\View\View
     */
    public function send(Request $request, Certificate $certificate)
    {
        $student = $request->has('user')
            ? User::whereSlug($request->get('user'))->first()
            : (auth()->user()->isStudent() ? auth()->user() : null);

        $variables = collect([
            'type' => 'certificate',
            'title' => 'Send',
            'file' => 'backend.certificate.partials.send'
        ]);

        return view('components.partials.general-modal', compact('variables', 'certificate', 'student'))->render();
    }

    /**
     * Send certificate via email.
     *
     * @param SendCertificateRequest $request
     * @param Certificate $certificate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendToMail(SendCertificateRequest $request, Certificate $certificate)
    {
        $data = $this->certificateRepository->getFormattedCertificate($certificate);

        // Check if certificate is revoked
        if ($data['is_revoked']) {
            LaravelFlash::withWarning('This certificate has been revoked. Please contact admin');
            return back();
        }

        try {
            $certificateContent = $this->getCertificateContent($data);

            if ($certificateContent !== null) {

                $emails = $this->getEmailAddress($request->validated());

                foreach ($emails as $email) {
                    Mail::send([], [], function ($message) use ($certificateContent, $data, $email) {
                        $message->to($email)
                            ->subject(config('app.name') . ' Certificate')
                            ->attachData($certificateContent, $data['name']);
                    });
                }

                LaravelFlash::withSuccess('Email sent successfully');

                return back();
            } else {
                LaravelFlash::withError('Failed to send certificate to mail');
                return back();
            }
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }


    /**
     * Revoke the certificate.
     *
     * @param Certificate $certificate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revoke(Certificate $certificate)
    {
        $message = 'Certificate ' . ($certificate->is_revoked ? 'Activated' : 'Revoked') . ' Successfully!';
        try {
            $certificate->revoke_cert();

            LaravelFlash::withSuccess($message);
            return back();
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    private function getCertificateContent($data)
    {
        try {
            $response = Http::get($data['path']);

            if ($response->successful()) {
                return $response->body();
            } else {
                LaravelFlash::withError('Failed to download certificate');
            }
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
        }

        return null;
    }

    private function getEmailAddress($data)
    {
        $emails = [];

        if ($data['user_id']) {
            $student = User::find($data['user_id']);
            $emails[] = $student->email;
        }

        if ($data['external_email']) {
            $emails[] = $data['external_email'];
        }

        return $emails;
    }
}
