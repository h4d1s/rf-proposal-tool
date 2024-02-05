<?php

namespace App\Http\Controllers\Web;

use App\Enums\ActivityType as EnumsActivityType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Client;
use App\Models\Company;
use App\Models\Country;
use App\Models\Proposal;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $sum = 0;
        $client = null;
        $proposal = null;
        $clientSecret = null;
        $countries = Country::all();

        if(!$request->filled("t")) {
            return abort(404);
        }

        $token = $request->query("t");

        $client = Client::whereHas("proposals", function($query) use ($token) {
            $query->where("token", $token);
        })->first();
        $company = Company::whereHas("proposals", function($query) use ($token) {
            $query->where("token", $token);
        })->first();

        if(is_null($client) && is_null($company)) {
            return abort(404);
        }

        $customer = null;
        $proposal = null;

        if(is_null($client)) {
            $customer = $company;
            $proposal = Proposal::whereHas("companies", function($query) use ($token) {
                $query->where("token", $token);
            })->first();
        } else {
            $customer = $client;
            $proposal = Proposal::whereHas("clients", function($query) use ($token) {
                $query->where("token", $token);
            })->first();
        }

        if(is_null($proposal)) {
            return abort(404);
        }

        $payment_client = $proposal->payments_clients()
            ->where("proposal_id", $proposal->id)
            ->where("paymentable_id", $customer->id)
            ->where("paymentable_type", $customer->getMorphClass())
            ->first();
        
        $payment_company = $proposal->payments_companies()
            ->where("proposal_id", $proposal->id)
            ->where("paymentable_id", $customer->id)
            ->where("paymentable_type", $customer->getMorphClass())
            ->first();

        if(!is_null($payment_client) || !is_null($payment_company)) {
            $payment = null;

            if(is_null($payment_client)) {
                $payment = $payment_company;
            } else {
                $payment = $payment_client;
            }
    
            $is_paid = $payment->pivot->is_paid;
    
            if($is_paid) {
                return view("checkout.payment-done");
            }
        }

        if($proposal->pricingTable) {
            $sum += $proposal->pricingTable->total;
        }
        if($proposal->products) {
            $sum += $proposal->products->sum("price");
        }

        // Stripe

        $team = $customer->team;
        $secret_key_query = Setting::where("key", "stripe_secret_key")
            ->where("team_id", $team->id);

        if(!$secret_key_query->exists()) {
            return view("checkout.payment-failure");
        }

        $secret_key = $secret_key_query->first()->value;
        Stripe::setApiKey($secret_key);

        $stripe_customer = Customer::all([
            'email' => $customer->email,
        ]);

        if (!empty($stripe_customer)) {
            $name = $customer->getMorphClass() === "App\Models\Client" ? $customer->full_name : $customer->name;
            $stripe_customer = Customer::create([
                'name' => $name,
                'email' => $customer->email,
            ]);
        }

        $paymentIntent = PaymentIntent::create([
            'amount' => $sum * 100, // Amount in cents
            'currency' => 'usd',
            'customer' => $stripe_customer->id
        ]);

        $clientSecret = $paymentIntent->client_secret;

        $stripe_publishable_key = Setting::where("key", "stripe_publishable_key")
            ->where("team_id", $team->id)->first()->value;

        return view('checkout.index', compact(
            'customer',
            'proposal',
            'countries',
            'clientSecret',
            'stripe_publishable_key',
            'sum'
        ));
    }

    public function processPayment(Request $request)
    {
        if(!$request->filled("t")) {
            return abort(404);
        }

        $token = $request->input("t");

        $client = Client::whereHas("proposals", function($query) use ($token) {
            $query->where("token", $token);
        })->first();
        $company = Company::whereHas("proposals", function($query) use ($token) {
            $query->where("token", $token);
        })->first();

        if(is_null($client) && is_null($company)) {
            return abort(404);
        }

        $customer = null;

        if(is_null($client)) {
            $customer = $company;
            $proposal = Proposal::whereHas("companies", function($query) use ($token) {
                $query->where("token", $token);
            })->first();
        } else {
            $customer = $client;
            $proposal = Proposal::whereHas("clients", function($query) use ($token) {
                $query->where("token", $token);
            })->first();
        }

        $exists = $customer->payments()
            ->where("paymentable_id", $customer->id)
            ->where("paymentable_type", $customer->getMorphClass())
            ->exists();

        if($exists) {
            return abort(404);
        }

        $customer->payments()->attach($proposal->id, ['is_paid' => true]);

        // Add Activity

        $activity_type = ActivityType::where('name', EnumsActivityType::Paid->value)->first();
        $activity = Activity::make();
        $activity->team()->associate($customer->team);
        $activity->subject()->associate($proposal);
        $activity->causer()->associate($customer);
        $activity->activity_type()->associate($activity_type);
        $activity->save();

        return view("checkout.payment-success");
    }
}
