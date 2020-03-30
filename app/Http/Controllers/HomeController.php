<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct() {
        //
    }

    public function index(Request $request)
    {
        $sfSecretKey = getenv('SFDC_SECRET_KEY', '');

        if (!$sfSecretKey || !$sr = $this->verifyAndDecodeAsJson($request->input('signed_request'), $sfSecretKey)) {
            echo "Error: Signed Request or Consumer Secret not found";
            die;
        }

//        $request->session()->put('signedRequest', $sr);

        return view('welcome', [
            'sr' =>  $sr
        ]);
//        dd($sr->client);
//
//        return redirect()->route('heroku');
    }

    private function verifyAndDecodeAsJson($signedRequest, $consumer_secret) {
        $sep = strpos($signedRequest, '.');
        $encodedSig = substr($signedRequest, 0, $sep);
        $encodedEnv = substr($signedRequest, $sep + 1);
        $calcedSig = base64_encode(hash_hmac("sha256", $encodedEnv, $consumer_secret, true));
        if ($calcedSig != $encodedSig) {
            return false;
        }

        //decode the signed request object
        $sr = base64_decode($encodedEnv);
        return json_decode($sr);
    }

    public function welcome() {
        $signedRequest = Session::get('signedRequest');
        return view('welcome', [
            'signedRequest' => $signedRequest
        ]);
    }
}
