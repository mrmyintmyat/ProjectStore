@extends('layouts.app')

@section('content')
            <main class="d-flex align-items-center justify-content-center container-md p-0">
                <div class="d-flex flex-column-reverse flex-md-row w-100" id="main">
                    <section class="shadow-sm col-md-7 d-flex justify-content-center align-items-center">
                        <div class="loginBox">
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div id="form1">
                                    <h3 class="fs-1 fw-bold">REGISTER</h3>
                                    @error('name')
                                    <span class="text-warning">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('identifier')
                                    <span class="text-warning">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('password')
                                    <span class="text-warning">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('email')
                                    <span class="text-warning">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('select_chat_id')
                                    <span class="text-warning">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    <div class="inputBox">
                                        <input id="name" type="text" class="@error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autocomplete="name"
                                            autofocus placeholder="Name">

                                        <input id="identifier" type="email" class="@error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email" aria-describedby="emailHelp">

                                        <input id="password" type="password"
                                            class="@error('password') is-invalid @enderror" name="password" required
                                            autocomplete="new-password" placeholder="Password"
                                            value="{{ old('password') }}">

                                        <input id="password-confirm" type="password" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="Confirm Password"
                                            value="{{ old('password_confirmation') }}">
                                    </div>
                                    <input type="button" value="Next" onclick="toggleFormDisplay('form1', 'form2')">
                                </div>

                                <div id="form2" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <button type="button" onclick="toggleFormDisplay('form1', 'form2')"
                                            class="me-2 border-0 bg-light rounded-circle fs-6 py-2 px-3">
                                            <i class="fa-solid fa-chevron-left"></i></button>
                                        <h3 class="fw-bold p-0">CHAT ID</h3>
                                        <div class="col-2"></div>
                                    </div>
                                    <div class="inputBox" class="">

                                        <select name="select_chat_id" id="select_chat_id">
                                            <option value="messenger" selected>Messenger</option>
                                            <option value="telegram">Telegram</option>
                                            <option value="skype">Skype</option>
                                            <option value="whatsapp">Whatsapp</option>
                                            <option value="viber">Viber</option>
                                        </select>

                                        <input id="chat_id" type="text" class="@error('chat_id') is-invalid @enderror"
                                            name="chat_id" value="{{ old('chat_id') }}" required autocomplete="chat_id"
                                            autofocus placeholder="Chat Id">
                                    </div>
                                    <input type="submit" name="" value="Register">
                                </div>
                            </form>
                            <div class="text-center">
                                <p class="text-black mb-0">Do you have an account?</p>
                                <a href="/login">Login here</a>
                            </div>
                        </div>
                    </section>
                    <section class="col-md-5 d-flex justify-content-center align-items-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <h3 class="fw-bold text-white d-none d-lg-block">Welcome to</h3>
                            <h4 class="text-white fw-bold fs-1 d-md-block d-none">NextPj</h4>
                            <p class="mt-md-5 m-0 text-center fw-semibold w-75 text-white w-100 fs-5">Find your next project here!</p>
                        </div>
                    </section>
                </div>
            </main>
            <script>
                function toggleFormDisplay(currentFormId, nextFormId) {
                    var currentForm = document.getElementById(currentFormId);
                    var nextForm = document.getElementById(nextFormId);

                    // Toggle the display property of the current form
                    if (currentForm.style.display === "none") {
                        currentForm.style.display = "block";
                    } else {
                        currentForm.style.display = "none";
                    }

                    // Toggle the display property of the next form
                    if (nextForm.style.display === "none") {
                        nextForm.style.display = "block";
                    } else {
                        nextForm.style.display = "none";
                    }
                }
            </script>
        @endsection
