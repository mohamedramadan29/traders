<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\CurrencyPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\AddBalanceToInvestmentBlan;

class CurrencyPlansController extends Controller
{
    use Message_Trait;
    use Upload_Images;

    public function index()
    {
        $plans = CurrencyPlan::latest()->get();
        $addedbalances = AddBalanceToInvestmentBlan::where('type', 'add')->latest()->get();
        $removedbalances = AddBalanceToInvestmentBlan::where('type', 'remove')->latest()->get();
        // dd($plans);
        return view('admin.CurrencyPlans.index', compact('plans', 'addedbalances', 'removedbalances'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'url' => ['required', 'url'],
                'logo' => ['required', 'image'],
                'curreny_number' => ['required', 'numeric'],
                'main_investment' => ['required', 'numeric'],
                'currency_main_price' => ['required', 'numeric'],
            ];
            $messages = [
                'name.required' => ' من فضلك ادخل العملة  ',
                'url.required' => ' من فضلك ادخل رابط المنصة  ',
                'url.url' => ' من فضلك ادخل الرابط بشكل صحيح  ',
                'logo.required' => ' من فضلك ادخل لوجو العملة  ',
                'logo.image' => ' من فضلك ادخل صورة لوجو العملة  ',
                'curreny_number.required' => ' من فضلك ادخل عدد العملات   ',
                'curreny_number.numeric' => ' من فضلك ادخل عدد العملات  بشكل صحيح  ',
                'main_investment.required' => ' من فضلك ادخل مبلغ الاستثمار  الاساسي  ',
                'currency_main_price.required' => ' من فضلك ادخل سعر العملة  ',
                'currency_main_price.numeric' => ' من فضلك حدد السعر بشكل صحيح '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('logo')) {
                $filename = $this->saveImage($request->file('logo'), public_path('assets/uploads/currency/'));
            }

            $currencyPlane = new CurrencyPlan();

            $currencyPlane->name = $data['name'];
            $currencyPlane->url = $data['url'];
            $currencyPlane->logo = $filename;
            $currencyPlane->curreny_number = $data['curreny_number'];
            $currencyPlane->main_investment = $data['main_investment'];
            $currencyPlane->currency_main_price = $data['currency_main_price'];
            $currencyPlane->save();

            return $this->success_message(' تم اضافة العملة بنجاح  ');
        }

        return view('admin.CurrencyPlans.store');
    }

    public function update(Request $request, $id)
    {
        $plan = CurrencyPlan::findOrFail($id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'url' => ['required', 'url'],
                // 'logo' => ['required', 'image'],
                'curreny_number' => ['required', 'numeric'],
                'main_investment' => ['required', 'numeric'],
                'currency_main_price' => ['required', 'numeric'],
            ];
            $messages = [
                'name.required' => ' من فضلك ادخل العملة  ',
                'url.required' => ' من فضلك ادخل رابط المنصة  ',
                'url.url' => ' من فضلك ادخل الرابط بشكل صحيح  ',
                // 'logo.required' => ' من فضلك ادخل لوجو العملة  ',
                //'logo.image' => ' من فضلك ادخل صورة لوجو العملة  ',
                'curreny_number.required' => ' من فضلك ادخل عدد العملات   ',
                'curreny_number.numeric' => ' من فضلك ادخل عدد العملات  بشكل صحيح  ',
                'main_investment.required' => ' من فضلك ادخل مبلغ الاستثمار  الاساسي  ',
                'currency_main_price.required' => ' من فضلك ادخل سعر العملة  ',
                'currency_main_price.numeric' => ' من فضلك حدد السعر بشكل صحيح '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            ######### Have New Logo
            if ($request->hasFile('logo')) {
                ###### Delete Old Logo

                $oldlogo = public_path('uploads/currency/' . $plan->logo);
                if (file_exists($oldlogo)) {
                    @unlink($oldlogo);
                }
                $filename = $this->saveImage($request->file('logo'), public_path('assets/uploads/currency/'));
                $plan->logo = $filename;
                $plan->save();
            }

            $plan->name = $data['name'];
            $plan->url = $data['url'];
            $plan->curreny_number = $data['curreny_number'];
            $plan->main_investment = $data['main_investment'];
            $plan->currency_main_price = $data['currency_main_price'];
            $plan->status = $data['status'];
            $plan->save();
            return $this->success_message(' تم تعديل العملة بنجاح  ');
        }
        return view('admin.CurrencyPlans.update', compact('plan'));
    }

    public function delete($id)
    {
        $currencyPlane = CurrencyPlan::findOrFail($id);
        ####### Delete Logo
        $logo = public_path('uploads/currency/' . $currencyPlane->logo);
        if (file_exists($logo)) {
            @unlink($logo);
        }
        $currencyPlane->delete();
        return $this->success_message(' تم الحذف بنجاح  ');
    }
    public function addBalance(Request $request)
    {
        $data = $request->all();
        $rules = [
            'plan_id' => 'required',
            'amount' => 'required',
        ];
        $messages = [
            'plan_id.required' => ' من فضلك اختر العملة  ',
            'amount.required' => ' من فضلك ادخل المبلغ  ',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $plan = CurrencyPlan::findOrFail($data['plan_id']);
            $plan->main_investment = $plan->main_investment + $data['amount'];
            $plan->save();
            ######## Add Balance To AddBalanceToInvestmentBlan Table
            $addBalanceToInvestmentBlan = new AddBalanceToInvestmentBlan();
            $addBalanceToInvestmentBlan->plan_id = $data['plan_id'];
            $addBalanceToInvestmentBlan->amount = $data['amount'];
            $addBalanceToInvestmentBlan->type = 'add';
            $addBalanceToInvestmentBlan->save();
            DB::commit();
            return $this->success_message(' تم اضافة المبلغ بنجاح  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }
    public function removeBalance(Request $request)
    {
        $data = $request->all();
        $rules = [
            'plan_id' => 'required',
            'amount' => 'required',
        ];
        $messages = [
            'plan_id.required' => ' من فضلك اختر العملة  ',
            'amount.required' => ' من فضلك ادخل المبلغ  ',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $plan = CurrencyPlan::findOrFail($data['plan_id']);
            $plan->main_investment = $plan->main_investment - $data['amount'];
            $plan->save();
            ######## Add Balance To AddBalanceToInvestmentBlan Table
            $addBalanceToInvestmentBlan = new AddBalanceToInvestmentBlan();
            $addBalanceToInvestmentBlan->plan_id = $data['plan_id'];
            $addBalanceToInvestmentBlan->amount = $data['amount'];
            $addBalanceToInvestmentBlan->type = 'remove';
            $addBalanceToInvestmentBlan->save();
            DB::commit();
            return $this->success_message(' تم ازالة المبلغ بنجاح  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }
}
