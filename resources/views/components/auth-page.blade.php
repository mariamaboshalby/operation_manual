@props(['title', 'subtitle' => null])
<div>
    <style>
        :root {
            --bg-dark: #090508;
            --panel: rgba(16, 10, 5, 0.92);
            --panel-border: rgba(244, 194, 90, 0.2);
            --text-main: #faeee1;
            --text-muted: #cbb57f;
            --accent: #4ea0ff;
            --gold: #f4cb5d;
            --card-shadow: 0 40px 120px rgba(0, 0, 0, 0.55);
        }
        .login-shell {
            min-height: 100vh;
            padding: 40px 20px;
            background: radial-gradient(circle at top left, rgba(244, 203, 91, 0.10), transparent 24%),
                        radial-gradient(circle at bottom right, rgba(78, 160, 255, 0.10), transparent 22%),
                        linear-gradient(180deg, rgba(11, 7, 4, 0.96), rgba(3, 2, 1, 1));
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 520px;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: var(--panel);
            border: 1px solid var(--panel-border);
            backdrop-filter: blur(4px);
        }
        .login-panel {
            padding: 42px 36px;
        }
        .login-head {
            text-align: center;
            margin-bottom: 32px;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(244, 203, 91, 0.16);
            color: var(--gold);
            font-size: 0.85rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .login-head h1 {
            margin: 0;
            font-size: 2.9rem;
            background: linear-gradient(90deg, #fee28d 0%, #f6c558 45%, #4ea0ff 100%);
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.04em;
        }
        .login-head p {
            margin-top: 14px;
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
        }
        .decor-line {
            width: 84px;
            height: 4px;
            margin: 20px auto 0;
            border-radius: 999px;
            background: linear-gradient(90deg, #f4cb5d, #4ea0ff);
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
        }
        .input-field {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(244, 203, 91, 0.16);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .input-field:hover {
            border-color: rgba(244, 203, 91, 0.35);
        }
        .input-field:focus-within {
            border-color: var(--gold);
            background: rgba(244, 203, 91, 0.06);
            box-shadow: 0 0 0 4px rgba(244, 203, 91, 0.12);
        }
        .input-field:focus-within .input-icon {
            background: rgba(244, 203, 91, 0.35);
        }
        .input-icon {
            display: inline-flex;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(244, 203, 91, 0.18);
            color: #fff;
            font-size: 1rem;
            transition: background .2s ease;
        }
        .form-group input {
            width: 100%;
            padding: 0;
            border: none;
            background: transparent;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
        }
        .form-group input:focus {
            outline: none;
            border: none;
            box-shadow: none;
            --tw-ring-shadow: 0 0 #0000;
            --tw-ring-offset-shadow: 0 0 #0000;
        }
        .form-group input:-webkit-autofill,
        .form-group input:-webkit-autofill:hover,
        .form-group input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text-main);
            -webkit-box-shadow: 0 0 0 1000px #16100a inset;
            caret-color: var(--text-main);
            transition: background-color 9999s ease-in-out 0s;
        }
        .form-group input::placeholder {
            color: #8b93a3;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 28px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .checkbox-row label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .checkbox-row input[type=checkbox] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
        }
        .btn-submit {
            width: 100%;
            padding: 16px 20px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(90deg, #f4cb5d 10%, #4ea0ff 95%);
            color: #0f1012;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: transform .2s ease, filter .2s ease;
        }
        .btn-submit:hover { transform: translateY(-1px); filter: brightness(1.06); }
        .btn-secondary {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            color: var(--text-main);
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: transform .2s ease, filter .2s ease;
        }
        .btn-secondary:hover { transform: translateY(-1px); filter: brightness(1.06); }
        .button-group {
            display: grid;
            gap: 16px;
            margin-top: 24px;
        }
        .link-secondary {
            color: var(--gold);
            text-decoration: none;
        }
        .link-secondary:hover { text-decoration: underline; }
        .alert-message {
            margin-bottom: 20px;
            color: #7dd3fc;
            font-size: 0.95rem;
        }
        .login-footer {
            margin-top: 28px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }
        .login-footer a:hover { text-decoration: underline; }
        @media (max-width: 700px) {
            .login-card { max-width: 100%; border-radius: 24px; }
            .login-panel { padding: 32px 24px; }
            .login-head h1 { font-size: 2.4rem; }
        }
    </style>

    <div class="login-shell">
        <div class="login-card">
            <div class="login-panel">
                <div class="login-head">
                    <div class="brand-badge">Operation Manual</div>
                    <h1>{{ $title }}</h1>
                    @isset($subtitle)
                        <p>{{ $subtitle }}</p>
                    @endisset
                    <div class="decor-line"></div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
