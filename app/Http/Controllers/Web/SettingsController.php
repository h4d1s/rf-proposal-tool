<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/settings/edit');
    }

    public function edit(Request $request) 
    {
        $this->authorize('viewAny', Setting::class);

        $team_id = $request->user()->team->id;
        $settings = Setting::forTeam($team_id)->get();
        return view("settings.edit", compact("settings"));
    }

    public function update(UpdateSettingRequest $request) 
    {
        $this->authorize('viewAny', Setting::class);

        $team = $request->user()->team;
        $validated = $request->safe();

        if($request->filled("currency")) {
            $query = Setting::where("key", "currency")
                ->where("team_id", $team->id);

            if($query->exists()) {
                $currency_setting = $query->first();
                $currency_setting->value = $validated["currency"];
                $currency_setting->save();
            } else {
                $currency_setting = Setting::make([
                    "key" => "currency",
                    "value" => $validated["currency"]
                ]);
                $currency_setting->team()->associate($team);
                $currency_setting->save();
            }
        }

        if($request->filled("stripe_publishable_key")) {
            $query = Setting::where("key", "stripe_publishable_key")
                ->where("team_id", $team->id);

            if($query->exists()) {
                $stripe_publishable_key_setting = $query->first();
                $stripe_publishable_key_setting->value = $validated["stripe_publishable_key"];
                $stripe_publishable_key_setting->save();
            } else {
                $stripe_publishable_key_setting = Setting::make([
                    "key" => "stripe_publishable_key",
                    "value" => $validated["stripe_publishable_key"]
                ]);
                $stripe_publishable_key_setting->team()->associate($team);
                $stripe_publishable_key_setting->save();
            }
        }

        if($request->filled("stripe_secret_key")) {
            $query = Setting::where("key", "stripe_secret_key")
                ->where("team_id", $team->id);

            if($query->exists()) {
                $stripe_secret_key_setting = $query->first();
                $stripe_secret_key_setting->value = $validated["stripe_secret_key"];
                $stripe_secret_key_setting->save();
            } else {
                $stripe_secret_key_setting = Setting::make([
                    "key" => "stripe_secret_key",
                    "value" => $validated["stripe_secret_key"]
                ]);
                $stripe_secret_key_setting->team()->associate($team);
                $stripe_secret_key_setting->save();
            }
        }

        return back()
            ->with('status', __('Settings updated!'));
    }
}
