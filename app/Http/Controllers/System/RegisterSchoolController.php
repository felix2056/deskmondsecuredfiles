<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

use App\Models\System\Schools;
use App\Models\System\PendingSchoolRegistration;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class RegisterSchoolController extends Controller
{
    public function create (Request $request)
    {
      // Validate request data
      $request->validate([
        'name' => 'required',
        'domain' => 'required',
        'email' => 'required|email|unique:users',
        'admin_name' => 'required',
      ]);

      // Define the Fully Qualified Domain Name of the tenant (fqdn)
      $fqdn = ($request->domain).'.'.env('APP_MAIN_DOMAIN_NAME', 'deskmond.com');

      // Check first if requested FQDN already exists
      if (Hostname::where('fqdn', $fqdn)->doesntExist())
      {
        // Create tenants database
        $website = new Website;
        // $website->uuid = Str::random(18);
        $website->uuid = $fqdn;

        // Create tenants website
        app(WebsiteRepository::class)->create($website);
        $hostname = new Hostname;
        $hostname->fqdn = $fqdn;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);

        // Create tenant record
        $school = new Schools;
        $school->name = $request->name;
        $school->email = $request->email;
        $school->fqdn = $fqdn;
        $school->database = $website->uuid;
        $school->save();

        // Register the pending registration.
        $pending = new PendingSchoolRegistration;
        $pending->name = $request->admin_name;
        $pending->email = $request->email;
        $pending->school_id = $school->id;
        $pending->save();

          // // Create tenant's custom config.
          // $files = Storage::disk('tenant')->files('config');
          // foreach ($files as $file)
          // {
          //   Storage::disk('tenant')->copy($file, ($school->database).'/'.($file));
          // }

        // Redirect the user
        $redirect = 'http://'.($fqdn).'/pending-registration';
        return response()->json([
          'message' =>  'You will be redirected to your domain.',
          'redirect' => $redirect
        ], 200);
      } else {
        return response()->json([
          'error' => 'A school with domain '.($fqdn).' already exists.'
        ], 200);
      }
    }
}
