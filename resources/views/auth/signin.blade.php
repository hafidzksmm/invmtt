<x-guest-layout>
    @if (session('success'))
    <div style="background:#D1FADF; color:#12742A; padding:12px 16px; border-radius:10px; font-size:13.5px; margin-bottom:16px; text-align:center;">
        {{ session('success') }}
    </div>
    @endif
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>

    <main class="main-content mt-0">
        <section class="login-shell">

            {{-- ================= SISI KIRI: VISUAL / BACKGROUND GAMBAR ================= --}}
            <div class="login-visual" style="background-image: url('../assets/img/bglogin.jpg');">
                <div class="login-visual-overlay">
                    <div class="login-visual-content">
                        <div class="login-visual-mark">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                                <rect x="4" y="11" width="16" height="9" rx="2"/>
                                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                            </svg>
                        </div>
                        <h2 class="login-visual-title">Welcome Back! </h2>
                    </div>
                </div>
            </div>

            {{-- ================= SISI KANAN: FORM LOGIN (POLOS PUTIH) ================= --}}
            <div class="login-form-side">
                <div class="login-card">

                    <div class="text-center py-3">
                        <img src="{{ asset('assets/img/logo.png') }}"
                             alt="Logo"
                             class="img-fluid"
                             style="max-width:150px;">
                    </div>


                    <div class="text-center">
                        @if (session('status'))
                            <div class="mb-3 font-medium text-sm login-alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @error('message')
                            <div class="login-alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <form role="form" method="POST" action="sign-in">
                        @csrf

                        <div class="mb-3">
                            <label class="login-label">Username</label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   class="login-input"
                                   placeholder="Enter your Username"
                                   aria-label="username"
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="login-label">Password</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   value=""
                                   class="login-input"
                                   placeholder="Enter your Password"
                                   aria-label="Password"
                                   aria-describedby="password-addon">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label login-remember" for="remember">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="login-btn">Login</button>
                    </form>

                </div>
            </div>

        </section>
    </main>
</x-guest-layout>

<style>
    :root{
        --login-red: #E11D2E;
        --login-red-dark: #B0121F;
        --login-red-light: #FBD3D9;
        --login-text: #17181A;
        --login-muted: #8A8F98;
    }

    .login-shell{
        display:flex;
        min-height:100vh;
        overflow:hidden;
    }

    /* ============ SISI VISUAL / GAMBAR ============ */
    .login-visual{
        position:relative;
        flex:0 0 42%;
        background-size:cover;
        background-position:center;
        clip-path:polygon(0 0, 100% 0, 88% 100%, 0% 100%);
    }

    .login-visual-overlay{
        position:absolute;
        inset:0;
        background:linear-gradient(160deg, rgba(225,29,46,0.92) 0%, rgba(176,18,31,0.94) 55%, rgba(23,24,26,0.85) 100%);
        display:flex;
        align-items:flex-end;
        padding:56px 48px;
    }

    .login-visual-content{ max-width:360px; }

    .login-visual-mark{
        width:52px; height:52px;
        border-radius:14px;
        background:rgba(255,255,255,0.16);
        border:1px solid rgba(255,255,255,0.35);
        display:flex; align-items:center; justify-content:center;
        margin-bottom:22px;
    }

    .login-visual-title{
        font-size:30px;
        font-weight:700;
        color:#fff;
        line-height:1.25;
        margin-bottom:14px;
    }

    .login-visual-text{
        font-size:14px;
        color:rgba(255,255,255,0.85);
        line-height:1.6;
    }

    /* ============ SISI FORM ============ */
    .login-form-side{
        flex:1;
        background:#FFFFFF;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:32px 16px;
    }

    .login-card{
        width:100%;
        max-width:380px;
    }

    .login-heading{
        text-align:center;
        font-weight:700;
        font-size:22px;
        color:var(--login-text);
        margin-bottom:4px;
    }

    .login-subheading{
        text-align:center;
        font-size:13px;
        color:var(--login-muted);
        margin-bottom:24px;
    }

    .login-alert-success{ color:var(--login-red); }
    .login-alert-danger{
        background:var(--login-red-light);
        color:var(--login-red-dark);
        border:1px solid var(--login-red);
        border-radius:10px;
        padding:10px 14px;
        font-size:13px;
        margin-bottom:16px;
    }

    .login-label{
        display:block;
        font-size:13px;
        font-weight:600;
        color:#4A4A4A;
        margin-bottom:6px;
    }

    .login-input{
        width:100%;
        border:1px solid #ECECEC;
        outline:none;
        background:#FAFAFA;
        border-radius:12px;
        padding:13px 18px;
        font-size:14px;
        color:var(--login-text);
        transition:.15s ease;
    }
    .login-input::placeholder{ color:#B0B0B0; }
    .login-input:focus{
        border-color:var(--login-red);
        background:#fff;
        box-shadow:0 0 0 3px rgba(225,29,46,0.12);
    }

    .login-remember{
        font-size:13px;
        color:#6B6B6B;
    }

    .login-btn{
        width:100%;
        border:none;
        border-radius:12px;
        padding:14px;
        font-size:14px;
        font-weight:700;
        letter-spacing:.5px;
        color:#fff;
        text-transform:uppercase;
        background:var(--login-red);
        box-shadow:0 10px 22px rgba(225,29,46,0.30);
        cursor:pointer;
        transition:.15s ease;
    }
    .login-btn:hover{
        background:var(--login-red-dark);
        transform:translateY(-1px);
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width:900px){
        .login-shell{ flex-direction:column; }

        .login-visual{
            flex:0 0 220px;
            clip-path:polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }

        .login-visual-overlay{
            align-items:center;
            padding:32px 28px;
        }

        .login-visual-title{ font-size:24px; }

        .login-form-side{ padding:40px 20px; }
    }
</style>