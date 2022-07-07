<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Models\Setting;
use App\Http\Controllers\BaseController;

class SettingController extends BaseController
{

    use UploadAble;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('admin.settings.index');
    }
    /**
     * @param Request $request
     */
    public function update(Request $request)
    {

        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {
            $site_logo = 1;
        } else {
            $site_logo = 0;
        }
        if ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {
            $site_favicon = 1;
        } else {
            $site_favicon = 0;
        }

        if ($site_logo == 1 || $site_favicon == 1) {
        }

        $site_logo = $site_favicon = 0;

        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {
            $site_logo = 1;
        }
        if ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {
            $site_favicon = 1;
        }

        if ($site_logo == 1 || $site_favicon == 1) {

            if ($site_logo == 1) {
                // dd($request->file('site_logo'));
                if (config('settings.site_logo') != null) {
                    $this->deleteOne(config('settings.site_logo'));
                }
                $logo = $this->uploadOne($request->file('site_logo'), 'img');
                Setting::set('site_logo', $logo);
            }
            if ($site_favicon == 1) {

                if (config('settings.site_favicon') != null) {
                    $this->deleteOne(config('settings.site_favicon'));
                }
                $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
                Setting::set('site_favicon', $favicon);
            }
        } else {

            $keys = $request->except('_token');

            foreach ($keys as $key => $value) {
                Setting::set($key, $value);
            }
        }
        return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }
}
