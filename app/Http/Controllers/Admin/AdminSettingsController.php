<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings_loc;
use Illuminate\Http\Request;

use App\Http\Requests\SettingsRequest;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Settings;
use App\Models\Languages;
use Session;
use File;

class AdminSettingsController extends AdminBaseController
{

    public function main(){
        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $languages = Languages::select('name','lang as id')->get()->toArray();

        $settings = json_encode(Settings::leftJoin('settings_loc', 'settings.id', '=', 'settings_loc.setting_id')
            ->whereIn('settings_loc.lang', [$lang,'ru'])
            ->select('settings.*','settings_loc.lang','settings_loc.slogan','settings_loc.address','settings_loc.copy')
            ->first());

        return view('admin.settings.main', [
            'title'     => 'Общие настройки',
            'settings'  => $settings,
            'languages'     => json_encode($languages),
        ]);
    }

    public function get_lang_settings(Request $request){
//dd($request->all());
        Session::put('alang',$request->lang);

        $flag = Settings_loc::whereLang($request->lang)->where('setting_id', 1)->first();

        if(!$flag){
            $lang = 'ru';
        }
        else {
            $lang = $flag->lang;
        }

        $settings = json_encode(Settings::leftJoin('settings_loc', 'settings.id', '=', 'settings_loc.setting_id')
            ->where('settings_loc.lang', $lang)
            ->select('settings.*','settings_loc.lang','settings_loc.slogan','settings_loc.address','settings_loc.copy')
            ->first());

        return $settings;
    }

    public function Update( Request $request ){

        $settings = Settings::whereId(1)->update([
            'email'         => $request->email,
            'phone'         => $request->phone,
            'speed_slider'  => $request->speed_slider
        ]);

        if ($request->logo1) {
            /*Удаляем старую картинку*/
            $logo1 = Settings::whereId(1)->select('logo')->first();
            $path = 'uploads/layout/';
            if (File::exists($path.$logo1->logo)) {
                File::delete($path.$logo1->logo);
            }
            /*Создаем новую*/
            $new_logo1 = Settings::saveLogo($request->logo1);
            if ($new_logo1){
                Settings::whereId(1)->update(['logo' => $new_logo1]);
            }
        }
        if ($request->logo2) {
            /*Удаляем старую картинку*/
            $logo2 = Settings::whereId(1)->select('logo2')->first();
            $path = 'uploads/layout/';
            if (File::exists($path.$logo2->logo2)) {
                File::delete($path.$logo2->logo2);
            }
            /*Создаем новую*/
            $new_logo2 = Settings::saveLogo($request->logo2);
            if ($new_logo2){
                Settings::whereId(1)->update(['logo2' => $new_logo2]);
            }
        }

        if($request->make == 'create'){/*Сохранение страницы на новом языку*/
            $name_lang = Languages::whereLang($request->lang)->first()->name;
            $success = 'Создана копия страницы на языку: '.$name_lang.'!';
            Settings_loc::create([
                'setting_id'    => 1,
                'lang'          => $request->lang,
                'slogan'        => $request->slogan,
                'copy'          => $request->rights,
            ]);
        }
        elseif($request->make == 'update'){/*Обновление на текущем языку*/
            $success = 'Страница успешно обновлена!';
            Settings_loc::where('setting_id',1)->where('lang',$request->lang)->update([
                'slogan'        => $request->slogan,
                'copy'          => $request->rights,
            ]);
        }
        return redirect()->back()->with('success',$success);
    }
}
