@extends("layout.layout.layout")

@section("CSS")
    <link rel="stylesheet" href="/css/login.css">
@endsection

@section("content")
    <div id="logreg-forms">
        <form class="form-signin" method="POST">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Register</h1>
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign in with Facebook</span> </button>
                <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button>
            </div>
            <p style="text-align:center"> OR  </p>
            <div class="form-group col-md-12">
                <label for="first_name">First name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                @error("first_name")
                <span class="text-danger" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="last_name">Last name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                @error("last_name")
                <span class="text-danger" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                @error("email")
                <span class="text-danger" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                @error("password")
                <span class="text-danger" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                @error("password_confirmation")
                    <span class="text-danger" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="subject">Subject: </label>
                <br>
                <select class="col-md-6" name="subject" id="subject" multiple>
                    <option value="student">student</option>
                    <option value="develop">develop</option>
                    <option value="tester">tester</option>
                    <option value="manager">manager</option>
                    <option value="other">other</option>
                </select>
            </div>




            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-user-plus"></i>  Sign up</button>
            <hr>

        </form>
        <br>
    </div>
@endsection

@section("footer")
@endsection
