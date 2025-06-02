@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<h1 style="text-align: center; font-size: 24px; color: #3B82F6; margin: 0;">
    {{ config('app.name') }}
</h1>
@endcomponent
@endslot

# Bonjour {{ $user->name }} 👋

Votre compte utilisateur sur **{{ config('app.name') }}** a été créé avec succès !

@component('mail::panel', ['type' => 'info'])
## 🔐 Identifiants de connexion
- **📧 Adresse email** : {{ $user->email }}  
- **🔑 Mot de passe temporaire** : `{{ $password }}`
@endcomponent

<div style="margin: 20px 0; color: #4a5568;">
<p>Pour votre sécurité, veuillez :</p>
<ul>
    <li>Changer votre mot de passe dès la première connexion</li>
    <li>Conserver ces informations confidentielles</li>
</ul>
</div>

@component('mail::button', ['url' => url('/login'), 'color' => 'primary'])
Se connecter maintenant
@endcomponent

<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; color: #718096;">
<p>Besoin d'aide ?<br>
    Contactez notre support : <a href="mailto:{{ env('SUPPORT_EMAIL') }}">{{ env('SUPPORT_EMAIL') }}</a></div>

@slot('footer')
@component('mail::footer')
<div style="text-align: center; color: #718096; font-size: 0.9em;">
    © {{ date('Y') }} {{ config('app.name') }}<br>
    <a href="{{ url('/politique') }}" style="color: #4a5568; text-decoration: none;">Politique de confidentialité</a> | 
    <a href="{{ url('/conditions') }}" style="color: #4a5568; text-decoration: none;">Conditions d'utilisation</a>
</div>
@endcomponent
@endslot

<style>
/* Styles personnalisés compatibles avec tous les clients mail */
.primary-button {
    background-color: #3B82F6 !important;
    border-color: #3B82F6 !important;
}
.email-body ul {
    margin: 10px 0;
    padding-left: 20px;
}
</style>

@endcomponent