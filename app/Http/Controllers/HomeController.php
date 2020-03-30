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



        $sessionData = [
            'sr' => $sr,
            'signedRequest' => $request->input('signed_request')
        ];

        $request->session()->put('canvas-info', $sessionData);
        $canvasInfo = Session::get('canvas-info');
        $signedRequest = $canvasInfo['signedRequest'];
        dd($signedRequest);

        return view('welcome');
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
}
