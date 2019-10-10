<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TADPHP\TADFactory;
use TADPHP\TAD;


use App\Models\Log;
use App\Models\Import;


class LogController extends Controller
{
    public function index() 
    {
        return view('logs.index');
    }

    // public function list() 
    // {

    // }

    public function list() 
    {
        $options = [
            'ip' => '192.168.10.233',   // '169.254.0.1' by default (totally useless!!!).
            'internal_id' => 1,    // 1 by default.
            'com_key' => 223355,        // 0 by default.
            'description' => 'TAD1', // 'N/A' by default.
            'soap_port' => 80,     // 80 by default,
            'udp_port' => 4370,      // 4370 by default.
            'encoding' => 'utf-8'    // iso8859-1 by default.
        ];

        $comands = TAD::commands_available();
        $tad = (new TADFactory($options))->get_instance();
        $logs = $tad->get_att_log();
        $fs = $tad->get_free_sizes();
        // $users = $tad->get_all_user_info();
        
        return $logs->filter_by_date(['start' => '2019-10-09','end' => '2019-10-09'])->to_array()['Row'];
    }

    public function import() 
    {
        $options = [
            'ip' => '192.168.10.233',   // '169.254.0.1' by default (totally useless!!!).
            'internal_id' => 1,    // 1 by default.
            'com_key' => 223355,        // 0 by default.
            'description' => 'TAD1', // 'N/A' by default.
            'soap_port' => 80,     // 80 by default,
            'udp_port' => 4370,      // 4370 by default.
            'encoding' => 'utf-8'    // iso8859-1 by default.
        ];

        $comands = TAD::commands_available();
        $tad = (new TADFactory($options))->get_instance();

        $now = now();
        $lastImport = optional(Import::orderBy('id', 'desc')->first())->time;
        $lastImport = is_null($lastImport) ? now()->subYears(2) : $lastImport;

        $logs = $tad->get_att_log();
        $logs = collect(optional($logs->filter_by_date(['start' => $lastImport->toDateString(),'end' => date('Y-m-d')])->to_array())['Row']);

        $newLogs = $logs->filter(function($log) use ($lastImport) {
            return $log['DateTime'] >= $lastImport;
        });

        Import::create([
            'time' => $now,
        ]);

        return $newLogs;
    }
}
