<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GlobalSettingController extends Controller
{
    /**
     * Display a global settings
     */
    public function globalSettings()
    {
        $pageOptions = [
            'title' => 'Global Settings',
            'actionUrl' => route('globalSettingsUpdate'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('globalSettings')
        ];
        return view('pages.apps.globalSettings.form', $pageOptions);
    }

    /**
     * Update Global Settings
     */
    public function globalSettingsUpdate(Request $request)
    {
        try {
            foreach ($request->except('_token')['key'] as $getMetaKey => $getMetaValue) {
                foreach ($getMetaValue as $getMetaValue_key => $getMetaValue_value){
                    if ($getMetaKey === 'FILE') {
                        $fileGetFileExtension = $getMetaValue_value->getClientOriginalExtension();
                        $fileName = Str::random(20) . '_' . date('d_m_Y_h_i_s') . '.' . $fileGetFileExtension;
                        Storage::disk('public')->put('media/' . $fileName, File::get($getMetaValue_value));
                        $getMetaValue_value = $fileName;
                    }
                    GlobalSetting::updateOrCreate([
                        'key'          => $getMetaValue_key,
                        'type'         => $getMetaKey
                    ],[
                        'value'        => $getMetaValue_value,
                    ]);
                }
            }
            return redirect()->route('globalSettings')->with('success', 'Global Settings successfully');
        } catch (Exception $exception) {
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : ' . __CLASS__);
            Log::info('METHOD : ' . __METHOD__);
            Log::info('FUNCTION : ' . __FUNCTION__);
            Log::info('DIRECTORY : ' . __DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION', [
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ]);
            return redirect()->route('globalSettings')->with('error', $exception->getMessage());
        }
    }
}
