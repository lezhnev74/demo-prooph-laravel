<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace App\Http\Controllers\Account;


use App\Component\Account\Command\CreateAccountFromRequest\CreateAccountFromRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    function get_verify(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'code' => 'required'
        ]);

        return view("web.account.set_password", [
            'email' => $request->input('email'),
            'code' => $request->input('code')
        ]);
    }

    function post_verify(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        \CommandBus::dispatch(new CreateAccountFromRequest(
            $request->input('email'),
            $request->input('code'),
            $request->input('password')
        ));

        return redirect()->back()->with('message', 'You can now log in');
    }
}