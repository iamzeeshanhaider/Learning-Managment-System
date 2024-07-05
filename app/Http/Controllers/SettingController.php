<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\V1\CertificateRepository;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Jambasangsang\Flash\Facades\LaravelFlash;

class SettingController extends Controller
{
    protected $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    public function index(Request $request)
    {
        $settings = Setting::all();
        $refresh = $request->get('refresh') ?? false;
        $certificate = $request->get('view') === 'certificate' ? $this->certificateRepository->generateCertificate(true, $refresh) : null;

        if ($refresh) {
            $request->query->remove('refresh');
            return redirect($request->fullUrlWithoutQuery('refresh'));
        } else {
            return view('jambasangsang.backend.settings.index', compact(['settings', 'certificate']));
        }
    }

    public function store(Request $request)
    {
        Gate::authorize('add_settings');

        foreach (Arr::except($request->settings, ['logo']) as $key => $value) {
            Setting::firstWhere('key', $key)->update([
                'value' => $value
            ]);
        }
        if (!empty($request->settings['logo'])) {

            $setting = Setting::where('key', 'logo')->first();
            $setting->value  = uploadLogo($request, $setting->value);

            $setting->save();
        }

        LaravelFlash::withSuccess('Settings Updated Successfully');
        return redirect()->route('settings.index');
    }
}
