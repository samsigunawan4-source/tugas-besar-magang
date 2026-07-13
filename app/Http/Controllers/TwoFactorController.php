<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function setup(Request $request)
    {
        $user = $request->user();
        $google2fa = new Google2FA();
        
        $secret = $google2fa->generateSecretKey();
        
        // Temporarily store in session until verified
        $request->session()->put('2fa_setup_secret', $secret);

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);
        $qrCodeImage = base64_encode($writer->writeString($qrCodeUrl));

        return view('auth.2fa-setup', [
            'qrCodeImage' => $qrCodeImage,
            'secret' => $secret
        ]);
    }

    public function verifySetup(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);

        $secret = $request->session()->get('2fa_setup_secret');
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($secret, $request->one_time_password, 10);

        if ($valid) {
            $user = $request->user();
            $user->google2fa_secret = $secret;
            $user->save();

            $request->session()->forget('2fa_setup_secret');
            $request->session()->put('2fa_authenticated', true);

            return redirect()->route('dashboard')->with('status', '2FA enabled successfully.');
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code. Please try again.']);
    }

    public function challenge()
    {
        return view('auth.2fa-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);

        $user = $request->user();
        
        if (empty($user->google2fa_secret)) {
            return redirect()->route('2fa.setup');
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password, 10);

        if ($valid) {
            $request->session()->put('2fa_authenticated', true);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code.']);
    }
}
