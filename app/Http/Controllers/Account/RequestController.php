<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace App\Http\Controllers\Account;


use App\Component\Account\Command\RequestAccountWithEmail\RequestAccountWithEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    function get_request()
    {

    }

    function post_request(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        \CommandBus::dispatch(new RequestAccountWithEmail($request->input('email')));

        return back()->with('message', 'Check your inbox');

    }
}