<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Web\Controller;
use App\Mail\InvitationMail;
use App\Models\User;
use App\Traits\LogsToAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    use LogsToAudit;

    public function index(): View
    {
        abort_if(!Auth::user()->can('manage_users'), 403);
        $org   = Auth::user()->organisation;
        $users = User::where('organisation_id', $org->id)->with('roles')->paginate(20);
        $roles = Role::whereNotIn('name', ['super_admin'])->get();

        return view('settings.users.index', compact('users', 'roles'));
    }

    public function invite(): View
    {
        abort_if(!Auth::user()->can('manage_users'), 403);
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        return view('settings.users.invite', compact('roles'));
    }

    public function sendInvitation(Request $request): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_users'), 403);

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role'  => ['required', 'string', 'exists:roles,name'],
        ]);

        $org   = Auth::user()->organisation;
        $token = Str::random(64);

        $user = User::create([
            'id'              => Str::uuid(),
            'organisation_id' => $org->id,
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make(Str::random(32)),
            'is_active'       => false,
            'invitation_token'=> $token,
        ]);
        $user->assignRole($request->role);

        $url = URL::temporarySignedRoute('invitation.accept', now()->addDays(7), ['token' => $token]);

        Mail::to($user->email)->send(new InvitationMail($user, $url, Auth::user()->organisation));

        $this->logAudit('user_invited', $user, ['email' => $user->email, 'role' => $request->role]);

        return redirect()->route('app.settings.users.index')->with('success', 'Invitation sent to ' . $user->email);
    }

    public function acceptInvitation(string $token): View
    {
        $user = User::where('invitation_token', $token)->firstOrFail();
        return view('auth.accept-invitation', compact('user', 'token'));
    }

    public function processInvitation(Request $request, string $token): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('invitation_token', $token)->firstOrFail();

        $user->update([
            'password'         => Hash::make($request->password),
            'is_active'        => true,
            'invitation_token' => null,
            'email_verified_at'=> now(),
        ]);

        auth()->login($user);

        return redirect()->route('app.dashboard')->with('success', 'Welcome to FlowCheck!');
    }

    public function deactivate(User $user): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_users'), 403);
        abort_if($user->organisation_id !== Auth::user()->organisation_id, 403);

        $user->update(['is_active' => false]);
        $this->logAudit('user_deactivated', $user);

        return redirect()->back()->with('success', $user->name . ' deactivated.');
    }

    public function reactivate(User $user): RedirectResponse
    {
        abort_if(!Auth::user()->can('manage_users'), 403);
        abort_if($user->organisation_id !== Auth::user()->organisation_id, 403);

        $user->update(['is_active' => true]);
        $this->logAudit('user_reactivated', $user);

        return redirect()->back()->with('success', $user->name . ' reactivated.');
    }
}
