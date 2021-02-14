<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscribe extends Controller
{
    //
    public function go(Request $request, Plans $plan)
    {
        if (strlen($plan['stripe_price_id']) < 1) {
            redirect()->route('pricing');
        }

        if (strlen(Auth::user()->stripe_scription_id) > 0) {
            // return error where user change subscription
            // until finish the droplet upgrading
            // or user data may lose
            return show_error("You had a subscription already");
        }

        // CheckoutSession
        $checkout = Auth::user()->newSubscription($plan['name'], $plan['stripe_price_id'])
        ->checkout([
            'client_reference_id' => Auth::id(),
            'metadata'=> ['price_id'=>$plan['stripe_price_id']],
            'success_url' => route('subscribe.callback').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('dashboard'),
        ]);

        return view('subscribe.go', ['checkout'=>$checkout,'plan'=>$plan]);
    }

    public function mine(Request $request)
    {
        return view('subscribe.mine');
    }

    public function callback(Request $request)
    {
        $session_id = $request->input('session_id');
        $stripe = new \Stripe\StripeClient(
            env("STRIPE_SECRET")
        );
        $session  = $stripe->checkout->sessions->retrieve(
            $session_id,
            []
        );

        $user = User::findOrFail($session['client_reference_id']);

        if ($user->id != Auth::id()) {
            return show_error("Bad user");
        }

        $user->stripe_price_id = $session['metadata']['price_id'];
        $user->stripe_scription_id = $session['subscription'];
        $user->save();

        // start instance
        // do this when receive paid webhook
        // if ($plan = Plans::where(['stripe_price_id'=>$user->stripe_price_id])->first()) {
        //     create_do_instance($plan->toArray(), $user->id);
        // }

        return redirect()->route('subscribe.mine');
    }
}
