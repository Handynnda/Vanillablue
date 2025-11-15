use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Tambahkan method ini
    protected function authenticated(Request $request, $user)
    {
        // Jika email belum terverifikasi
        if (!$user->hasVerifiedEmail()) {
            Auth::logout(); // logout user
            return redirect('/login')->with('error', 'Silakan verifikasi email terlebih dahulu sebelum masuk.');
        }

        // Jika sudah verifikasi, arahkan ke halaman booking
        return redirect()->intended('/booking');
    }
}
