<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <title>Email verification code: {{ $verificationCode }}</title>
</head>

<body>
    <div class="container">
        <div class="d-flex flex-column align-items-center py-5">
            <div class="bg-white border shadow-sm d-flex flex-column align-items-center col-12 col-lg-5 pt-4">
                <p class="fs-3 fw-semibold">Verify your email</p>
                <div style="height: 1.8px;" class="w-75 shadow bg-black rounded-pill mb-2"></div>
                <p class="fs-5">Your verification code is:</p>
                <div class="rounded-0 fs-4 bg-primary px-2 py-1 fw-semibold text-white text-center" style="width: 100px;">{{ $verificationCode }}</div>
                <div class="d-flex w-100 justify-content-around mt-3 mb-3">
                    <div>
                        <a href="https://www.facebook.com/hmxdigital"
                        class="text-info text-decoration-none">facebook page</a>
                    </div>
                    <div>
                    <a href="https://www.facebook.com/htetmyataung1288"
                        class="text-info text-decoration-none ms-4">facebook account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
