<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *@OA\Info(
 *  version="1.0.0",
 *  title="API Documentation",
 *  description="API Documentation",
 *  @OA\Contact(
 *    email="contact@touri-touri.com"
 *  ),
 *  @OA\License(
 *   name="MIT",
 *   url="https://opensource.org/licenses/MIT"
 *  )
 *)
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
