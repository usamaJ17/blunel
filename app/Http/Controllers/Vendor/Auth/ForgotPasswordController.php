<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Contracts\Repositories\PasswordResetRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enums\SessionKey;
use App\Enums\ViewPaths\Vendor\Auth;
use App\Enums\ViewPaths\Vendor\ForgotPassword;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\PasswordResetRequest;
use App\Http\Requests\Vendor\VendorPasswordRequest;
use App\Services\PasswordResetService;
use App\Traits\SmsGateway;
use App\Models\Seller;
use App\Utils\Helpers;
use App\Utils\SMS_module;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Gateways\Traits\SmsGateway as AddonSmsGateway;

class ForgotPasswordController extends BaseController
{
    use SmsGateway;

    /**
     * @param VendorRepositoryInterface $vendorRepo
     * @param PasswordResetRepositoryInterface $passwordResetRepo
     * @param PasswordResetService $passwordResetService
     */
    public function __construct(
        private readonly VendorRepositoryInterface $vendorRepo,
        private readonly PasswordResetRepositoryInterface $passwordResetRepo,
        private readonly PasswordResetService $passwordResetService,
    )
    {
        $this->middleware('guest:seller', ['except' => ['logout']]);
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View|Collection|LengthAwarePaginator|callable|RedirectResponse|null
     */
    public function index(?Request $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
       return $this->getForgotPasswordView();
    }

    /**
     * @return View
     */
    public function getForgotPasswordView():View
    {
        return view(ForgotPassword::INDEX[VIEW]);
    }

    /**
     * @param PasswordResetRequest $request
     * @return RedirectResponse
     */
    public function getPasswordResetRequest(PasswordResetRequest $request):RedirectResponse
    {
        session()->put(SessionKey::FORGOT_PASSWORD_IDENTIFY, $request['identity']);
        $verificationBy = getWebConfig('forgot_password_verification');
        if($verificationBy == 'email')
        {
            $vendor = $this->vendorRepo->getFirstWhere(['identity' => $request['identity']]);
            if (isset($vendor)) {
                $token = Str::random(120);
                $this->passwordResetRepo->add($this->passwordResetService->getAddData(vendor:$vendor,token: $token,userType:'seller'));
                $resetUrl = url('/') . '/'.ForgotPassword::RESET_PASSWORD[URL].'?token=' . $token;
                try {
                    Mail::to($vendor['email'])->send(new \App\Mail\PasswordResetMail($resetUrl));
                    Toastr::success(translate('check_your_email'). translate('password_reset_url_sent'));
                }catch (\Exception $exception){
                    Toastr::error(translate('email_send_fail'));
                }
                return redirect()->back();
            }
        }elseif ($verificationBy == 'phone') {
            $vendor = $this->vendorRepo->getFirstWhere(['identity'=>$request['identity']]);
            if (isset($vendor)) {
                $token = Str::random(120);
                $this->passwordResetRepo->add($this->passwordResetService->getAddData(vendor:$vendor,token: $token,userType:'seller'));
                $publishedStatus = 0;
                $paymentPublishedStatus = config('get_payment_publish_status');
                if (isset($payment_published_status[0]['is_published'])) {
                    $publishedStatus = $paymentPublishedStatus[0]['is_published'];
                }
                if($publishedStatus == 1){
                    $response = AddonSmsGateway::send($vendor['phone'], $token);
                }else{
                    $response = $this->send($vendor['phone'], $token);
                }
                if ($response === "not_found") {
                    Toastr::error(translate('SMS_configuration_missing'));
                    return back();
                }
                Toastr::success(translate('Check_your_phone').' '.translate('Password_reset_otp_sent'));
                return redirect()->back();
            }
        }
        Toastr::error(translate('No_such_user_found').'!');
        return redirect()->back();
    }

    /**
     * @return View
     */
    public function getOTPVerificationView():View
    {
        return view(ForgotPassword::OTP_VERIFICATION[VIEW]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitOTPVerificationCode(Request $request):RedirectResponse
    {
        $id = session(SessionKey::FORGOT_PASSWORD_IDENTIFY);
        $passwordResetData = $this->passwordResetRepo->getFirstWhere(params: ['user_type' => 'seller', 'token' => $request['token'], 'identity' => $id]);
        if (isset($passwordResetData)) {
            $token = $request['otp'];
            return redirect()->route('vendor.auth.reset-password', ['token' => $token]);
        }
        Toastr::error(translate('invalid_otp'));
        return redirect()->back();
    }
    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function getPasswordResetView(Request $request):View|RedirectResponse
    {
        $passwordResetData = $this->passwordResetRepo->getFirstWhere(params: ['user_type'=>'seller','token' => $request['token']]);
        if (isset($passwordResetData)) {
            $token = $request['token'];
            return view(ForgotPassword::RESET_PASSWORD[VIEW], compact('token'));
        }
        Toastr::error(translate('Invalid_URL'));
        return redirect()->route(Auth::VENDOR_LOGOUT[URI]);
    }
    /**
     * @param VendorPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(VendorPasswordRequest $request): RedirectResponse
    {
        $passwordResetData = $this->passwordResetRepo->getFirstWhere(params: ['user_type' => 'seller', 'token' => $request['reset_token']]);
        if ($passwordResetData) {
            $vendor = $this->vendorRepo->getFirstWhere(params: ['identity' => $passwordResetData['identity']]);
            $this->vendorRepo->update(id: $vendor['id'], data: ['password' => bcrypt($request['password'])]);
            $this->passwordResetRepo->delete(params: ['id' => $passwordResetData['id']]);
            Toastr::success(translate('Password_reset_successfully'));
        } else {
            Toastr::error(translate('invalid_URL'));
        }

        return redirect()->route(Auth::VENDOR_LOGOUT[URI]);
    }
}
