<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-10 offset-1 mt-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Add User</h3>
                </div>
                <div class="card-body">

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form id="formData" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Name: <span class="text-danger">*</span></strong>
                                    <input type="text" name="name" class="form-control name"
                                        placeholder="Name">
                                    <span class="text-danger hide" id="name_error">Name Field is Required with only
                                        alphabets (A-Z or a-z)</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Email: <span class="text-danger">*</span></strong>
                                    <input type="text" name="email" class="form-control email"
                                        placeholder="Email">
                                    <span class="text-danger" id="email-error"></span>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Phone: <span class="text-danger">*</span></strong>
                                    <input type="text" name="phone" class="form-control phone"
                                        placeholder="Phone">
                                    <span id="phone_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Gender :</strong>
                                    <div class="form-check">
                                        <input class="form-check-input" name="gender" type="radio" value="male"
                                            name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="gender" type="radio" value="female"
                                            name="flexRadioDefault" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Female
                                        </label>
                                    </div>
                                    @if ($errors->has('subject'))
                                        <span
                                            class="text-danger gender_error">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Education : <span class="text-danger">*</span></strong>
                                    <select class="form-select education" name="education"
                                        aria-label="Default select example">
                                        <option selected disabled value="">Open this select menu</option>
                                        @foreach ($edus as $edu)
                                            <option value="{{ $edu->id }}">{{ $edu->name }}</option>
                                        @endforeach
                                    </select>
                                        <span class="text-danger education_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Hobby :</strong>
                                    {{-- <input type="text" name="hobby" class="form-control hobby"
                                        placeholder="Subject"> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" name="hobby[]" type="checkbox"
                                            value="1">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cricket
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="hobby[]" type="checkbox"
                                            value="1">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Singing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="hobby[]" type="checkbox"
                                            value="1">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Travelling
                                        </label>
                                    </div>
                                        <span class="text-danger hobby_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group dynamic-html">
                                    <strong>Experience :
                                        <a class="btn btn-primary rounded-circle ml-2 mb-1 add_exp">+</a>
                                        {{-- <a class="btn btn-danger rounded-circle ml-2 mb-1 remove_exp">-</a> --}}
                                    </strong>
                                    <input type="text" name="experience[]" class="form-control experience"
                                        placeholder="Add Experience">
                                    <span class="text-danger experience_error"></span>
                                    <div id="edit_dynamic_div" class="edit_dynamic_div">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Picture :</strong>
                                    <input type="file" name="image" id="image"
                                        class="form-control image" placeholder="image">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Company : <span class="text-danger">*</span></strong>
                                    <select class="form-control form-select company" name="company"
                                        aria-label="Default select example">
                                        <option selected disabled value="">Open this select menu</option>
                                        @foreach ($comps as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                        @endforeach
                                    </select>
                                        <span class="text-danger company_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Message :</strong>
                                    <input type="text" name="message" class="form-control message"
                                        placeholder="Write Message">
                                        <span class="text-danger message_error">{{ $errors->first('message') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-2">
                            <button class="btn btn-success btn-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
