<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PlansController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $plans = Plan::with('platform')->get();
        //dd($plans);
        $platforms = Platform::all();
        return view('admin.Plans.index', compact('plans', 'platforms'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'platform_id' => 'required',
                'main_price' => 'required',
                'step_price' => 'required',
                'return_investment' => 'required'
            ];
            $messages = [
                'name.required' => ' من فضلك ادخل اسم الخطة  ',
                'platform_id.required' => ' من فضلك حدد منصة التداول  ',
                'main_price.required' => ' من فضلك حدد سعر الخطة  ',
                'step_price.required' => ' من فضلك حدد نسبة الزيادة علي كل اشتراك  ',
                'return_investment.required' => ' حدد العائد الاستثماري  ',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $plan = new Plan();
            $plan->name = $data['name'];
            $plan->platform_id = $data['platform_id'];
            $plan->main_price = $data['main_price'];
            $plan->current_price = $data['main_price'];
            $plan->step_price = $data['step_price'];
            $plan->return_investment = $data['return_investment'];
            $plan->save();
            return $this->success_message(' تم اضافة الخطة بنجاح  ');
            // $plan->daily_percentage = $data['daily_percentage'];
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $plan = Plan::findOrFail($id);
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'platform_id' => 'required',
                'main_price' => 'required',
                'step_price' => 'required',
                'return_investment' => 'required'
            ];
            $messages = [
                'name.required' => ' من فضلك ادخل اسم الخطة  ',
                'platform_id.required' => ' من فضلك حدد منصة التداول  ',
                'main_price.required' => ' من فضلك حدد سعر الخطة  ',
                'step_price.required' => ' من فضلك حدد نسبة الزيادة علي كل اشتراك  ',
                'return_investment.required' => ' حدد العائد الاستثماري  ',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $plan->update([
                'name' => $data['name'],
                'platform_id' => $data['platform_id'],
                'main_price' => $data['main_price'],
                //'current_price' => $data['current_price'],
                'step_price' => $data['step_price'],
                'return_investment' => $data['return_investment'],
                'daily_percentage' => $data['daily_percentage'],
            ]);
            if ($data['main_price'] > $plan['current_price']) {
                $plan->update([
                    'current_price' => $data['main_price'],
                ]);
            }
            return $this->success_message(' تم تعديل الخطة بنجاح  ');
            // $plan->daily_percentage = $data['daily_percentage'];
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

    public function delete($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return $this->success_message(' تم الحذف بنجاح  ');
    }

}
