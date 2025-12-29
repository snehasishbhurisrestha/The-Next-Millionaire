<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CertificationType;

class WebCertificateController extends Controller
{
    public function index()
    {
        $certificates = CertificationType::where('is_visible',1)->paginate(8);

        return view('site.certificate',compact('certificates'));
    }
}
