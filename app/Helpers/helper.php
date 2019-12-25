<?php


/**
 * @param $request
 * @return array
 */
function getFormData($request)
{
    $inputs = [];
    $data = $request->all();
    parse_str($data['form-data'], $inputs);
    return $inputs;
}


/**
 * @param $errors
 */
function jsonErrors($errors)
{
    $err = [];
    if(count($errors) > 0) {
        foreach($errors as $key => $error) {
            $err[$key] = $error;
        }
    }
    echo json_encode(['status' => false, 'errors' => $err]);
}


/**
 * @param $errors
 * @param bool $validationError
 * @return array
 */
function generateValidationErrorsForAjaxSubmit($errors, $validationError = true)
{
    $response = [];
    $errors = ($validationError == true) ? $errors->getMessages() : $errors;
    if(count($errors) > 0) {
        foreach($errors as $key => $error) {
            $response[] = [
                'key' => $key,
                'error' => $error[0]
            ];
        }
    }

    return $response;
}


//function parseErrorMessagesForAjaxForm($validator)
//{
//    $errors = [];
//
//    if($validator->errors()->getMessages()) {
//        foreach($validator->errors()->getMessages() as $key => $value) {
//            $errors[] =  $value[0];
//        }
//    }
//    return $errors;
//}
