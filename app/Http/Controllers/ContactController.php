<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class ContactController extends Controller
{
    private $_contact;

    /**
     * ContactController constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->_contact = $contact;
    }




    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('student.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(Request $request)
    {
        $inputs = getFormData($request);

        $validator = Validator::make($inputs, [
            'name'   => 'required|max:255|unique:contacts',
            'number' => 'required|regex:/^[0-9]{10,15}+$/',
        ]);

        if($validator->fails()) {
            $errors = generateValidationErrorsForAjaxSubmit($validator->errors());
            return jsonErrors($errors);
        }

        $data = [
            'name'       => $inputs['name'],
            'number'     => $inputs['number'],
        ];

        $this->_contact->store($data);
        Session::flash('success', 'Contact add successfully.');
        return response()->json([
            'status' => true
        ]);

    }


}
